<?php

namespace App\Controller;

use App\Repository\PostsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class PostController extends AbstractController
{
    #[Route('/', name: '/')]
    public function index(Environment $twig, PostsRepository $postRepository): Response
    {
        return new Response($twig->render('post/index.html.twig',[
            'posts' => $postRepository -> findAll()
        ]));
    }
}
