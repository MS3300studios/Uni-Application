<?php

/**
 *
 * PostRepository.
 *
 */
namespace App\Repository;

use App\Entity\Post;
use App\Entity\PostCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class PostRepository.
 *
 * @extends ServiceEntityRepository<Post>
 *
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    /**
     *
     * Items per page.
     *
     */
    public const PAGINATOR_ITEMS_PER_PAGE = 10;

    /**
     * Constructor.
     *
     * @param ManagerRegistry $registry Manager Registry
     *
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    /**
     * Query all.
     *
     * @param array $filters
     *
     * @return QueryBuilder
     *
     */
    public function queryAll(array $filters): QueryBuilder
    {
        $queryBuilder = $this->getOrCreateQueryBuilder()
            ->select('partial post.{id, createdAt, title, content}', 'partial postCategory.{id, name}')
            ->join('post.postCategory', 'postCategory')
            ->orderBy('post.createdAt', 'DESC');

        return $this->applyFiltersToList($queryBuilder, $filters);
    }

    /**
     * Apply filters to list.
     *
     * @param QueryBuilder $queryBuilder
     * @param array        $filters
     *
     * @return QueryBuilder
     *
     */
    private function applyFiltersToList(QueryBuilder $queryBuilder, array $filters = []): QueryBuilder
    {
        if (isset($filters['postCategory']) && $filters['postCategory'] instanceof PostCategory) {
            $queryBuilder->andWhere('postCategory = :postCategory')
                ->setParameter('postCategory', $filters['postCategory']);
        }

        return $queryBuilder;
    }

    /**
     * Get or create query builder.
     *
     * @param QueryBuilder|null $queryBuilder
     *
     * @return QueryBuilder
     *
     */
    private function getOrCreateQueryBuilder(QueryBuilder $queryBuilder = null): QueryBuilder
    {
        return $queryBuilder ?? $this->createQueryBuilder('post');
    }

    /**
     * Add.
     *
     * @param Post $entity
     * @param bool $flush
     *
     * @return void
     *
     */
    public function add(Post $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Remove.
     *
     * @param Post $entity
     * @param bool $flush
     *
     * @return void
     *
     */
    public function remove(Post $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Count by category.
     *
     * @param PostCategory $postCategory
     *
     * @return int
     *
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     *
     */
    public function countByCategory(PostCategory $postCategory): int
    {
        $qrBldr = $this->getOrCreateQueryBuilder();

        return $qrBldr->select($qrBldr->expr()->countDistinct('post.id'))
            ->where('post.postCategory = :postCategory')
            ->setParameter(':postCategory', $postCategory)
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * Save.
     *
     * @param Post $post
     *
     * @return void
     *
     */
    public function save(Post $post): void
    {
        $this->_em->persist($post);
        $this->_em->flush();
    }

    /**
     * Delete.
     *
     * @param Post $post
     *
     * @return void
     *
     */
    public function delete(Post $post): void
    {
        $this->_em->remove($post);
        $this->_em->flush();
    }
}
