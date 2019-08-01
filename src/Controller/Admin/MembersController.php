<?php

namespace App\Controller\Admin;

use App\Entity\Team\EsportMember;
use App\Entity\Team\Member;
use App\Form\Team\MemberType;
use App\Service\FileUploader;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/members")
 * @IsGranted("ROLE_ADMIN")
 */
class MembersController extends AbstractController
{
    /**
     * @Route("/", name="admin_members_index", methods={"GET"})
     */
    public function index()
    {
        return $this->render('admin/members/index.html.twig', [
            'members' => $this->getDoctrine()->getRepository(Member::class)->findAll(),
            'esports' => $this->getDoctrine()->getRepository(EsportMember::class)->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_members_new", methods={"GET", "POST"})
     */
    public function new(Request $request, FileUploader $fileUploader): Response
    {
        $member = new Member();
        $member->setNickname('');

        $form = $this->createForm(MemberType::class, $member);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (($picture = $form['picture']->getData())) {
                $member->setPicture($fileUploader->upload($picture, $this->getParameter('members_pictures_directory')));
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($member);
            $em->flush();

            $this->addFlash('success', 'members.success.create');

            return $this->redirectToRoute('admin_members_index');
        }

		if ($form->isSubmitted() && !$form->isValid()) {
			foreach ($form->getErrors() as $error) {
				$this->addFlash('danger', $error->getMessage().$error->getCause());
			}
		}

        return $this->render('admin/members/new.html.twig', [
            'member' => $member,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{uuid}/edit", name="admin_members_edit", methods={"GET", "POST"}, requirements={"uuid"="[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}"})
     * @Route("/{slug}/edit", name="admin_members_edit_slug", methods={"GET", "POST"})
     */
    public function edit(Request $request, Member $member, FileUploader $fileUploader): Response
    {
        $form = $this->createForm(MemberType::class, $member);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (($picture = $form['picture']->getData())) {
                $member->setPicture($fileUploader->upload($picture, $this->getParameter('members_pictures_directory')));
            }
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'members.success.edit');

            return $this->redirectToRoute('admin_members_edit', ['uuid' => $member->getUuidAsString()]);
        }

		if ($form->isSubmitted() && !$form->isValid()) {
			foreach ($form->getErrors() as $error) {
				$this->addFlash('danger', $error->getMessage().$error->getCause());
			}
		}

        return $this->render('admin/members/edit.html.twig', [
            'form' => $form->createView(),
            'member' => $member,
        ]);
    }

    /**
     * @Route("/{uuid}/delete", methods={"POST"}, name="admin_members_delete")
     */
    public function delete(Request $request, Member $member): Response
    {
        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('admin_members_index');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($member);
        $em->flush();

        $this->addFlash('success', 'members.success.delete');

        return $this->redirectToRoute('admin_members_index');
    }
}
