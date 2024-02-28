<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
use App\Form\CreatePostType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PostController extends AbstractController
{
    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    #[Route('/post/{id}', name: 'app_post')]
    public function index($id): Response
    {
        $post = $this->em->getRepository(Post::class)->find($id);
        return $this->render(
            'post/index.html.twig',
            [
                "post" => $post
            ]
        );
    }
    #[Route('/insert/post', 'post_insert')]
    public function insert(): Response
    {
        $post = new Post(title: 'A new title has come', type: 'Opinion', description: 'My on description we changed and de set parameters', url: 'new-title.opnioned.me', creation_date: new DateTime());
        $user = $this->em->getRepository(User::class)->find(id: 1);
        $post->setUser($user);
        $this->em->persist($post);
        $this->em->flush();
        return new JsonResponse(['success' => true]);
    }
    #[Route('/getPost/{id}', name: 'getPost_app')]
    public function miFunction($id): Response
    {
        $post = $this->em->getRepository(Post::class)->find($id);
        return $this->render(
            'post/index.html.twig',
            [
                "post" => $post
            ]
        );
    }
    #[Route('/submitPost', name: 'post_submit_app')]
    public function submitPost(Request $request): Response
    {
        $post =  new Post();
        $form = $this->createForm(CreatePostType::class, $post);
        $form->handleRequest($request);
        $user = $this->em->getRepository(User::class)->find(id: 1);
        $post->setUser($user);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($post);
            $this->em->flush();
            return $this->redirectToRoute(route: 'post_submit_app');
        }
        return $this->render('post/index.html.twig', [
            'createPostForm' => $form->createView()
        ]);
    }
}
