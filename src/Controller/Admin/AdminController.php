<?php


namespace App\Controller\Admin;

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
}