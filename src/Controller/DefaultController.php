<?php

namespace App\Controller;

use App\Entity\Blog\Post;
use App\Entity\Blog\Tag;
use App\Repository\Blog\PostRepository;
use App\Repository\Blog\TagRepository;
use App\Repository\PartnerRepository;
use App\Repository\StreamerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
     * @Route("/blog", name="blog", methods={"GET"}, defaults={"page": 1})
	 * @Route("/page/{page<[1-9]\d*>}", methods={"GET"}, name="blog_paginated")
     */
    public function blog(Request $request, int $page, PostRepository $posts, TagRepository $tags): Response
    {
		$tag = null;
		if ($request->query->has('tag')) {
			$tag = $tags->findOneBy(['name' => $request->query->get('tag')]);
		}
    	$posts = $posts->findLatest($page, $tag);

        return $this->render('views/blog/blog.html.twig', [
            'paginator' => $posts,
			'tags' => $tags->findAll(),
        ]);
    }

	/**
	 * @Route("/blog/{slug}", name="show_article_slug", methods={"GET"})
	 * @Route("/blog/{uuid}", name="show_article_uuid", methods={"GET"}, requirements={"uuid"="[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}"})
	 */
	public function article(Post $post)
	{
		return $this->render('views/blog/article.html.twig', [
			'article' => $post
		]);
	}

    /**
     * @Route("/webtv", name="webtv", methods={"GET"})
     */
    public function webtv(StreamerRepository $streamerRepository)
    {
        return $this->render('views/webtv.html.twig', [
            'streamers' => $streamerRepository->findAll(),
        ]);
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
    public function partners(PartnerRepository $partnersRepository)
    {
        return $this->render('views/partners.html.twig', [
            'partners' => $partnersRepository->findAll(),
        ]);
    }

    /**
     * @Route("/donations", name="donations", methods={"GET"})
     */
    public function donations()
    {
        return $this->render('views/donations.html.twig');
    }
    /**
     * @Route("/recruitment", name="recruitment", methods={"GET"})
     */
    public function recrutement()
    {
        return $this->render('views/recruitment.html.twig');
    }
}
