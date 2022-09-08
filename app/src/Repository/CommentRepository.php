<?php
/**
 *
 * CommentRepository.
 *
 */
namespace App\Repository;

use App\Entity\Comment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class CommentRepository.
 *
 * @extends ServiceEntityRepository<Comment>
 *
 * @method Comment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comment[]    findAll()
 * @method Comment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentRepository extends ServiceEntityRepository
{

    /**
     *
     * Items per page
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
        parent::__construct($registry, Comment::class);
    }

    /**
     * Query all.
     *
     * @return QueryBuilder
     *
     */
    public function queryAll(): QueryBuilder
    {
        return $this->getOrCreateQueryBuilder()
            ->orderBy('Comment.createdAt', 'DESC');
    }

    /**
     * Get or create query builder.
     *
     * @param QueryBuilder|null $queryBuilder
     * @return QueryBuilder
     *
     */
    private function getOrCreateQueryBuilder(QueryBuilder $queryBuilder = null): QueryBuilder
    {
        return $queryBuilder ?? $this->createQueryBuilder('comment');
    }

    /**
     * Add.
     *
     * @param Comment $entity
     * @param bool $flush
     * @return void
     *
     */
    public function add(Comment $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Remove.
     *
     * @param Comment $entity
     * @param bool $flush
     * @return void
     *
     */
    public function remove(Comment $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Save.
     *
     * @param Comment $comment
     * @return void
     *
     */
    public function save(Comment $comment): void
    {
        $this->_em->persist($comment);
        $this->_em->flush();
    }

    /**
     * Delete.
     *
     * @param Comment $comment
     * @return void
     *
     */
    public function delete(Comment $comment): void
    {
        $this->_em->remove($comment);
        $this->_em->flush();
    }

    /**
     * find many comments by post id.
     *
     * @param int $postId
     * @return QueryBuilder
     *
     */
    public function findManyByPostId(int $postId): QueryBuilder
    {
        $queryBuilder = $this->getOrCreateQueryBuilder()
            ->select('partial comment.{id, nick, email, content, Post, createdAt}')
            ->where('comment.Post = :postId')
            ->setParameter(':postId', $postId)
            ->orderBy('comment.createdAt', 'DESC');
        return $queryBuilder;
    }
}