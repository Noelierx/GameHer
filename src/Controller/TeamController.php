<?php


namespace App\Controller;

use App\Entity\Team\EsportMember;
use App\Entity\Team\Role;
use App\Repository\Team\MemberRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/team")
 */
class TeamController extends AbstractController
{
	/**
	 * @Route("/a-propos", name="about", methods={"GET"})
	 */
	public function about(MemberRepository $memberRepository): Response
	{
		return $this->render('views/team/about.html.twig', [
			'direction' => $memberRepository->getByCategory(Role::CATEGORY_DIRECTION),
			'administration' => $memberRepository->getByCategory(Role::CATEGORY_ADMINISTRATION),
			'members' => $memberRepository->getByCategory(Role::CATEGORY_MEMBERS),
			'esports' => $this->getDoctrine()->getRepository(EsportMember::class)->findAll(),
		]);
	}

	/**
	 * @Route("/contact", name="contact", methods={"GET"})
	 */
	public function contact(): Response
	{
		return $this->render('views/team/contact.html.twig');
	}

	/**
	 * @Route("/contact", name="contact_form", methods={"POST"})
	 */
	public function contactForm(Request $request): Response
	{

	}

	/**
	 * @Route("/recruitment", name="recruitment", methods={"GET"})
	 */
	public function recrutement(): Response
	{
		return $this->render('views/team/recruitment.html.twig');
	}

}
