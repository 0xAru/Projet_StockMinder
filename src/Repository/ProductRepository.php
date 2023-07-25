<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\String\Slugger\SluggerInterface;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @extends ServiceEntityRepository<Product>
 *
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, SluggerInterface $slugger, EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, Product::class);
        $this->entityManager = $entityManager;
    }

        public function findProductByKeyword($searchTerm): array
    {


        return $this->createQueryBuilder('p')

            ->orWhere('p.name LIKE :searchTerm')
            ->orWhere('p.style LIKE :searchTerm')
            ->orWhere('p.origin LIKE :searchTerm')
            ->orWhere('p.brand LIKE :searchTerm')
            ->orWhere('p.capacity LIKE :searchTerm')
           ->setParameter('searchTerm', "%".$searchTerm."%")
            ->getQuery()
            ->getResult()
        ;
    }

    public function findUniqueStyles(): array
    {
        $query = $this->entityManager->createQueryBuilder()
            ->select('DISTINCT p.style')
            ->from(Product::class, 'p')
            ->getQuery();

        return array_map('current', $query->getScalarResult());
    }

    public function findUniqueOrigins(): array
    {
        $query = $this->entityManager->createQueryBuilder()
            ->select('DISTINCT p.origin')
            ->from(Product::class, 'p')
            ->getQuery();

        return array_map('current', $query->getScalarResult());
    }

    public function findUniqueBrands(): array
    {
        $query = $this->entityManager->createQueryBuilder()
            ->select('DISTINCT p.brand')
            ->from(Product::class, 'p')
            ->getQuery();

        return array_map('current', $query->getScalarResult());
    }

    public function findUniqueCapacities(): array
    {
        $query = $this->entityManager->createQueryBuilder()
            ->select('DISTINCT p.capacity / 10 AS divided_capacity')
            ->from(Product::class, 'p')
            ->getQuery();

        return array_map('current', $query->getScalarResult());
    }

//    /**
//     * @return Product[] Returns an array of Product objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Product
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
    public function findByFilters($data)
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();

        $qb->select('p')
            ->from(Product::class, 'p');

        // Filtrage par style
        if ($data->getStyle()) {
            $qb->andWhere('p.style = :style')
                ->setParameter('style', $data->getStyle());
        }

        // Filtrage par provenance
        if ($data->getOrigin()) {
            $qb->andWhere('p.origin = :origin')
                ->setParameter('origin', $data->getOrigin());
        }

        // Filtrage par marque
        if ($data->getBrand()) {
            $qb->andWhere('p.brand = :brand')
                ->setParameter('brand', $data->getBrand());
        }

        // Filtrage par contenance
        if ($data->getCapacity()) {
            $qb->andWhere('p.capacity = :capacity')
                ->setParameter('capacity', $data->getCapacity());
        }

        return $qb->getQuery()->getResult();
    }
}
