<?php

namespace App\Controller\Admin;

use App\Entity\User\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/")
 * @IsGranted("ROLE_ADMIN")
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
	 */
    public function users()
	{
		return $this->render('admin/users.html.twig', [
			'users' => $this->getDoctrine()->getRepository(User::class)->findAll()
		]);
	}
}
