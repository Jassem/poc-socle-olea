<?php
namespace App\Repository;

use App\Document\Room;
use Doctrine\ODM\MongoDB\Repository\DocumentRepository;
use MongoDB\BSON\Regex;

class RoomRepository extends DocumentRepository
{

    public function getResultSearch(Room $search)
    {
        /*return $this->createQueryBuilder()
            ->sort('name', 'ASC')
            ->getQuery()
            ->execute();*/
        $query = $this->createQueryBuilder('r');


        if ($search->getClient() && $search->getClient() !== '')
        {
            $query
                ->field('client')
                ->equals(new Regex($search->getClient(), 'i'));
        }
        if ($search->getName() && $search->getName() !== '')
        {
            $query
                ->field('name')
                ->equals(new Regex($search->getName(), 'i'));
        }

        if ($search->getStyle() && $search->getStyle() !== '')
        {
            $query
                ->field('style')
                ->equals(new Regex($search->getStyle(), 'i'));
        }

        if ($search->getNumeroCommande() && $search->getNumeroCommande() !== '')
        {
            $query
                ->field('numeroCommande')
                ->equals(new Regex($search->getNumeroCommande(), 'i'));
        }

        $res = $query->getQuery()->execute();

        /*if ( $search->getClient())
        {
            $query = $query
                ->andWhere('r.client <= :maxprice')
                ->setParameter('maxprice', $search->getMaxPrice());
        }*/

        return $res;
    }
}