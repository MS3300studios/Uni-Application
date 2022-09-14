<?php

/**
 *  Post Service.
 */

namespace App\Service;

use App\Entity\Post;
use App\Repository\PostRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Class PostService.
 */
class PostService implements PostServiceInterface
{
    /**
     * PostRepository.
     */
    private PostRepository $postRepository;

    /**
     * PaginatorInterface.
     */
    private PaginatorInterface $paginator;

    /**
     * PostCategoryInterface.
     */
    private PostCategoryServiceInterface $postCategoryService;

    /**
     * Constructor.
     *
     * @param PostRepository               $postRepository      Post repository
     * @param PaginatorInterface           $paginator           Paginator interface
     * @param PostCategoryServiceInterface $postCategoryService Post category service interface
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
     * @param int   $page    page
     * @param array $filters filters
     *
     * @return PaginationInterface Paginated list
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
     * @param Post $post post
     *
     */
    public function save(Post $post): void
    {
        $this->postRepository->save($post);
    }

    /**
     * Delete.
     *
     * @param Post $post post
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
     * @return array returns filtered results or an empty array if filtering didn't yield any result
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
