<?php

namespace App\Repository;

use App\Entity\Semester;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Semester>
 *
 * @method Semester|null find($id, $lockMode = null, $lockVersion = null)
 * @method Semester|null findOneBy(array $criteria, array $orderBy = null)
 * @method Semester[]    findAll()
 * @method Semester[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SemesterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Semester::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Semester $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Semester $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @return Semester[] Returns an array of Semester objects
      */
    
    public function search($keyword)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.name LIKE :key')
            ->setParameter('key', '%' . $keyword . '%')
            ->orderBy('s.name', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    

    
    public function sortSemesterASC()
    {
        return $this->createQueryBuilder('s')
            ->orderBy('s.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
    public function sortSemesterDESC()
    {
        return $this->createQueryBuilder('s')
            ->orderBy('s.id', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }
    
}