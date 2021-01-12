<?php

namespace App\Controller;


    use App\Document\Room;
    use App\Form\RoomType;
    use App\Form\RoomSearchType;
    use Doctrine\ODM\MongoDB\DocumentManager;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\JsonResponse;
    use Symfony\Component\HttpFoundation\RedirectResponse;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;

class RoomController extends AbstractController
{
    /**
     * @Route("/admin", name="admin.room.index")
     * @param DocumentManager $dm
     * @param Request $request
     * @return Response
     */
    public function index(DocumentManager $dm, Request $request)
    {
        $search = new Room();
        $form = $this->createForm(RoomSearchType::class, $search);
        $form->handleRequest($request);
        $rooms = $dm->getRepository(Room::class)->getResultSearch($search);
        //dd($rooms);
        // $this->repository->paginateAllVisible($search, $request->query->getInt('page', 1))
        return $this->render('room/index.html.twig', [
            'rooms' => $rooms,
            'form' => $form->createView()
        ]);

        // return $this->render('room/index.html.twig', compact('rooms'));
    }

    /**
     * @Route("/admin/room/create", name="admin.room.new")
     * @param Request $request
     * @param DocumentManager $dm
     * @return RedirectResponse|Response
     */
    public function new(Request $request,DocumentManager $dm)
    {
        $room = new Room();
        $form = $this->createForm(RoomType::class, $room);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $dm->persist($room);
            $dm->flush();
            $this->addFlash('success', 'Room creé avec success');
            return $this->redirectToRoute('admin.room.index');
        }
        return $this->render('room/new.html.twig', [
            'room' => $room,
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/admin/room/{id}", name="admin.room.edit", methods={"GET|POST"})
     * @param $id
     * @param Request $request
     * @param DocumentManager $dm
     * @return Response
     * @throws \Doctrine\ODM\MongoDB\MongoDBException
     */
    public function edit($id, Request $request,DocumentManager $dm)
    {
        $room = $dm->getRepository(Room::class)->find($id);
        $form = $this->createForm(RoomType::class, $room);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $dm->flush();
            $this->addFlash('success', 'Room modifié avec success');
            return $this->redirectToRoute('admin.room.index');
        }
        return $this->render('room/edit.html.twig', [
            'room' => $room,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/room/{id}", name="admin.room.delete", methods={"DELETE"})
     * @param string $id
     * @param Request $request
     * @param DocumentManager $dm
     * @return RedirectResponse
     * @throws \Doctrine\ODM\MongoDB\MongoDBException
     */
    public function delete($id, Request $request,DocumentManager $dm)
    {
        $room = $dm->getRepository(Room::class)->find($id);
        if ($this->isCsrfTokenValid('delete'.$room->getId(), $request->get('_token'))){
            $dm->remove($room);
            $dm->flush();
            $this->addFlash('success', 'Room supprimé avec success');
        }
        return $this->redirectToRoute('admin.room.index');

    }

    /**
     * @Route("/admin/load-data", name="admin.room.load.data")
     * @param DocumentManager $dm
     * @return Response
     */
    public function loadData(DocumentManager $dm)
    {
        $styles = ['Méditerranée', 'Scandinave', 'Jungle','Nature', 'Papier peint'];
        $clients = ['Marc Dupont', 'Julie Martin', 'Alice Bernard', 'Louise Robert' , 'Gabriel Dubois', 'Léo Michel'];
        // create rooms
        for ($i = 1; $i <= 10000; $i++) {
            $room = new Room();
            $room->setStatus("Approved");
            $room->setPublished(true);
            $room->setName("Room ".$i);
            $room->setDescription("Description de la Room ".$i);
            $room->setClient($clients[mt_rand(0, 5)]);
            $room->setNumeroCommande("CDE-LM-0". mt_rand(10, 100));
            $room->setStyle($styles[mt_rand(0, 4)]);
            $dm->persist($room);
        }

        $dm->flush();

        return new JsonResponse('ok');
    }
}
