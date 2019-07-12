<?php

namespace App\Controller;

use App\Repository\Blog\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

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
}
