<?php

namespace App\Service;

use App\Entity\Post;
use Knp\Component\Pager\Pagination\PaginationInterface;

/**
 *
 * Interface AdServiceInterface.
 *
 */
interface PostServiceInterface
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
     * @param Post $post
     *
     * @return void
     *
     */
    public function save(Post $ad): void;

    public function delete(Post $post): void;
}
