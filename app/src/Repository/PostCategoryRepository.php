<?php
/**
 * PostCategoryRepository.
 */

namespace App\Repository;

use App\Entity\PostCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class PostCategoryRepository.
 *
 * @extends ServiceEntityRepository<PostCategory>
 *
 * @method PostCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method PostCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method PostCategory[]    findAll()
 * @method PostCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostCategoryRepository extends ServiceEntityRepository
{
    /**
     * Items per page.
     */
    public const PAGINATOR_ITEMS_PER_PAGE = 10;

    /**
     * Constructor.
     *
     * @param ManagerRegistry $registry Manager Registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PostCategory::class);
    }

    /**
     * Query all.
     *
     * @return QueryBuilder queryBuilder
     */
    public function queryAll(): QueryBuilder
    {
        return $this->getOrCreateQueryBuilder()
            ->orderBy('postCategory.createdAt', 'DESC');
    }

    /**
     * Add.
     *
     * @param PostCategory $entity entity
     * @param bool         $flush  flush
     */
    public function add(PostCategory $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Remove.
     *
     * @param PostCategory $entity entity
     * @param bool         $flush  flush
     */
    public function remove(PostCategory $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Save.
     *
     * @param PostCategory $postCategory postCategory
     */
    public function save(PostCategory $postCategory): void
    {
        $this->_em->persist($postCategory);
        $this->_em->flush();
    }

    /**
     * Delete.
     *
     * @param PostCategory $postCategory postCategory
     */
    public function delete(PostCategory $postCategory): void
    {
        $this->_em->remove($postCategory);
        $this->_em->flush();
    }

    /**
     * Get or create query builder.
     *
     * @param QueryBuilder|null $queryBuilder queryBuilder
     *
     * @return QueryBuilder queryBuilder
     */
    private function getOrCreateQueryBuilder(QueryBuilder $queryBuilder = null): QueryBuilder
    {
        return $queryBuilder ?? $this->createQueryBuilder('postCategory');
    }
}
