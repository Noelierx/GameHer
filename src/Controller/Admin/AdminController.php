<?php

namespace App\Controller\Admin;

use App\Entity\User\User;
use App\Form\Admin\UserType;
use App\Service\FileUploader;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/")
 * @IsGranted("ROLE_REDACTEUR")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="admin")
     */
    public function admin()
    {
        return $this->render('admin/admin.html.twig');
    }

    /**
     * @Route("/users", name="admin_users")
	 * @IsGranted("ROLE_ADMIN")
     */
    public function users()
    {
        return $this->render('admin/users/index.html.twig', [
            'users' => $this->getDoctrine()->getRepository(User::class)->findAll(),
        ]);
    }

	/**
	 * @Route("/users/new", name="admin_users_new", methods={"GET", "POST"})
	 * @IsGranted("ROLE_ADMIN")
	 */
    public function new(Request $request, FileUploader $fileUploader, ObjectManager $em): Response
	{
		$user = (new User())->setDisplayName('');

		$form = $this->createForm(UserType::class, $user);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			if (($picture = $form['picture']->getData())) {
				$user->setPicture($fileUploader->upload($picture, $this->getParameter('users_pictures_directory')));
			}

			$em->persist($user);
			$em->flush();

			$this->addFlash('success', 'users.success.create');

			return $this->redirectToRoute('admin_users');
		}

		if ($form->isSubmitted() && !$form->isValid()) {
			foreach ($form->getErrors() as $error) {
				$this->addFlash('danger', $error->getMessage() . $error->getCause());
			}
		}

		return $this->render('admin/users/new.html.twig', [
			'user' => $user,
			'form' => $form->createView(),
		]);
	}
}
