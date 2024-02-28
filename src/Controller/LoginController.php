<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    #[Route('/login', name: 'login')]
    public function index(AuthenticationUtils $authenticationUtils): Response
    {

        $error = $authenticationUtils->getLastAuthenticationError(); // <--  Get error from $authenticationUtils
        $lastUserName = $authenticationUtils->getLastUsername(); // <-- Get error from $authenticationUtils
        return $this->render('login/index.html.twig', [
            'controller_name' => 'LoginController',
            'last_username' => $lastUserName,
            'error' => $error
        ]);
    }
    #[Route('/logout', 'logout')]
    public function logoutRoute()
    {
        return $this->render('/', []);
    }
}
