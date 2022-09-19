<?php
/**
 * CommentServiceInterface,.
 */

namespace App\Service;

use App\Entity\Comment;
use Knp\Component\Pager\Pagination\PaginationInterface;

/**
 * Interface CommentServiceInterface.
 */
interface CommentServiceInterface
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
     * @param Comment $comment Comment
     */
    public function save(Comment $comment): void;

    /**
     * Delete.
     *
     * @param Comment $comment Comment
     */
    public function delete(Comment $comment): void;

    /**
     * Find one by post id.
     *
     * @param int $page   page
     * @param int $postId postId
     *
     * @return PaginationInterface Paginated list
     */
    public function findManyByPostId(int $page, int $postId): ?PaginationInterface;
}
