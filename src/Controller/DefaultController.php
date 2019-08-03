<?php

namespace App\Controller;

use App\Entity\Blog\Post;
use App\Entity\Team\EsportMember;
use App\Repository\Blog\PostRepository;
use App\Repository\Blog\TagRepository;
use App\Repository\PartnerRepository;
use App\Repository\StreamerRepository;
use App\Repository\User\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('views/index.html.twig');
    }

    /**
     * @Route("/blog", name="blog", methods={"GET"}, defaults={"page": 1})
     * @Route("/page/{page<[1-9]\d*>}", methods={"GET"}, name="blog_paginated")
     */
    public function blog(Request $request, int $page, PostRepository $posts, TagRepository $tags, UserRepository $users): Response
    {
    	$options = [
    		'tag' => $request->query->has('tag') ? $tags->findOneBy(['name' => $request->query->get('tag')]) : null,
    		'author' => $request->query->has('author') ? $users->findOneBy(['displayName' => $request->query->get('author')]) : null,
		];

		$posts = $posts->findLatest($page, $options);

        return $this->render('views/blog/blog.html.twig', [
            'paginator' => $posts,
            'tags' => $tags->findAll(),
        ]);
    }

    /**
     * @Route("/blog/{slug}", name="show_article_slug", methods={"GET"})
     * @Route("/blog/{uuid}", name="show_article_uuid", methods={"GET"}, requirements={"uuid"="[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}"})
     */
    public function article(Post $post): Response
    {
        return $this->render('views/blog/article.html.twig', [
            'article' => $post,
        ]);
    }

	/**
	 * @Route("/esport", name="esport", methods={"GET"})
	 */
	public function esport(): Response
	{
		return $this->render('views/esport/esport.html.twig', [
			'main_team' => $this->getDoctrine()->getRepository(EsportMember::class)
				->findBy(['team' => EsportMember::MAIN_TEAM], ['role' => 'asc']),
			'academy' => $this->getDoctrine()->getRepository(EsportMember::class)
				->findBy(['team' => EsportMember::ACADEMY_TEAM], ['role' => 'asc']),
		]);
	}

    /**
     * @Route("/webtv", name="webtv", methods={"GET"})
     */
    public function webtv(StreamerRepository $streamerRepository): Response
    {
        return $this->render('views/webtv.html.twig', [
            'streamers' => $streamerRepository->findAll(),
        ]);
    }

    /**
     * @Route("/tournois", name="tournaments", methods={"GET"})
     */
    public function tournaments(): Response
    {
        return $this->render('views/tournaments.html.twig');
    }

    /**
     * @Route("/partenaires", name="partners", methods={"GET"})
     */
    public function partners(PartnerRepository $partnersRepository): Response
    {
        return $this->render('views/partners.html.twig', [
            'partners' => $partnersRepository->findAll(),
        ]);
    }

    /**
     * @Route("/donations", name="donations", methods={"GET"})
     */
    public function donations(): Response
    {
        return $this->render('views/donations.html.twig');
    }

    /**
     * @Route("/privacy", name="privacy", methods={"GET"})
     */
    public function privacy(): Response
    {
        return $this->render('views/privacy.html.twig');
    }

    /**
     * @Route("/mentions", name="mentions", methods={"GET"})
     */
    public function mentions(): Response
    {
        return $this->render('views/mentions.html.twig');
    }
	/**
	 * @Route("/logout", name="logout")
	 */
	public function logout()
	{
	}
}
