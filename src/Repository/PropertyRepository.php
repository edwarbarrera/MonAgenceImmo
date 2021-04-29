<?php

namespace App\Repository;

use App\Entity\Property;
use App\Entity\PropertySearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Property|null find($id, $lockMode = null, $lockVersion = null)
 * @method Property|null findOneBy(array $criteria, array $orderBy = null)
 * @method Property[]    findAll()
 * @method Property[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropertyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Property::class);
    }
    

    /**
     * @return Query
     */
    public function findAllVisibleQuery(PropertySearch $search): Query
    {
       $query= $this->findVisibleQuery();

       if($search->getMaxPrice())
       {
           $query=$query
           ->andwhere('p.price <=  :maxprice')
           ->setParameter('maxprice', $search->getMaxPrice());
       }
       
        if($search->getMinSurface())
        {
            $query=$query
            ->andwhere('p.surface >= :minsurface')
            ->setParameter('minsurface', $search->getMinSurface());
        }
         return $query->getQuery();
          
    }

    /**
     * @return Property []
     */
    public function findLatest(): array
    {
        return $this->findVisibleQuery()
            ->setMaxResults(4)
            ->getQuery()
            ->getResult();
    }


    /**
     * @return Property []
     */
    private function findVisibleQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('p')
            ->where('p.sold=false');
    }

}