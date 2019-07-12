<?php

namespace App\Controller;

use App\Repository\Blog\PostRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        return $this->render('views/index.html.twig');
    }

    /**
     * @Route("/blog", name="blog")
     */
    public function blog(PostRepository $postRepository)
    {
        return $this->render('views/blog.html.twig', [
            'posts' => $postRepository->findAll(),
        ]);
    }

	/**
	 * @Route("/login", name="login")
	 */
	public function login(Security $security)
	{
		if ($security->getUser() !== null) {
			return $this->redirectToRoute('index');
		}

		return $this->render('views/login.html.twig');
	}

	/**
	 * @Route("/admin", name="admin")
	 * @IsGranted("ROLE_USER")
	 */
	public function admin()
	{
		return $this->render('views/admin.html.twig');
	}
}
