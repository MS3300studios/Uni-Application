<?php
/**
 *
 * PostCategoryService.
 *
 */
namespace App\Service;


use App\Entity\PostCategory;
use App\Repository\PostCategoryRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use App\Repository\PostRepository;

/**
 *
 * Class PostCategoryService.
 *
 */
class PostCategoryService implements PostCategoryServiceInterface
{
    /**
     * PostCategoryRepository.
     *
     * @var PostCategoryRepository
     *
     */
    private PostCategoryRepository $postCategoryRepository;

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
     * @param PostCategoryRepository $postCategoryRepository
     * @param PaginatorInterface $paginator
     * @param PostRepository $postRepository
     *
     */
    public function __construct(PostCategoryRepository $postCategoryRepository, PaginatorInterface $paginator, PostRepository $postRepository)
    {
        $this->paginator = $paginator;
        $this->postCategoryRepository = $postCategoryRepository;
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
            $this->postCategoryRepository->queryAll(),
            $page,
            PostCategoryRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Save.
     *
     * @param PostCategory $postCategory
     * @return void
     *
     */
    public function save(PostCategory $postCategory): void
    {
        if(null == $postCategory->getId()) {
            $postCategory->setCreatedAt(new \DateTimeImmutable());
        }

        $this->postCategoryRepository->save($postCategory);
    }

    /**
     * Delete.
     *
     * @param PostCategory $postCategory
     * @return void
     *
     */
    public function delete(PostCategory $postCategory): void
    {
        $this->postCategoryRepository->delete($postCategory);
    }

    /**
     * Find one by id.
     *
     * @param int $id
     * @return PostCategory|null
     *
     */
    public function findOneById(int $id): ?PostCategory
    {
        return $this->postCategoryRepository->findOneById($id);
    }
}