<?php

namespace App\Controller\Admin;

use App\Entity\Streamer;
use App\Form\StreamerType;
use App\Service\FileUploader;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/streamers")
 * @IsGranted("ROLE_ADMIN")
 */
class StreamersController extends AbstractController
{
    /**
     * @Route("/", name="admin_streamers_index", methods={"GET"})
     */
    public function index()
    {
        return $this->render('admin/streamers/index.html.twig', [
            'streamers' => $this->getDoctrine()->getRepository(Streamer::class)->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_streamers_new", methods={"GET", "POST"})
     */
    public function new(Request $request, FileUploader $fileUploader): Response
    {
        $streamer = new Streamer();
        $streamer->setName('');
        $streamer->setChannel('');

        $form = $this->createForm(StreamerType::class, $streamer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
			try {
				if (($logo = $form['picture']->getData())) {
					$streamer->setPicture($fileUploader->upload($logo, $this->getParameter('streamers_picture_directory')));
				}
				$em = $this->getDoctrine()->getManager();
				$em->persist($streamer);
				$em->flush();

				$this->addFlash('success', 'streamers.success.create');

				return $this->redirectToRoute('admin_streamers_index');
			} catch (Exception $e) {
				die(dump($e));
				$this->addFlash('danger', 'streamers.fail.create');
				return $this->render('admin/streamers/new.html.twig', [
					'streamer' => $streamer,
					'form' => $form->createView(),
				]);
			}
        }

        return $this->render('admin/streamers/new.html.twig', [
            'streamer' => $streamer,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{uuid}", name="admin_streamers_show", methods={"GET"}, requirements={"uuid"="[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}"})
     * @Route("/{slug}", name="admin_streamers_show_slug", methods={"GET"})
     */
    public function show(Streamer $streamer): Response
    {
        return $this->render('admin/streamers/show.html.twig', [
            'streamer' => $streamer,
        ]);
    }

    /**
     * @Route("/{uuid}/edit", name="admin_streamers_edit", methods={"GET", "POST"}, requirements={"uuid"="[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}"})
     * @Route("/{slug}/edit", name="admin_streamers_edit_slug", methods={"GET", "POST"})
     */
    public function edit(Request $request, Streamer $streamer, FileUploader $fileUploader): Response
    {
        $form = $this->createForm(StreamerType::class, $streamer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
        	try {
				if (($logo = $form['logo']->getData())) {
					$streamer->setPicture($fileUploader->upload($logo, $this->getParameter('streamers_logo_directory')));
				}
				$this->getDoctrine()->getManager()->flush();

				$this->addFlash('success', 'streamers.success.edit');

				return $this->redirectToRoute('admin_streamers_edit', ['uuid' => $streamer->getUuidAsString()]);
			} catch (Exception $e) {
        		$this->addFlash('danger', 'streamers.fail.delete');
        		return $this->render('admin/streamers/edit.html.twig', [
					'form' => $form->createView(),
					'streamer' => $streamer,
				]);
			}
        }

        return $this->render('admin/streamers/edit.html.twig', [
            'form' => $form->createView(),
            'streamer' => $streamer,
        ]);
    }

    /**
     * @Route("/{uuid}/delete", methods={"POST"}, name="admin_streamers_delete")
     */
    public function delete(Request $request, Streamer $streamer): Response
    {
        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('admin_streamers_index');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($streamer);
        $em->flush();

        $this->addFlash('success', 'streamers.success.delete');

        return $this->redirectToRoute('admin_streamers_index');
    }
}
