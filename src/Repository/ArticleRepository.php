<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Article>
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
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

}
