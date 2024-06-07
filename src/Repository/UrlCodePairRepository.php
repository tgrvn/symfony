<?php

namespace App\Repository;

use App\Entity\UrlCodePair;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UrlCodePair|null find($id, $lockMode = null, $lockVersion = null)
 * @method UrlCodePair|null findOneBy(array $criteria, array $orderBy = null)
 * @method UrlCodePair[] findAll()
 * @method UrlCodePair[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UrlCodePairRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UrlCodePair::class);
    }
}
