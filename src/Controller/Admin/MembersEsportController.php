<?php

namespace App\Controller\Admin;

use App\Entity\Team\EsportMember;
use App\Form\Team\EsportMemberType;
use App\Service\FileUploader;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/membres/esport")
 * @IsGranted("ROLE_ADMIN")
 */
class MembersEsportController extends AbstractController
{
    /**
     * @Route("/new", name="admin_esport_members_new", methods={"GET", "POST"})
     */
    public function new(Request $request, FileUploader $fileUploader): Response
    {
        $member = new EsportMember();
        $member->setNickname('');
        $member->setTeam('');
        $member->setRole('');

        $form = $this->createForm(EsportMemberType::class, $member);
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
        } elseif (!$form->isValid()) {
            foreach ($form->getErrors() as $error) {
                $this->addFlash('danger', $error->getMessage().$error->getCause());
            }
        }

        return $this->render('admin/members/esport/new.html.twig', [
            'member' => $member,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{uuid}/edit", name="admin_esport_members_edit", methods={"GET", "POST"}, requirements={"uuid"="[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}"})
     * @Route("/{slug}/edit", name="admin_esport_members_edit_slug", methods={"GET", "POST"})
     */
    public function edit(Request $request, EsportMember $member, FileUploader $fileUploader): Response
    {
        $form = $this->createForm(EsportMemberType::class, $member);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (($picture = $form['picture']->getData())) {
                $member->setPicture($fileUploader->upload($picture, $this->getParameter('members_pictures_directory')));
            }
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'members.success.edit');

            return $this->redirectToRoute('admin_esport_members_edit', ['uuid' => $member->getUuidAsString()]);
        }

        return $this->render('admin/members/esport/edit.html.twig', [
            'form' => $form->createView(),
            'member' => $member,
        ]);
    }

    /**
     * @Route("/{uuid}/delete", methods={"POST"}, name="admin_esport_members_delete")
     */
    public function delete(Request $request, EsportMember $member): Response
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
