<?php
/**
 * CommentService.
 */

namespace App\Service;

use App\Entity\Comment;
use App\Repository\CommentRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Class CommentService.
 */
class CommentService implements CommentServiceInterface
{
    /**
     * CommentRepository.
     */
    private CommentRepository $commentRepository;

    /**
     * PaginatorInterface.
     */
    private PaginatorInterface $paginator;

    /**
     * Constructor.
     *
     * @param CommentRepository  $commentRepository comment Repository
     * @param PaginatorInterface $paginator         paginator
     */
    public function __construct(CommentRepository $commentRepository, PaginatorInterface $paginator)
    {
        $this->paginator = $paginator;
        $this->commentRepository = $commentRepository;
    }

    /**
     * Get paginated list.
     *
     * @param int $page page
     *
     * @return PaginationInterface Paginated list
     */
    public function getPaginatedList(int $page): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->commentRepository->queryAll(),
            $page,
            CommentRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Save.
     *
     * @param Comment $comment comment
     */
    public function save(Comment $comment): void
    {
        if (null === $comment->getId()) {
            $comment->setCreatedAt(new \DateTimeImmutable());
        }

        $this->commentRepository->save($comment);
    }

    /**
     * Delete.
     *
     * @param Comment $comment Comment
     */
    public function delete(Comment $comment): void
    {
        $this->commentRepository->delete($comment);
    }

    /**
     * Find many comments by post id.
     *
     * @param int $page   page
     * @param int $postId id of post
     *
     * @return PaginationInterface Paginated list
     */
    public function findManyByPostId(int $page, int $postId): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->commentRepository->findManyByPostId($postId),
            $page,
            CommentRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }
}
