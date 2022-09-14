<?php
/**
 * PostCategory Controller.
 */

namespace App\Controller;

use App\Entity\PostCategory;
use App\Form\Type\PostCategoryType;
use App\Service\PostCategoryServiceInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PostCategoryController.
 */
#[Route('/postCategory')]
class PostCategoryController extends AbstractController
{
    /**
     * PostCategoryServiceInterface.
     */
    private PostCategoryServiceInterface $postCategoryService;

    /**
     * Constructor.
     *
     * @param PostCategoryServiceInterface $postCategoryService PostCategory Service Interface
     */
    public function __construct(PostCategoryServiceInterface $postCategoryService)
    {
        $this->postCategoryService = $postCategoryService;
    }

    /**
     * Index action.
     *
     * @param Request $request request
     *
     * @return Response HTTP Response
     */
    #[Route(
        name: 'postCategory_index',
        methods: 'get'
    )]
    public function index(Request $request): Response
    {
        $pagination = $this->postCategoryService->getPaginatedList(
            $request->query->getInt('page', 1)
        );

        return $this->render('postCategory/index.html.twig', ['pagination' => $pagination]);
    }

    /**
     * Show action.
     *
     * @param PostCategory $postCategory postCategory
     *
     * @return Response HTTP Response
     */
    #[Route(
        '/{id}',
        name: 'postCategory_show',
        requirements: ['id' => '[1-9]\d*'],
        methods: 'get'
    )]
    public function show(PostCategory $postCategory): Response
    {
        return $this->render(
            'postCategory/show.html.twig',
            ['postCategory' => $postCategory]
        );
    }

    /**
     * Create action.
     *
     * @param Request $request request
     *
     * @return Response HTTP Response
     */
    #[Route(
        '/create',
        name: 'postCategory_create',
        methods: 'get|post'
    )]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function create(Request $request): Response
    {
        $postCategory = new PostCategory();
        $form = $this->createForm(PostCategoryType::class, $postCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->postCategoryService->save($postCategory);

            return $this->redirectToRoute('postCategory_index');
        }

        return $this->render(
            'postCategory/create.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * Edit action.
     *
     * @param Request      $request      request
     * @param PostCategory $postCategory postCategory
     *
     * @return Response HTTP Response
     */
    #[Route(
        '/{id}/edit',
        name: 'postCategory_edit',
        requirements: ['id' => '[1-9]\d*'],
        methods: 'get|post'
    )]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function edit(Request $request, PostCategory $postCategory): Response
    {
        $form = $this->createForm(PostCategoryType::class, $postCategory, [
            'method' => 'POST',
            'action' => $this->generateUrl('postCategory_edit', ['id' => $postCategory->getId()]),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->postCategoryService->save($postCategory);

            return $this->redirectToRoute('postCategory_index');
        }

        return $this->render(
            'postCategory/edit.html.twig',
            [
                'form' => $form->createView(),
                'postCategory' => $postCategory,
            ]
        );
    }

    /**
     * Delete action.
     *
     * @param Request      $request      request
     * @param postCategory $postCategory postCategory
     *
     * @return Response HTTP Response
     */
    #[Route(
        '/{id}/delete',
        name: 'postCategory_delete',
        requirements: ['id' => '[1-9]\d*'],
        methods: 'get|post'
    )]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function delete(Request $request, PostCategory $postCategory): Response
    {
        $form = $this->createForm(FormType::class, $postCategory, [
            'method' => 'POST',
            'action' => $this->generateUrl('postCategory_delete', ['id' => $postCategory->getId()]),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->postCategoryService->delete($postCategory);

            return $this->redirectToRoute('postCategory_index');
        }

        return $this->render(
            'postCategory/delete.html.twig',
            [
                'form' => $form->createView(),
                'postCategory' => $postCategory,
            ]
        );
    }
}
