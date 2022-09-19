<?php
/*
 *
 * Main Controller
 *
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * main controller class
 */
class MainController extends AbstractController
{
    /**
     * Index action, this is the main, home route.
     *
     * @return Response Response
     */
    #[Route('/', name: 'hello_index', methods: 'GET')]
    public function index(): Response
    {
        return $this->render(
            'main/main.html.twig'
        );
    }
}
