<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('hello')]           //GLOBALNY DEFINE, wszystkie scierzki sie zaczynaja
class HelloController extends AbstractController
{
    #[Route('/', name: "hello_index", methods: "GET")]
    public function index(Request $equest): Response
    {
        // paamet z URLa to query (?name='john')
        $name = $equest->query->getAlnum(
            'name',
            'World'
        );
        // 1: wyszukaj parametr name w query
        // 2: w pzypadku jesli jest on null, to default bedzie: World
        return new Response("Hello ".$name);
    }

    // parametr sciezki routowania (/hello/john)
    #[Route(
        '/{name}',
        name: "hello_index2",
        methods: "GET",
        requirements: ['name' => '[a-zA-Z]+']
    )]
    public function index2(string $name): Response
    {
        // return new Response("Witaj ".$name);
        return $this->render(
            'hello/index.html.twig',
            ['name' => $name]
        );
    }
}
