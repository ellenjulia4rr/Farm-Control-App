<?php

namespace App\Repository;

use App\Entity\Cow;
use App\Filters\CowFilter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

class CowRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cow::class);
    }

    public function slaughterAllCattle() :array
    {
        $bitth = new \DateTime('-5 years');
        $qb = $this->createQueryBuilder('cow');

        $qb
            ->andWhere(
                $qb->expr()->orX(
                    'cow.birth < :age',
                    'cow.milk < 40',
                    'cow.weight > 270',
                    $qb->expr()->andX(
                        'cow.milk < 70',
                        'cow.portion > 350'
                    )
                )
            )

            ->setParameter('age', $bitth->format('Y-m-d'))

        ;

        return $qb->getQuery()->getResult();
    }

    public function lookingForCattleForSlaughter($code) :array
    {
        $bitth = new \DateTime('-5 years');
        $qb = $this->createQueryBuilder('cow');

        $qb
            ->andWhere(
                $qb->expr()->orX(
                    'cow.birth < :age',
                    'cow.milk < 40',
                    'cow.weight > 270',
                    $qb->expr()->andX(
                        'cow.milk < 70',
                        'cow.portion > 350'
                    )
                )
            )
            ->andWhere('cow.code = :code')
            ->setParameter('age', $bitth->format('Y-m-d'))
            ->setParameter('code', $code);
        ;
        return $qb->getQuery()->getResult();
    }

    public function getCattleId(Cow $cow) : ?Cow
    {
        $qb = $this->createQueryBuilder('cows');
        $qb
            ->andWhere(
                $qb->expr()->andX(
                    'cows.farm = :farm',
                    'cows.code = :code',
                    'cows.live = :live',
                    'cows.id != :id'
                )
            )
            ->setParameter('farm', $cow->getFarm())
            ->setParameter('code', $cow->getCode())
            ->setParameter('live', true)
            ->setParameter('id', $cow->getId()?:0)
            ;

        return $qb
            ->getQuery()
            ->setMaxResults(1)
            ->getOneOrNullResult();

    }

    public function getAbattoirReport()
    {
        return$this->createQueryBuilder('cows')
            ->select('COUNT(cows.id) as abattoirCount')
            ->andWhere('cows.live = :morto')
            ->setParameter('morto', false)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function sumOfMilkProduced() : ?float
    {
        return $this->createQueryBuilder('cows')
            ->select('SUM(cows.milk) as totalMilk')
            ->where('cows.live = :live')
            ->setParameter('live', true)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function amountOfFeedNeeded() : ?float
    {
        return $this->createQueryBuilder('cows')
            ->select('SUM(cows.portion) as totalPortion')
            ->where('cows.live = :live')
            ->setParameter('live', true)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function countHighConsumptionOfYoungCattle() :int
    {
        $ageLimit = new \DateTime('-1 year');

        return $this->createQueryBuilder('cows')
            ->select('COUNT(cows.id) as TotalCows')
            ->andWhere(
                'cows.birth > :ageLimit',
                'cows.portion > 500',
                'cows.live = :live'
            )
            ->setParameter('ageLimit', $ageLimit->format('Y-m-d'))
            ->setParameter('live', true)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function getCountCowsByFilter(CowFilter $filter) : array
    {
        $qb = $this->getQueryBuilderByFilter($filter);
        $qb->select("count(distinct cows.id) as qtde");

        return $qb->getQuery()->getResult();
    }

    public function getCowsByFilter(CowFilter $filter):Query
    {
        $qb = $this->getQueryBuilderByFilter($filter);

        return $qb->getQuery();
    }

    private function getQueryBuilderByFilter(CowFilter $filter): QueryBuilder
    {

        $qb = $this->createQueryBuilder('cows');

        $bitth = new \DateTime('-5 years');

        if ($filter->getCode()) {
            $qb->andWhere('cows.code = :code')
                ->setParameter('code', $filter
                    ->getCode());
        }

        if ($filter->getLive() === 'ABATE') {
            $qb->andWhere(
                $qb->expr()->orX(
                    'cows.birth < :age',
                    'cows.milk < 40',
                    'cows.weight > 270',
                    $qb->expr()->andX(
                        'cows.milk < 70',
                        'cows.portion > 350'
                    )
                )
            )
                ->andWhere('cows.live = true')
                ->setParameter('age', $bitth->format('Y-m-d'));

        } elseif ($filter->getLive() === 'VIVO') {
            $qb->andWhere('cows.live = :vivo')
                ->setParameter('vivo', true);

        } elseif ($filter->getLive() === 'MORTO') {
            $qb->andWhere('cows.live = :morto')
                ->setParameter('morto', false);
        }

        if ($filter->getMilk())
            $qb
                ->andWhere('cows.milk >= :milk')
                ->setParameter('milk', $filter->getMilk());

        if ($filter->getWeight())
            $qb
                ->andWhere('cows.weight >= :weight')
                ->setParameter('weight', $filter->getWeight());

        if ($filter->getPortion())
            $qb
                ->andWhere('cows.portion >= :portion')
                ->setParameter('portion', $filter->getPortion());

        if ($filter->getBirth())
            $qb
                ->andWhere('cows.birth >= :birth')
                ->setParameter('birth', $filter->getBirth());

        if ($filter->getFarms() and count($filter->getFarms()))
            $qb
                ->join('cows.farm', 'farms')
                ->andWhere('farms.id IN (:farmId)')
                ->setParameter('farmId', $filter->getFarms()->toArray());


        return $qb;
    }
}