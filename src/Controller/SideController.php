<?php


namespace App\Controller;

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
}
