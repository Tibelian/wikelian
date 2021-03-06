<?php

namespace App\Repository\Design;

use App\Entity\Design\Slider;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Slider|null find($id, $lockMode = null, $lockVersion = null)
 * @method Slider|null findOneBy(array $criteria, array $orderBy = null)
 * @method Slider[]    findAll()
 * @method Slider[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SliderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Slider::class);
    }

    /**
     * @return Slider[] Returns an array of Menu objects
     */
    public function homepage()
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.position LIKE :val')
            ->andWhere('s.isEnabled = true')
            ->setParameter('val', '%homepage%')
            ->orderBy('s.id', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Slider[] Returns an array of Menu objects
     */
    public function categorypage()
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.position LIKE :val')
            ->andWhere('s.isEnabled = true')
            ->setParameter('val', '%categorypage%')
            ->orderBy('s.id', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Slider[] Returns an array of Menu objects
     */
    public function postpage()
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.position LIKE :val')
            ->andWhere('s.isEnabled = true')
            ->setParameter('val', '%postpage%')
            ->orderBy('s.id', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return Slider[] Returns an array of Slider objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Slider
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
