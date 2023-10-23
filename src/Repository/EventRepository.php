<?php

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Event>
 *
 * @method Event|null find($id, $lockMode = null, $lockVersion = null)
 * @method Event|null findOneBy(array $criteria, array $orderBy = null)
 * @method Event[]    findAll()
 * @method Event[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }


    public function findEventsAfterToday($companyId)
    {
        $qb = $this->createQueryBuilder('e');
        $qb->where('e.company = :companyId')
            ->andWhere('e.start_date >= :today')
            ->andWhere('DATE_SUB(e.start_date, e.display_time_period, \'day\') <= :today')
            ->OrderBy('e.start_date', 'ASC')
            ->setParameter('companyId' , $companyId)
            ->setParameter('today', new \DateTime(), \Doctrine\DBAL\Types\Types::DATETIME_MUTABLE);
        return $qb->getQuery()->getResult();
    }
}
