<?php
/**
 * PostServiceInterface.
 */
namespace App\Service;

use App\Entity\Post;
use Knp\Component\Pager\Pagination\PaginationInterface;

/**
 * Interface AdServiceInterface.
 */
interface PostServiceInterface
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
     * @param Post $post post
     */
    public function save(Post $post): void;

    /**
     * Delete.
     *
     * @param Post $post post
     */
    public function delete(Post $post): void;
}
