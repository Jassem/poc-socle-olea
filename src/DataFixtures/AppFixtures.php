<?php

namespace App\DataFixtures;

use App\Document\Room;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // create rooms
        for ($i = 1; $i < 10; $i++) {
            $room = new Room();
            $room->setStatus("Approved");
            $room->setPublished(true);
            $room->setName("Room ".$i);
            $room->setDescription("Description Room ".$i);
            $room->setClient("Marc Dupont");
            $room->setNumeroCommande("CDE-LM-0". mt_rand(10, 100));
            $room->setStyle("Méditerranée");
            $manager->persist($room);
        }

        $manager->flush();
    }
}
