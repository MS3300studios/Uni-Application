<?php
/**
 *
 * CommentService.
 *
 */
namespace App\Service;


use App\Entity\Comment;
use App\Repository\CommentRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use App\Repository\PostRepository;

/**
 *
 * Class CommentService.
 *
 */
class CommentService implements CommentServiceInterface
{
    /**
     * CommentRepository.
     *
     * @var CommentRepository
     *
     */
    private CommentRepository $CommentRepository;

    /**
     * PaginatorInterface.
     *
     * @var PaginatorInterface
     *
     */
    private PaginatorInterface $paginator;

    /**
     * PostRepository.
     *
     * @var PostRepository
     *
     */
    private PostRepository $postRepository;

    /**
     * Constructor.
     *
     * @param CommentRepository $CommentRepository
     * @param PaginatorInterface $paginator
     * @param PostRepository $postRepository
     *
     */
    public function __construct(CommentRepository $CommentRepository, PaginatorInterface $paginator, PostRepository $postRepository)
    {
        $this->paginator = $paginator;
        $this->CommentRepository = $CommentRepository;
        $this->postRepository = $postRepository;
    }

    /**
     * Get paginated list.
     *
     * @param int $page
     * @return PaginationInterface
     *
     */
    public function getPaginatedList(int $page): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->CommentRepository->queryAll(),
            $page,
            CommentRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Save.
     *
     * @param Comment $Comment
     * @return void
     *
     */
    public function save(Comment $Comment): void
    {
        if(null == $Comment->getId()) {
            $Comment->setCreatedAt(new \DateTimeImmutable());
        }

        $this->CommentRepository->save($Comment);
    }

    /**
     * Delete.
     *
     * @param Comment $Comment
     * @return void
     *
     */
    public function delete(Comment $Comment): void
    {
        $this->CommentRepository->delete($Comment);
    }

    /**
     * Find many comments by post id.
     *
     * @param int $page
     * @param int $postId
     * @return PaginationInterface
     *
     */
    public function findManyByPostId(int $page, int $postId): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->CommentRepository->findManyByPostId($postId),
            $page,
            CommentRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }
}