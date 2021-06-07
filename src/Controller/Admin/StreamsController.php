<?php

namespace App\Controller\Admin;
use App\Entity\Stream;
use App\Form\StreamType;
use App\Service\FileUploader;
use DateTime;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * @Route("/streams")
 * @IsGranted("ROLE_STREAMER_USER")
 */
class StreamsController extends AbstractController
{
	/**
	 * @Route("/", name="admin_streams_index", methods={"GET"})
	 */
	public function index()
	{
		return $this->render('admin/streams/index.html.twig', [
			'streams' => $this->getDoctrine()->getRepository(Stream::class)->findAll(),
		]);
	}

	/**
	 * @Route("/new", name="admin_streams_new", methods={"GET", "POST"})
	 * @throws Exception
	 */
	public function new(Request $request, FileUploader $fileUploader, Security $security): Response
	{
		$stream = new Stream();
		$stream->setStreamName('');
		$stream->setActivityName('');

		$form = $this->createForm(StreamType::class, $stream);

		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			if (($picture = $form['picture']->getData())) {
				$stream->setPicture($fileUploader->upload($picture, $this->getParameter('streams_picture_directory')));
			}
			if (($posted = $request->request->get('stream', null))) {
				$date = new DateTime($posted['streamedAt']);
				$stream->setStreamedAt($date);
			}

			$stream->setAuthor($security->getUser());
			$em = $this->getDoctrine()->getManager();
			$em->persist($stream);
			$em->flush();

			$this->addFlash('success', 'streams.success.create');

			return $this->redirectToRoute('admin_streams_index');
		}

		if ($form->isSubmitted() && !$form->isValid()) {
			foreach ($form->getErrors() as $error) {
				$this->addFlash('danger', $error->getMessage().$error->getCause());
			}
		}

		return $this->render('admin/streams/new.html.twig', [
			'stream' => $stream,
			'form' => $form->createView(),
		]);
	}

	/**
	 * @Route("/{uuid}", name="admin_streams_show", methods={"GET"}, requirements={"uuid"="[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}"})
	 * @Route("/{slug}", name="admin_streams_show_slug", methods={"GET"})
	 */
	public function show(Stream $stream): Response
	{
		return $this->render('admin/streams/show.html.twig', [
			'stream' => $stream,
		]);
	}

	/**
	 * @Route("/{uuid}/edit", name="admin_streams_edit", methods={"GET", "POST"}, requirements={"uuid"="[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}"})
	 * @Route("/{slug}/edit", name="admin_streams_edit_slug", methods={"GET", "POST"})
	 */
	public function edit(Request $request, Stream $stream, FileUploader $fileUploader): Response
	{
		$form = $this->createForm(StreamType::class, $stream);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			if (($picture = $form['picture']->getData())) {
				$stream->setPicture($fileUploader->upload($picture, $this->getParameter('streams_pictures_directory')));
			}
			if (($posted = $request->request->get('stream', null))) {
				$date = new DateTime($posted['streamedAt']);
				$stream->setStreamedAt($date);
			}
			$this->getDoctrine()->getManager()->flush();

			$this->addFlash('success', 'streams.success.edit');

			return $this->redirectToRoute('admin_streams_edit', ['uuid' => $stream->getUuidAsString()]);
		}

		if ($form->isSubmitted() && !$form->isValid()) {
			foreach ($form->getErrors() as $error) {
				$this->addFlash('danger', $error->getMessage().$error->getCause());
			}
		}

		return $this->render('admin/streams/edit.html.twig', [
			'form' => $form->createView(),
			'stream' => $stream,
		]);
	}

	/**
	 * @Route("/{uuid}/delete", methods={"POST"}, name="admin_streams_delete")
	 */
	public function delete(Request $request, Stream $stream): Response
	{
		if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
			return $this->redirectToRoute('admin_planners_index');
		}

		$em = $this->getDoctrine()->getManager();
		$em->remove($stream);
		$em->flush();

		$this->addFlash('success', 'streams.success.delete');

		return $this->redirectToRoute('admin_streams_index');
	}
}
