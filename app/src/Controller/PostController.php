<?php
namespace App\Controller;

use App\Entity\Post;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Form\Type\PostType;
use App\Service\CommentServiceInterface;
use App\Service\PostServiceInterface;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 *
 * Class PostController.
 *
 */
#[Route('/post')]
class PostController extends AbstractController
{
    /**
     * PostServiceInterface.
     *
     * @var PostServiceInterface
     *
     */
    private PostServiceInterface $postService;

    /**
     * CommentServiceInterface.
     *
     * @var CommentServiceInterface
     *
     */
    private CommentServiceInterface $commentService;

    /**
     * TranslatorInterface.
     *
     * @var TranslatorInterface
     *
     */
    private TranslatorInterface $translator;

    /**
     * Constructor.
     *
     * @param PostServiceInterface    $postService    Post Service Interface
     * @param CommentServiceInterface $commentService
     * @param TranslatorInterface     $translator     Translator
     *
     */
    public function __construct(PostServiceInterface $postService, CommentServiceInterface $commentService, TranslatorInterface $translator)
    {
        $this->postService = $postService;
        $this->commentService = $commentService;
        $this->translator = $translator;
    }

    /**
     * Index action.
     *
     * @param Request $request
     *
     * @return Response
     *
     */
    #[Route(
        name: 'post_index',
        methods: 'get'
    )]
    public function index(Request $request): Response
    {
        $filters = $this->getFilters($request);
        $pagination = $this->postService->getPaginatedList(
            $request->query->getInt('page', 1),
            $filters
        );

        if ($this->isGranted('ROLE_ADMIN')) {
            return $this->render('post/index.html.twig', ['pagination' => $pagination]);
        } else {
            return $this->render('post/index.html.twig', ['pagination' => $pagination]);
        }
    }


    public function getFilters(Request $request): array
    {
        $filters = [];
        $filters['postCategory_id'] = $request->query->getInt('filters_postCategory_id');

        return $filters;
    }

    /**
     * Show action.
     *
     * @param Request $request
     * @param Post    $post
     *
     * @return Response
     *
     */
    #[Route(
        '/{id}',
        name: 'post_show',
        requirements: ['id' => '[1-9]\d*'],
        methods: 'get',
    )]
    public function show(Request $request, Post $post): Response
    {
        $commentPagination = $this->commentService->findManyByPostId(
            $request->query->getInt('page', 1),
            $post->getId()
        );

        return $this->render(
            'post/show.html.twig',
            ['post' => $post, 'comment' => $commentPagination]
        );
    }

    /**
     * Create action.
     *
     * @param Request $request
     *
     * @return Response
     *
     */
    #[Route(
        '/create',
        name: 'post_create',
        methods: 'get|post'
    )]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function create(Request $request): Response
    {
        $post = new Post();
        $post->setCreatedAt(new DateTimeImmutable());
        $form = $this->createForm(PostType::class, $post, ['action' => $this->generateUrl('post_create'), ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($this->isGranted('ROLE_ADMIN')) {
                $this->postService->save($post);
            } else {
                $this->postService->save($post);
            }

            $this->addFlash(
                'success',
                $this->translator->trans('message.created_successfully')
            );

            return $this->redirectToRoute('post_index');
        }

        return $this->render(
            'post/create.html.twig',
            [
              'form' => $form->createView(),
            ]
        );
    }

    /**
     * Edit action.
     *
     * @param Request $request
     * @param Post $post
     *
     * @return Response
     *
     */
    #[Route(
        '/{id}/edit',
        name: 'post_edit',
        requirements: ['id' => '[1-9]\d*'],
        methods: 'get|post'
    )]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function edit(Request $request, Post $post): Response
    {
        $form = $this->createForm(PostType::class, $post, [
            'method' => 'post',
            'action' => $this->generateUrl('post_edit', ['id' => $post->getId()]),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->postService->save($post);

            $this->addFlash(
                'success',
                $this->translator->trans('message.edited_successfully')
            );

            return $this->redirectToRoute('post_index');
        }

        return $this->render('post/edit.html.twig', [
            'form' => $form->createView(),
            'post' => $post,
        ]);
    }

    /**
     * Delete action.
     *
     * @param Request $request
     * @param Post $post
     *
     * @return Response
     *
     */
    #[Route(
        '/{id}/delete',
        name: 'post_delete',
        requirements: ['id' => '[1-9]\d*'],
        methods: 'get|post'
    )]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function delete(Request $request, Post $post): Response
    {
        $form = $this->createForm(FormType::class, $post, [
            'method' => 'POST',
            'action' => $this->generateUrl('post_delete', ['id' => $post->getId()]),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->postService->delete($post);

            $this->addFlash(
                'success',
                $this->translator->trans('message.deleted_successfully')
            );

            return $this->redirectToRoute('post_index');
        }

        return $this->render('post/delete.html.twig', [
            'form' => $form->createView(),
            'post' => $post,
        ]);
    }
}
