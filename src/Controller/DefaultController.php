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
	 * @Route("/esport", name="esport")
	 */
	public function esport()
	{
		return $this->render('views/esport.html.twig');
	}

	/**
	 * @Route("/webtv", name="webtv")
	 */
	public function webtv()
	{
		return $this->render('views/webtv.html.twig');
	}

	/**
	 * @Route("/tournaments", name="tournaments")
	 */
	public function tournaments()
	{
		return $this->render('views/tournaments.html.twig');
	}

	/**
	 * @Route("/partners", name="partners")
	 */
	public function partners()
	{
		return $this->render('views/partners.html.twig');
	}

	/**
	 * @Route("/donations", name="donations")
	 */
	public function donations()
	{
		return $this->render('views/donations.html.twig');
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
