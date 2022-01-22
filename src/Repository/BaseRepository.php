<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
abstract class BaseRepository extends ServiceEntityRepository
{
    public const PAGINATION_DEFAULT_LIMIT = 20;

    /**
     * Paginate by page
     * @param Doctrine\ORM\Query $dql   DQL Query Object
     * @param integer            $page  Current page (defaults to 1)
     * @param integer            $limit The total number per page
     *
     * @return \Doctrine\ORM\Tools\Pagination\Paginator
     */
    protected function paginateByPage($dql, $page = 1, $limit = self::PAGINATION_DEFAULT_LIMIT)
    {
        $offset = $limit * ($page - 1);

        return $this->paginate($dql, $offset, $limit);
    }

    /**
     * Paginate by offset
     * @param Doctrine\ORM\Query $dql   DQL Query Object
     * @param integer            $offset  Current page (defaults to 0)
     * @param integer            $limit The total number per page 
     *
     * @return \Doctrine\ORM\Tools\Pagination\Paginator
     */
    protected function paginate($dql, int $offset = 0, int $limit = self::PAGINATION_DEFAULT_LIMIT)
    {
        $paginator = new Paginator($dql);

        $paginator->getQuery()
            ->setFirstResult($offset)
            ->setMaxResults($limit);

        return $paginator;
    }
}
