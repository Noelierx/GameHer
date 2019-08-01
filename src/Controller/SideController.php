<?php


namespace App\Controller;

use App\Repository\Blog\PostRepository;
use App\Repository\PartnerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SideController extends AbstractController
{
	public function partners(PartnerRepository $partnerRepository)
	{
		return $this->render('partials/_partners.html.twig', [
			'partners' => $partnerRepository->findAll(),
		]);
	}

	public function recommended(PostRepository $postRepository)
	{
		return $this->render('partials/_recommendedArticles.html.twig', [
			'articles' => $postRepository->getRecommended(3)
		]);
	}
}
