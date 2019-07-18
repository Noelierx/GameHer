<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class AuthController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     */
    public function login(Security $security)
    {
        if (null !== $security->getUser()) {
            return $this->redirectToRoute('index');
        }

        return $this->render('views/login.html.twig');
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout()
    {
    }
}
