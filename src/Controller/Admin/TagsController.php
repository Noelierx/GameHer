<?php

namespace App\Controller\Admin;

use App\Entity\Blog\Tag;
use App\Form\Blog\TagType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/tags")
 * @IsGranted("ROLE_REDACTEUR")
 */
class TagsController extends AbstractController
{
    /**
     * @Route("/", name="admin_tags_index", methods={"GET", "POST"})
     */
    public function index(Request $request)
    {
        $tag = new Tag();
        $tag->setName('');

        $form = $this->createForm(TagType::class, $tag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tag);
            $em->flush();

            $this->addFlash('success', 'tags.success.create');
        }

        if ($form->isSubmitted() && !$form->isValid()) {
            foreach ($form->getErrors() as $error) {
                $this->addFlash('danger', $error->getMessage().$error->getCause());
            }
        }

        return $this->render('admin/tags.html.twig', [
            'tags' => $this->getDoctrine()->getRepository(Tag::class)->findAll(),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{uuid}/delete", methods={"POST"}, name="admin_tags_delete")
     */
    public function delete(Request $request, Tag $tag): Response
    {
        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('admin_tags_index');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($tag);
        $em->flush();

        $this->addFlash('success', 'tags.success.delete');

        return $this->redirectToRoute('admin_tags_index');
    }
}
