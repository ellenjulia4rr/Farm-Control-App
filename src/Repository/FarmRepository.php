<?php

namespace App\Repository;

use App\Entity\Farm;
use App\Filters\FarmFilter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

class FarmRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Farm::class);
    }

    public function getFarmsByFilter(FarmFilter $filter): array
    {
        $qb =$this->getQueryBuilderByFilter($filter);

        return $qb->getQuery()->getResult();
    }

    public function getCountFarmsByFilter(FarmFilter $filter) : array
    {
        $qb = $this->getQueryBuilderByFilter($filter);
        $qb->select("count(distinct farms.id) as qtde");

        return $qb->getQuery()->getResult();
    }

    public function getnameAndId(Farm $farm) : ?Farm
    {
        $qb = $this->createQueryBuilder('farms');
        $qb
            ->andWhere('farms.nome = :nome')
            ->andWhere('farms.id != :id')
            ->setParameter('nome', $farm->getNome())
            ->setParameter('id', $farm->getId());

        return $qb->getQuery()->getOneOrNullResult();
    }


    private function getQueryBuilderByFilter(FarmFilter $filter): QueryBuilder
    {
        $qb = $this->createQueryBuilder('farms');

        if($filter->getNome())
            $qb
                ->andWhere('farms.nome LIKE :nome')
                ->setParameter('nome', "%{$filter->getNome()}%")
            ;

        if($filter->getTamanho())
            $qb
                ->andWhere('farms.tamanho = :tamanho')
                ->setParameter('tamanho', $filter->getTamanho())
            ;

        if($filter->getResponsavel())
            $qb
                ->andWhere('farms.responsavel LIKE :responsavel')
                ->setParameter('responsavel', "%{$filter->getResponsavel()}%")
            ;

        if($filter->getVeterinarios())
            $qb
                ->join('farms.veterinarios', 'veterinarios')
                ->andWhere('veterinarios.id IN (:id)')
                ->setParameter('id', $filter->getVeterinarios()->toArray())
            ;

        return $qb;
    }
}