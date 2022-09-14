<?php
/**
 * PostCategoryServiceInterface,.
 */

namespace App\Service;

use App\Entity\PostCategory;
use Knp\Component\Pager\Pagination\PaginationInterface;

/**
 * Interface PostCategoryServiceInterface.
 */
interface PostCategoryServiceInterface
{
    /**
     * Get paginated list.
     *
     * @param int $page page
     *
     * @return PaginationInterface Paginated list
     */
    public function getPaginatedList(int $page): PaginationInterface;

    /**
     * Save.
     *
     * @param PostCategory $postCategory post Category
     */
    public function save(PostCategory $postCategory): void;

    /**
     * Delete.
     *
     * @param PostCategory $postCategory post Category
     */
    public function delete(PostCategory $postCategory): void;

    /**
     * Find one by id.
     *
     * @param int $id id
     *
     * @return PostCategory|null Post Category or null
     */
    public function findOneById(int $id): ?PostCategory;
}
