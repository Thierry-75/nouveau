<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @extends ServiceEntityRepository<Article>
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry,private readonly PaginatorInterface $paginator)
    {
        parent::__construct($registry, Article::class);

    }

    /**
     * @return array
     */
    public function findPublished(): array
    {
        return $this->createQueryBuilder('a')
            ->where('a.isPublished LIKE :state')
            ->setParameter('state','%1%')
            ->orderBy('a.createdAt','DESC')
            ->setMaxResults(6)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param int $page
     * @return PaginationInterface
     */
    public function findAllVerified(int $page): PaginationInterface
    {
        $data = $this->createQueryBuilder('a')
            ->where('a.isPublished LIKE :state')
            ->setParameter('state','%1%')
            ->orderBy('a.title','DESC')
            ->getQuery()
            ->getResult();
        return $this->paginator->paginate( $data, $page,6);

    }

}
