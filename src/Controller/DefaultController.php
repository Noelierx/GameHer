<?php

namespace App\Controller;

use App\Repository\Blog\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index()
    {
        return $this->render('views/index.html.twig');
    }

    /**
     * @Route("/blog", name="blog", methods={"GET"})
     */
    public function blog(PostRepository $postRepository)
    {
        return $this->render('views/blog.html.twig', [
            'posts' => $postRepository->findAll(),
        ]);
    }

    /**
     * @Route("/webtv", name="webtv", methods={"GET"})
     */
    public function webtv()
    {
        return $this->render('views/webtv.html.twig');
    }

    /**
     * @Route("/tournaments", name="tournaments", methods={"GET"})
     */
    public function tournaments()
    {
        return $this->render('views/tournaments.html.twig');
    }

    /**
     * @Route("/partners", name="partners", methods={"GET"})
     */
    public function partners()
    {
        return $this->render('views/partners.html.twig');
    }

    /**
     * @Route("/donations", name="donations", methods={"GET"})
     */
    public function donations()
    {
        return $this->render('views/donations.html.twig');
    }
}
