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
     * portail affiche les derniers articles récents
     * @return array
     */
    public function findLastArticles(): array
    {
        return $this->createQueryBuilder('a')
            ->where('a.isPublished LIKE :state')
            ->setParameter('state','%1%')
            ->orderBy('a.createdAt','DESC')
            ->setMaxResults(9)
            ->getQuery()
            ->getResult();
    }

    /**
     * tous les articles
     * @param int $page
     * @param Category|null $category
     * @return PaginationInterface
     */
    public function findPublished(int $page, ?Category $category =null): PaginationInterface
    {
        $data = $this->createQueryBuilder('a')
            ->where('a.isPublished LIKE :state')
            ->setParameter('state','%1%')
            ->orderBy('a.createdAt','DESC');

            if(isset($category)){
                $data = $data
                    ->join('a.category','c')
                    ->andWhere(':category IN (c)')
                    ->setParameter('category',$category);
            }
            $data->getQuery()
                 ->getResult();

        return $this->paginator->paginate( $data, $page,9);
    }

    /**
     * affiche articles par categories
     * @param SearchData $searchData
     * @return PaginationInterface
     */
    public function findBySearch(SearchData $searchData): PaginationInterface
    {
        $data = $this->createQueryBuilder('a')
            ->where('a.isPublished LIKE :state')
            ->setParameter('state', '%1%')
            ->addOrderBy('a.title','DESC');

        if (!empty($searchData->categories)){
            $data = $data
                ->join('a.category','c')
                ->andWhere('c.id IN (:categories)')
                ->setParameter('categories',$searchData->categories);
        }

        $data  = $data
            ->getQuery()
            ->getResult();
        return $this->paginator->paginate($data, $searchData->page,9);
    }

}
