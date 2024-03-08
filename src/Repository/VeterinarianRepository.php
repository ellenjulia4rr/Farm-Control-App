<?php

namespace App\Repository;

use App\Entity\Veterinarian;
use App\Filters\VeterinarianFilter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

class VeterinarianRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Veterinarian::class);
    }

    public function getVeterinarianByFilter(VeterinarianFilter $filter): array
    {
        $qb = $this->getQueryBuilderByFilter($filter);

        return $qb->getQuery()->getResult();
    }

    public function getCountveterinarianByFilter(VeterinarianFilter $filter) : array
    {
        $qb = $this->getQueryBuilderByFilter($filter);
        $qb->select("count(distinct veterinarians.id) as qtde");

        return $qb->getQuery()->getResult();
    }

    public function getCrmvAndId(Veterinarian $veterinarian) : ?Veterinarian
    {
        $qb = $this->createQueryBuilder('veterinarians');
        $qb
            ->andWhere('veterinarians.crmv = :crmv')
            ->andWhere('veterinarians.id != :id')
            ->setParameter('crmv', $veterinarian->getCrmv())
            ->setParameter('id', $veterinarian->getId());

            return $qb->getQuery()->getOneOrNullResult();
    }

    private function getQueryBuilderByFilter(VeterinarianFilter $filter) :QueryBuilder
    {
        $qb = $this->createQueryBuilder('veterinarians');

        if($filter->getNome())
            $qb
                ->andWhere($qb->expr()->orX(
                    'veterinarians.nome LIKE :nome_crmv',
                    'veterinarians.crmv LIKE :nome_crmv'
                ))
                ->setParameter('nome_crmv', "%{$filter->getNome()}%")
            ;

        return $qb;
    }
}