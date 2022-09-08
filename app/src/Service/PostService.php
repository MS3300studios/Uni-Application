<?php
namespace App\Service;

use App\Entity\Post;
use App\Repository\PostRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 *
 * Class PostService.
 *
 */
class PostService implements PostServiceInterface
{
    /**
     * PostRepository.
     *
     * @var PostRepository
     *
     */
    private PostRepository $postRepository;

    /**
     * PaginatorInterface.
     *
     * @var PaginatorInterface
     *
     */
    private PaginatorInterface $paginator;

    /**
     * PostCategoryInterface.
     *
     * @var PostCategoryServiceInterface
     *
     */
    private PostCategoryServiceInterface $postCategoryService;

    /**
     * Constructor.
     *
     * @param PostRepository               $postRepository      Post repository
     * @param PaginatorInterface           $paginator           Paginator interface
     * @param PostCategoryServiceInterface $postCategoryService Post category service interface
     *
     */
    public function __construct(PostRepository $postRepository, PaginatorInterface $paginator, PostCategoryServiceInterface $postCategoryService)
    {
        $this->postRepository = $postRepository;
        $this->paginator = $paginator;
        $this->postCategoryService = $postCategoryService;
    }

    /**
     * Get paginated list.
     *
     * @param int   $page
     * @param array $filters
     *
     * @return PaginationInterface
     *
     */
    public function getPaginatedList(int $page, array $filters = []): PaginationInterface
    {
        $filters = $this->prepareFilters($filters);

        return $this->paginator->paginate(
            $this->postRepository->queryAll($filters),
            $page,
            PostRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Save.
     *
     * @param Post $post
     *
     * @return void
     *
     */
    public function save(Post $post): void
    {
        $this->postRepository->save($post);
    }

    /**
     * Delete.
     *
     * @param Post $post
     *
     * @return void
     *
     */
    public function delete(Post $post): void
    {
        $this->postRepository->delete($post);
    }

    /**
     * Prepare filters.
     *
     * @param array $filters
     *
     * @return array
     *
     */
    private function prepareFilters(array $filters): array
    {
        $resultFilters = [];
        if (!empty($filters['postCategory_id'])) {
            $postCategory = $this->postCategoryService->findOneById($filters['postCategory_id']);
            if (null !== $postCategory) {
                $resultFilters['postCategory'] = $postCategory;
            }
        }

        return $resultFilters;
    }
}
