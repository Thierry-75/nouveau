<?php

namespace App\Repository;

use App\Entity\Article;
use App\Entity\Category;
use App\Model\SearchData;
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
    public function findLastArticles(): array
    {
        return $this->createQueryBuilder('a')
            ->where('a.isPublished LIKE :state')
            ->setParameter('state','%1%')
            ->orderBy('a.createdAt','DESC')
            ->setMaxResults(6)
            ->getQuery()
            ->getResult();
    }

    public function findAllVerified(int $page, ?Category $category =null): PaginationInterface
    {
        $data = $this->createQueryBuilder('a')
            ->where('a.isPublished LIKE :state')
            ->setParameter('state','%1%')
            ->orderBy('a.title','DESC');

            if(isset($category)){
                $data = $data
                    ->join('a.categories','c')
                    ->andWhere(':category IN (c)')
                    ->setParameter('category',$category);
            }
            $data->getQuery()
                 ->getResult();

        return $this->paginator->paginate( $data, $page,6);
    }

    public function findBySearch(SearchData $searchData): PaginationInterface
    {
        $data = $this->createQueryBuilder('a')
            ->where('a.isPublished LIKE :state')
            ->setParameter('state', '%1%')
            ->addOrderBy('a.createdAt','DESC');

        if (!empty($searchData->categories)){
            $data = $data
                ->join('a.categories','c')
                ->andWhere('c.id IN (:categories)')
                ->setParameter('categories',$searchData->categories);
        }

        $data  = $data
            ->getQuery()
            ->getResult();
        return $this->paginator->paginate($data, $searchData->page,6);
    }

}
