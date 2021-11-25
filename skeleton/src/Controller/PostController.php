<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\CommentRepository;
use App\Repository\PostsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class PostController extends AbstractController
{

    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    #[Route('/', name: '/')]
    public function index(PostsRepository $postRepository): Response
    {

        return new Response($this->twig->render('post/index.html.twig',[
            'posts' => $postRepository -> findAll()
        ]));
    }

    #[Route('/post/{slug}', name: 'post')]
    public function show(Request $request, Post $post, CommentRepository $commentRepository, PostsRepository $postsRepository): Response
    {
        $offset = max(0, $request->query->getInt('offset', 0));
        $paginator = $commentRepository -> getCommentPaginator($post, $offset);

        return new Response($this->twig->render('post/show.html.twig',[
            'posts' => $postsRepository->findAll(),
            'post' => $post,
            'comments' => $paginator,
            'previous' => $offset - CommentRepository::PAGINATOR_PER_PAGE,
            'next' => min(count($paginator), $offset + CommentRepository::PAGINATOR_PER_PAGE)
            ]));
    }
}
