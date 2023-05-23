<?php

namespace App\Repository;

use App\Entity\Projects;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Projects>
 *
 * @method Projects|null find($id, $lockMode = null, $lockVersion = null)
 * @method Projects|null findOneBy(array $criteria, array $orderBy = null)
 * @method Projects[]    findAll()
 * @method Projects[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Projects::class);
    }

    public function save(Projects $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Projects $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
    * @return Projects[] Returns an array of Projects objects
    */
    public function findByFilter($filter = [], $perpage = 10): array
    {
        $query = $this->createQueryBuilder('p');

        if (isset($filter['page']) && $filter['page'] > 1) {
            $offset = ($filter['page'] - 1) * $perpage;
            $query = $query->setFirstResult($offset);
        }

        return $query
            ->orderBy('p.createdAt', 'DESC')
            ->setMaxResults($perpage)
            ->getQuery()
            ->getResult();
    }

    /**
    * @return int
    */
    public function countAll(): int
    {
        return $this->createQueryBuilder('p')
            ->select('count(p.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }   

    /**
    * @return Projects[] Returns an array of Projects objects
    */
    public function findSimilar(Projects $project, $nbResult = 4): array
    {
        $categoryIds = [];
        foreach ($project->getCategorie() as $cat) {
            array_push($categoryIds, $cat->getId());
        }
        return $this->createQueryBuilder('p')
            ->andWhere('p.id != :id')
            ->setParameter('id', $project->getId())
            ->leftJoin('p.categorie', 'c')
            ->andWhere('c.id IN (:categories)')
            ->setParameter('categories', $categoryIds)
            ->setMaxResults($nbResult)
            ->orderBy('p.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

//    public function findOneBySomeField($value): ?Projects
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
