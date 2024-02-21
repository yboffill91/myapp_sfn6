<?php

namespace App\Controller;

use App\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PostController extends AbstractController
{
    #[Route('/post/{id}', name: 'app_post')]
    public function index(Post $post): Response
    {
            return $this->render('post/index.html.twig', [
            'controller_name' => 'PostController',
            'myvar' => 'Mi string to past',
            'newarray' => [0,1,2,2],
            'post' => $post
        ]
    );
    }
}
