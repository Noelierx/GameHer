<?php

namespace App\Controller\Admin;

use App\Entity\Blog\Post;
use App\Form\Blog\PostType;
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
            'posts' => $this->getDoctrine()->getRepository(Post::class)->findBy([], ['publishedAt' => 'DESC', 'createdAt' => 'DESC']),
        ]);
    }

    /**
     * @Route("/new", name="admin_posts_new", methods={"GET", "POST"})
     * @throws Exception
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
            if (($posted = $request->request->get('post', null))) {
                $date = new DateTime($posted['publishedAt']);
                $post->setPublishedAt($date);
            }

            $post->setAuthor($security->getUser());
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            $this->addFlash('success', 'posts.success.create');

            return $this->redirectToRoute('admin_posts_index');
        }

        if ($form->isSubmitted() && !$form->isValid()) {
            foreach ($form->getErrors() as $error) {
                $this->addFlash('danger', $error->getMessage().$error->getCause());
            }
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

    /**
     * @Route("/{uuid}/edit", name="admin_posts_edit", methods={"GET", "POST"}, requirements={"uuid"="[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}"})
     * @Route("/{slug}/edit", name="admin_posts_edit_slug", methods={"GET", "POST"})
     */
    public function edit(Request $request, Post $post, FileUploader $fileUploader): Response
    {
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (($picture = $form['picture']->getData())) {
                $post->setPicture($fileUploader->upload($picture, $this->getParameter('posts_pictures_directory')));
            }
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'posts.success.edit');

            return $this->redirectToRoute('admin_posts_edit', ['uuid' => $post->getUuidAsString()]);
        }

        if ($form->isSubmitted() && !$form->isValid()) {
            foreach ($form->getErrors() as $error) {
                $this->addFlash('danger', $error->getMessage().$error->getCause());
            }
        }

        return $this->render('admin/posts/edit.html.twig', [
            'form' => $form->createView(),
            'post' => $post,
        ]);
    }

    /**
     * @Route("/{uuid}/delete", methods={"POST"}, name="admin_posts_delete")
     */
    public function delete(Request $request, Post $post): Response
    {
        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('admin_posts_index');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($post);
        $em->flush();

        $this->addFlash('success', 'posts.success.delete');

        return $this->redirectToRoute('admin_posts_index');
    }
}
