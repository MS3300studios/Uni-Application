<?php
/**
 *
 * Comment Controller.
 *
 */
namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Post;
use App\Form\Type\CommentType;
use App\Service\CommentServiceInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 *
 * Class CommentController.
 *
 */
#[Route('/comment')]
class CommentController extends AbstractController
{

    private CommentServiceInterface $commentService;

    private TranslatorInterface $translator;

    public function __construct(CommentServiceInterface $commentService, TranslatorInterface $translator)
    {
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
        name: 'comment_index',
        methods: 'get'
    )]
    public function index(Request $request): Response
    {
        $pagination = $this->commentService->getPaginatedList(
            $request->query->getInt('page', 1)
        );
        if ($this->isGranted('ROLE_ADMIN')) {
            return $this->render('comment/admin.index.html.twig', ['pagination' => $pagination]);
        } else {
            return $this->render('comment/index.html.twig', ['pagination' => $pagination]);
        }
    }

    /**
     * Show action.
     *
     * @param Comment $comment
     *
     * @return Response
     *
     */
    #[Route(
        '/{id}',
        name: 'comment_show',
        requirements: ['id' => '[1-9]\d*'],
        methods: 'get'
    )]
    //#[IsGranted('ROLE_ADMIN')]
    public function show(Comment $comment): Response
    {
        return $this->render(
            'comment/show.html.twig',
            ['comment' => $comment]
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
        '/create/{id}',
        name: 'comment_create',
        methods: 'get|post'
    )]
    //#[IsGranted('ROLE_ADMIN')]
    public function create(Request $request, Post $post): Response
    {
        $comment = new Comment();
        $comment->setPost($post);
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->commentService->save($comment);

            return $this->redirectToRoute('post_show', ['id' => $post->getId()]);
        }

        return $this->render(
            'comment/create.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * Edit action.
     *
     * @param Request $request
     * @param Comment $comment
     *
     * @return Response
     *
     */
    #[Route(
        '/{id}/edit',
        name: 'comment_edit',
        requirements: ['id' => '[1-9]\d*'],
        methods: 'get|post'
    )]
    //#[IsGranted('ROLE_ADMIN')]
    public function edit(Request $request, Comment $comment): Response
    {
        $form = $this->createForm(CommentType::class, $comment, [
            'method' => 'POST',
            'action' => $this->generateUrl('comment_edit', ['id' => $comment->getId()]),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->commentService->save($comment);

            $this->addFlash(
                'success',
                $this->translator->trans('message.edited_successfully')
            );

            return $this->redirectToRoute('post_show', ['id' => $comment->getPost()->getId()]);
        }

        return $this->render(
            'comment/edit.html.twig',
            [
                'form' => $form->createView(),
                'comment' => $comment,
            ]
        );
    }

    /**
     * Delete action.
     *
     * @param Request $request
     * @param Comment $comment
     *
     * @return Response
     *
     */
    #[Route(
        '/{id}/delete',
        name: 'comment_delete',
        requirements: ['id' => '[1-9]\d*'],
        methods: 'get|post'
    )]
    //#[IsGranted('ROLE_ADMIN')]
    public function delete(Request $request, Comment $comment): Response
    {
        $form = $this->createForm(FormType::class, $comment, [
            'method' => 'POST',
            'action' => $this->generateUrl('comment_delete', ['id' => $comment->getId()]),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->commentService->delete($comment);

            $this->addFlash(
                'success',
                $this->translator->trans('message.deleted_successfully')
            );

            return $this->redirectToRoute('post_show', ['id' => $comment->getPost()->getId()]);
        }

        return $this->render(
            'comment/delete.html.twig',
            [
                'form' => $form->createView(),
                'comment' => $comment,
            ]
        );
    }
}
