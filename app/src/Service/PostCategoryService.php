<?php
/**
 * PostCategoryService.
 */

namespace App\Service;

use App\Entity\PostCategory;
use App\Repository\PostCategoryRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Class PostCategoryService.
 */
class PostCategoryService implements PostCategoryServiceInterface
{
    /**
     * PostCategoryRepository.
     */
    private PostCategoryRepository $postCategoryRepository;

    /**
     * PaginatorInterface.
     */
    private PaginatorInterface $paginator;

    /**
     * Constructor.
     *
     * @param PostCategoryRepository $postCategoryRepository postCategoryRepository
     * @param PaginatorInterface     $paginator              paginator
     */
    public function __construct(PostCategoryRepository $postCategoryRepository, PaginatorInterface $paginator)
    {
        $this->paginator = $paginator;
        $this->postCategoryRepository = $postCategoryRepository;
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
            $this->postCategoryRepository->queryAll(),
            $page,
            PostCategoryRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Save.
     *
     * @param PostCategory $postCategory postCategory
     *
     * @return void void
     */
    public function save(PostCategory $postCategory): void
    {
        if (null === $postCategory->getId()) {
            $postCategory->setCreatedAt(new \DateTimeImmutable());
        }

        $this->postCategoryRepository->save($postCategory);
    }

    /**
     * Delete.
     *
     * @param PostCategory $postCategory postCategory
     *
     * @return void void
     */
    public function delete(PostCategory $postCategory): void
    {
        $this->postCategoryRepository->delete($postCategory);
    }

    /**
     * Find one by id.
     *
     * @param int $id id
     *
     * @return PostCategory|null returns either a Post Category, or null if found nothing by given ID
     */
    public function findOneById(int $id): ?PostCategory
    {
        return $this->postCategoryRepository->findOneById($id);
    }
}
