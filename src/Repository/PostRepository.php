<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends BaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    /**
     *
     * @param integer $currentPage The current page (passed from controller)
     *
     * @return \Doctrine\ORM\Tools\Pagination\Paginator
     */
    public function getAllPostsPaginated($currentPage = 1)
    {
        // Create our query
        $query = $this->createQueryBuilder('p')
            ->orderBy('p.createdAt', 'DESC')
            ->getQuery();

        $paginator = $this->paginateByPage($query, $currentPage);

        return $paginator;
    }

    /**
     *
     * @param integer $currentPage The current page (passed from controller)
     *
     * @return \Doctrine\ORM\Tools\Pagination\Paginator
     */
    public function getAllPostsPaginatedByOffset(int $offset = 0, int $limit = self::PAGINATION_DEFAULT_LIMIT)
    {
        // Create our query
        $query = $this->createQueryBuilder('p')
            ->orderBy('p.createdAt', 'DESC')
            ->getQuery();

        $paginator = $this->paginate($query, $offset, $limit);

        return $paginator;
    }
}
