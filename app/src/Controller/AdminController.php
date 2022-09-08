<?php

/**
 * Admin controller.
 */

namespace App\Controller;

use App\Entity\Admin;
use App\Form\Type\AdminType;
use App\Service\AdminServiceInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * AdminController class.
 */
class AdminController extends AbstractController
{
    /**
     * Admin service
     */
    private AdminServiceInterface $adminService;

    /**
     * Password hasher
     */
    private UserPasswordHasherInterface $passwordHasher;

    /**
     * Translator
     */
    private TranslatorInterface $translator;

    /**
     * Class Constructor
     *
     * @param AdminServiceInterface        $adminService
     * @param TranslatorInterface         $translator
     * @param UserPasswordHasherInterface $passwordHasher
     */
    public function __construct(AdminServiceInterface $adminService, TranslatorInterface $translator, UserPasswordHasherInterface $passwordHasher)
    {
        $this->adminService = $adminService;
        $this->translator = $translator;
        $this->passwordHasher = $passwordHasher;
    }

    /**
     * Login method
     *
     * @param AuthenticationUtils $authenticationUtils
     *
     * @return Response
     */
    #[Route(path: '/login', name: 'admin_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('question_index');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * Logout method
     *
     * @return void
     */
    #[Route(path: '/logout', name: 'admin_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * Register method
     *
     * @param Request                     $request
     * @param UserPasswordHasherInterface $passwordHasher
     *
     * @return Response
     */
    #[Route('/register', name: 'admin_register')]
    public function register(Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        $form = $this->createForm(
            AdminType::class,
            [
                'method' => 'PUT',
                'action' => $this->generateUrl('admin_register'),
            ]
        );

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $data = $form->getData();
            $admin = new Admin();
            $admin->setEmail($data['email']);
            $admin->setPassword(
                $passwordHasher->hashPassword(
                    $admin,
                    $data['password']
                )
            );

            $this->adminService->save($admin);

            $this->addFlash(
                'success',
                $this->translator->trans('message.success')
            );

            return $this->redirect($this->generateUrl('admin_login'));
        }

        return $this->render('security/register.html.twig', [
            'controller_name' => 'AdminController',
            'form' => $form->createView(),
        ]);
    }

    /**
     * Edit action.
     *
     * @param Request                     $request
     * @param Admin                        $admin
     * @param UserPasswordHasherInterface $passwordHasher
     *
     * @return Response
     */
    #[Route('admin/edit/{id}', name: 'admin_edit', requirements: ['id' => '[1-9]\d*'], methods: 'GET|PUT')]
    #[IsGranted('ROLE_ADMIN')]
    public function edit(Request $request, Admin $admin, UserPasswordHasherInterface $passwordHasher): Response
    {
        $form = $this->createForm(
            AdminType::class,
            $admin,
            [
                'method' => 'PUT',
                'action' => $this->generateUrl('admin_edit', ['id' => $admin->getId()])
            ]
        );

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hashedPassword = $this->passwordHasher->hashPassword(
                $admin,
                $admin->getPassword()
            );
            $admin->setPassword($hashedPassword);
            $this->adminService->save($admin);

            $this->addFlash(
                'success',
                $this->translator->trans('message.success')
            );

            return $this->redirectToRoute('question_index');
        }

        return $this->render(
            'security/edit.html.twig',
            ['form' => $form->createView()]
        );
    }
}