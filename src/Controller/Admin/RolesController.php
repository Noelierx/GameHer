<?php

namespace App\Controller\Admin;

use App\Entity\Team\Role;
use App\Form\Team\RoleType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/roles")
 * @IsGranted("ROLE_ADMIN")
 */
class RolesController extends AbstractController
{
    /**
     * @Route("/", name="admin_roles_index", methods={"GET"})
     */
    public function index()
    {
        return $this->render('admin/roles/index.html.twig', [
            'roles' => $this->getDoctrine()->getRepository(Role::class)->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_roles_new", methods={"GET", "POST"})
     */
    public function new(Request $request): Response
    {
        $role = new Role();
        $role->setName('');
        $role->setCategory('');

        $form = $this->createForm(RoleType::class, $role);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($role);
            $em->flush();

            $this->addFlash('success', 'roles.success.create');

            return $this->redirectToRoute('admin_roles_index');
        }

		if ($form->isSubmitted() && !$form->isValid()) {
			foreach ($form->getErrors() as $error) {
				$this->addFlash('danger', $error->getMessage().$error->getCause());
			}
		}

        return $this->render('admin/roles/new.html.twig', [
            'role' => $role,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{uuid}", name="admin_roles_show", methods={"GET"}, requirements={"uuid"="[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}"})
     * @Route("/{slug}", name="admin_roles_show_slug", methods={"GET"})
     */
    public function show(Role $role): Response
    {
        return $this->render('admin/roles/show.html.twig', [
            'role' => $role,
        ]);
    }

    /**
     * @Route("/{uuid}/edit", name="admin_roles_edit", methods={"GET", "POST"}, requirements={"uuid"="[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}"})
     * @Route("/{slug}/edit", name="admin_roles_edit_slug", methods={"GET", "POST"})
     */
    public function edit(Request $request, Role $role): Response
    {
        $form = $this->createForm(RoleType::class, $role);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'roles.success.edit');

            return $this->redirectToRoute('admin_roles_edit', ['uuid' => $role->getUuidAsString()]);
        }

		if ($form->isSubmitted() && !$form->isValid()) {
			foreach ($form->getErrors() as $error) {
				$this->addFlash('danger', $error->getMessage().$error->getCause());
			}
		}

        return $this->render('admin/roles/edit.html.twig', [
            'form' => $form->createView(),
            'role' => $role,
        ]);
    }

    /**
     * @Route("/{uuid}/delete", methods={"POST"}, name="admin_roles_delete")
     */
    public function delete(Request $request, Role $role): Response
    {
        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('admin_roles_index');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($role);
        $em->flush();

        $this->addFlash('success', 'roles.success.delete');

        return $this->redirectToRoute('admin_roles_index');
    }
}
