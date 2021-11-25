<?php

namespace App\EventSubscriber;

use Twig\Environment;
use App\Repository\PostsRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;

class TwigEventSubscriber implements EventSubscriberInterface
{
    private $twig;
    private $postsRepository;

    public function __construct(Environment $twig, PostsRepository $postsRepository)
    {
        $this->twig = $twig;
        $this->postsRepository = $postsRepository;
    }

    public function onKernelController(ControllerEvent $event)
    {
        // ...
        $this->twig->addGlobal('posts', $this->postsRepository->findAll());
    }

    public static function getSubscribedEvents()
    {
        return [
            'kernel.controller' => 'onKernelController',
        ];
    }
}
