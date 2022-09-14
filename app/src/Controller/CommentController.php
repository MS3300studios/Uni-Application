<?php
/**
 * Comment Controller.
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

/**
 * Class CommentController.
 */
#[Route('/comment')]
class CommentController extends AbstractController
{
    /**
     * CommentServiceInterface.
     */
    private CommentServiceInterface $commentService;

    /**
     * Constructor.
     *
     * @param CommentServiceInterface $commentService Comment Service
     */
    public function __construct(CommentServiceInterface $commentService)
    {
        $this->commentService = $commentService;
    }

    /**
     * Create action.
     *
     * @param Request $request request
     *
     * @return Response HTTP Response
     */
    #[Route(
        '/create/{id}',
        name: 'comment_create',
        methods: 'get|post'
    )]
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
     * @param Request $request request
     * @param Comment $comment comment
     *
     * @return Response HTTP Response
     */
    #[Route(
        '/{id}/edit',
        name: 'comment_edit',
        requirements: ['id' => '[1-9]\d*'],
        methods: 'get|post'
    )]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function edit(Request $request, Comment $comment): Response
    {
        $form = $this->createForm(CommentType::class, $comment, [
            'method' => 'POST',
            'action' => $this->generateUrl('comment_edit', ['id' => $comment->getId()]),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->commentService->save($comment);

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
     * @param Request $request request
     * @param Comment $comment comment
     *
     * @return Response HTTP Response
     */
    #[Route(
        '/{id}/delete',
        name: 'comment_delete',
        requirements: ['id' => '[1-9]\d*'],
        methods: 'get|post'
    )]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function delete(Request $request, Comment $comment): Response
    {
        $form = $this->createForm(FormType::class, $comment, [
            'method' => 'POST',
            'action' => $this->generateUrl('comment_delete', ['id' => $comment->getId()]),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->commentService->delete($comment);

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
