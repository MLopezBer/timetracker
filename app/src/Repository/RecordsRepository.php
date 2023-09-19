<?php

namespace App\Repository;

use App\Entity\Records;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Records>
 *
 * @method Records|null find($id, $lockMode = null, $lockVersion = null)
 * @method Records|null findOneBy(array $criteria, array $orderBy = null)
 * @method Records[]    findAll()
 * @method Records[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecordsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Records::class);
    }

    /**
     * @param string $day
     * @return float|int|mixed|string
     */
    public function getTotalWorkedByDay(string $day)
    {
        $qb = $this->createQueryBuilder('r')
            ->select('r.totaltime')
            ->andWhere('(r.start < :today AND r.endtime > :today) OR (r.start > :today AND r.start < tomorrow)')
            ->setParameter('tomorrow', $day.'23:59:59')
            ->setParameter('today', $day.'00:00:0')
            ->getQuery();

        return $qb->getResult();
    }
}
