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

    public function findProductsByCompany($companyId): array
    {
        return $this->createQueryBuilder('p')
            ->where('p.company = :companyId')
            ->setParameter('companyId', $companyId)
            ->getQuery()
            ->getResult();
    }


    public function findProductByKeyword($searchTerm, $companyId): array
    {
        return $this->createQueryBuilder('p')
            ->where('p.company = :companyId')
            ->andWhere('p.name LIKE :searchTerm OR p.style LIKE :searchTerm OR p.origin LIKE :searchTerm OR p.brand LIKE :searchTerm OR p.capacity LIKE :searchTerm')
            ->setParameter('companyId', $companyId)
            ->setParameter('searchTerm', "%" . $searchTerm . "%")
            ->getQuery()
            ->getResult();
    }

    public function findUniqueStyles($companyId): array
    {
        $query = $this->entityManager->createQueryBuilder()
            ->select('DISTINCT p.style')
            ->from(Product::class, 'p')
            ->where('p.company = :companyId')
            ->setParameter('companyId', $companyId)
            ->getQuery();

        return array_map('current', $query->getScalarResult());
    }

    public function findUniqueOrigins($companyId): array
    {
        $query = $this->entityManager->createQueryBuilder()
            ->select('DISTINCT p.origin')
            ->from(Product::class, 'p')
            ->where('p.company = :companyId')
            ->setParameter('companyId', $companyId)
            ->getQuery();

        return array_map('current', $query->getScalarResult());
    }

    public function findUniqueBrands($companyId): array
    {
        $query = $this->entityManager->createQueryBuilder()
            ->select('DISTINCT p.brand')
            ->from(Product::class, 'p')
            ->where('p.company = :companyId')
            ->setParameter('companyId', $companyId)
            ->getQuery();

        return array_map('current', $query->getScalarResult());
    }

    public function findUniqueCapacities($companyId): array
    {
        $query = $this->entityManager->createQueryBuilder()
            ->select('DISTINCT p.capacity')
            ->from(Product::class, 'p')
            ->where('p.company = :companyId')
            ->setParameter('companyId', $companyId)
            ->getQuery();

        return array_map('current', $query->getScalarResult());
    }

    public function findUniqueLabels($companyId): array
    {
        $query = $this->entityManager->createQueryBuilder()
            ->select('DISTINCT p.label')
            ->from(Product::class, 'p')
            ->where('p.company = :companyId')
            ->setParameter('companyId', $companyId)
            ->getQuery();

        return array_map('current', $query->getScalarResult());
    }

    public function findByFilters($data, $companyId)
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();

        $qb->select('p')
            ->from(Product::class, 'p')
            ->where('p.company = :companyId')
            ->setParameter('companyId', $companyId);

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
