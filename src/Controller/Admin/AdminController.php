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
use Symfony\Component\Security\Core\Security;

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

		$form = $this->createForm(UserType::class, $user, [
			'addRolesField' => true,
			'choices'       => $this->getAvailableRoles(),
		]);
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

	/**
	 * @Route("/users/{uuid}/edit", name="admin_users_edit", methods={"GET", "POST"})
	 * @IsGranted("ROLE_ADMIN")
	 */
	public function edit(User $user, Request $request, FileUploader $fileUploader, ObjectManager $em): Response
	{
		$addRolesField = $this->isEditRolesOrDeleteAllowed($user);
		$form = $this->createForm(UserType::class, $user, [
			'addRolesField' => $addRolesField,
			'choices'       => $this->getAvailableRoles(),
		]);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			if (($picture = $form['picture']->getData())) {
				$user->setPicture($fileUploader->upload($picture, $this->getParameter('users_pictures_directory')));
			}

			$em->flush();

			$this->addFlash('success', 'users.success.edit');

			return $this->redirectToRoute('admin_users_edit', ['uuid' => $user->getUuidAsString()]);
		}

		if ($form->isSubmitted() && !$form->isValid()) {
			foreach ($form->getErrors() as $error) {
				$this->addFlash('danger', $error->getMessage() . $error->getCause());
			}
		}

		return $this->render('admin/users/edit.html.twig', [
			'user'          => $user,
			'form'          => $form->createView(),
			'addRolesField' => $addRolesField,
		]);
	}

	private function getAvailableRoles(): array
	{
		return \array_filter(
			User::getAvailableRoles(),
			function (string $choice) {
				return $this->isGranted($choice);
			}
		);
	}

	/**
	 * @Route("/users/{uuid}/delete", name="admin_users_delete", methods={"POST"})
	 * @IsGranted("ROLE_ADMIN")
	 */
	public function delete(User $user, Request $request, Security $security, ObjectManager $em): Response
	{
		if (!$this->isEditRolesOrDeleteAllowed($user)) {
			$this->addFlash('danger', 'users.fail.delete');

			return $this->redirectToRoute('admin_users');
		}

		if ($user === $security->getUser()) {
			$this->addFlash('danger', 'users.fail.delete');

			return $this->redirectToRoute('admin_users');
		}

		if (!$this->isCsrfTokenValid('delete', $request->get('token'))) {
			return $this->redirectToRoute('admin_users');
		}

		$em->remove($user);
		$em->flush();

		$this->addFlash('success', 'users.success.delete');

		return $this->redirectToRoute('admin_users');
	}

	private function isEditRolesOrDeleteAllowed(User $user): bool
	{
		return $this->isGranted(User::ROLE_SUPER_ADMIN)
			|| !($user->hasRole(User::ROLE_ADMIN) || $user->hasRole(User::ROLE_SUPER_ADMIN));
	}
}
