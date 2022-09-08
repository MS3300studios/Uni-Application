<?php
/**
 *
 * PostCategoryServiceInterface,
 *
 */
namespace App\Service;

use App\Entity\PostCategory;
use Knp\Component\Pager\Pagination\PaginationInterface;

/**
 *
 * Interface PostCategoryServiceInterface.
 *
 */
interface PostCategoryServiceInterface
{
    /**
     * Get paginated list.
     *
     * @param int $page
     *
     * @return PaginationInterface
     *
     */
    public function getPaginatedList(int $page): PaginationInterface;

    /**
     * Save.
     *
     * @param PostCategory $postCategory
     *
     * @return void
     *
     */
    public function save(PostCategory $postCategory): void;

    /**
     * Delete.
     *
     * @param PostCategory $postCategory
     *
     * @return void
     *
     */
    public function delete(PostCategory $postCategory): void;

    /**
     * Find one by id.
     *
     * @param int $id
     *
     * @return PostCategory|null
     *
     */
    public function findOneById(int $id): ?PostCategory;
}
