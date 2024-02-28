<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\CreateUserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    private $EntityManager;
    public function __construct(EntityManagerInterface $EntityManager)
    {
        $this->EntityManager = $EntityManager;
    }
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
    #[Route('/createUser', name: 'create-user-app')]
    public function createUser(Request $request): Response
    {
        $user = new User();
        $userCreate = $this->createForm(CreateUserType::class, $user);
        $userCreate->handleRequest($request);
        $user->setRoles(['User_Rol']);
        if ($userCreate->isSubmitted() && $userCreate->isValid()) {
            $this->EntityManager->persist($user);
            $this->EntityManager->flush();
            return $this->redirectToRoute('create-user-app');
        }
        return $this->render('/user/createUser.html.twig', [
            'userCreate' => $userCreate->createView(),
        ]);
    }
}
