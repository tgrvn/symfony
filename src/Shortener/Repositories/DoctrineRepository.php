<?php

namespace App\Shortener\Repositories;

use App\Entity\UrlCodePair;
use App\Repository\UrlCodePairRepository;
use App\Services\Facrories\UrlCodePairFactory;
use App\Shortener\Exceptions\DataNotFoundException;
use App\Shortener\Interfaces\IRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

class DoctrineRepository implements IRepository
{
    /**
     * @var UrlCodePairRepository
     */
    protected ObjectRepository $repository;

    public function __construct(
        protected EntityManagerInterface $em,
        protected UrlCodePairFactory     $factory
    )
    {
        $this->repository = $this->em->getRepository(UrlCodePair::class);
    }

    public function store(string $url, string $code): bool
    {
        try {
            $this->factory->fromData($url, $code);
            $result = true;
        } catch (\Throwable) {
            $result = false;
        }
        return $result;
    }

    public function getCode(string $url): string
    {
        return $this->getData(['url' => $url], 'code not found')->getCode();
    }

    public function getUrl(string $code): string
    {
        return $this->getData(['code' => $code], 'url not found')->getUrl();
    }

    public function codeIsset(string $code): bool
    {
        return (bool)$this->repository->findOneBy(['code' => $code]);
    }

    protected function getData(array $criteria, string $message): UrlCodePair
    {
        if (is_null($entity = $this->repository->findOneBy($criteria))) {
            throw new DataNotFoundException($message);
        }

        return $entity;
    }
}