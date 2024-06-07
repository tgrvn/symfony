<?php

namespace App\Services\Facrories;

use App\Entity\UrlCodePair;
use App\Repository\UrlCodePairRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

class UrlCodePairFactory
{
    /**
     * @var UrlCodePairRepository
     */
    protected ObjectRepository $repository;
    public function __construct(
        protected EntityManagerInterface $em,
    )
    {
        $this->repository = $this->em->getRepository(UrlCodePair::class);
    }
    public function fromData(string $url, string $code): UrlCodePair
    {
        $entity = new UrlCodePair($url, $code);
        $this->em->persist($entity);
        $this->em->flush();

        return $entity;
    }
}