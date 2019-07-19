<?php


namespace App\Controller\Admin;

use App\Entity\Blog\Post;
use App\Form\Blog\PostType;
use App\Service\FileUploader;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * @Route("/posts")
 * @IsGranted("ROLE_REDACTEUR")
 */
class PostsController extends AbstractController
{
	/**
	 * @Route("/", name="admin_posts_index", methods={"GET"})
	 */
	public function index()
	{
		return $this->render('admin/posts/index.html.twig', [
			'posts' => $this->getDoctrine()->getRepository(Post::class)->findAll(),
		]);
	}

	/**
	 * @Route("/new", name="admin_posts_new", methods={"GET", "POST"})
	 */
	public function new(Request $request, FileUploader $fileUploader, Security $security): Response
	{
		$post = new Post();
		$post->setTitle('');
		$post->setContent('');

		$form = $this->createForm(PostType::class, $post);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			if (($picture = $form['picture']->getData())) {
				$post->setPicture($fileUploader->upload($picture, $this->getParameter('posts_pictures_directory')));
			}
			$post->setAuthor($security->getUser());
			$em = $this->getDoctrine()->getManager();
			$em->persist($post);
			$em->flush();

			$this->addFlash('success', 'posts.flash_message.success.create');

			return $this->redirectToRoute('admin_posts_index');
		}

		return $this->render('admin/posts/new.html.twig', [
			'post' => $post,
			'form' => $form->createView(),
		]);
	}

	/**
	 * @Route("/{uuid}", name="admin_posts_show", methods={"GET"}, requirements={"uuid"="[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}"})
	 * @Route("/{slug}", name="admin_posts_show_slug", methods={"GET"})
	 */
	public function show(Post $post): Response
	{
		return $this->render('admin/posts/show.html.twig', [
			'post' => $post,
		]);
	}
}
