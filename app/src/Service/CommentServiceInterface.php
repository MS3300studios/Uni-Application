<?php
/**
 *
 * CommentServiceInterface,
 *
 */
namespace App\Service;

use App\Entity\Comment;
use Knp\Component\Pager\Pagination\PaginationInterface;

/**
 *
 * Interface CommentServiceInterface.
 *
 */
interface CommentServiceInterface
{
    /**
     * Get paginated list.
     *
     * @param int $page
     * @return PaginationInterface
     *
     */
    public function getPaginatedList(int $page): PaginationInterface;

    /**
     * Save.
     *
     * @param Comment $Comment
     * @return void
     *
     */
    public function save(Comment $Comment): void;

    /**
     * Delete.
     *
     * @param Comment $Comment
     * @return void
     *
     */
    public function delete(Comment $Comment): void;
    
    /**
     * Find one by post id.
     *
     * @param int $page
     * @param int $postId
     * @return PaginationInterface
     *
     */
    public function findManyByPostId(int $page, int $postId): ?PaginationInterface;
}