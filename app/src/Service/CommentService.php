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
     * @param Comment $Comment Comment
     */
    public function save(Comment $Comment): void
    {
        if (null == $Comment->getId()) {
            $Comment->setCreatedAt(new \DateTimeImmutable());
        }

        $this->commentRepository->save($Comment);
    }

    /**
     * Delete.
     *
     * @param Comment $Comment Comment
     */
    public function delete(Comment $Comment): void
    {
        $this->commentRepository->delete($Comment);
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
