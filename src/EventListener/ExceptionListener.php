<?php

namespace App\EventListener;

use App\Entity\Blog\Post;
use App\Repository\Blog\PostRepository;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\RouterInterface;

class ExceptionListener
{
	/**
	 * @var ContainerInterface
	 */
	private $container;

    /**
     * @var RouterInterface
     */
    private $router;

	/**
	 * @var PostRepository
	 */
	private $posts;

	public function __construct(ContainerInterface $container, PostRepository $posts, RouterInterface $router)
    {
        $this->router = $router;
        $this->posts = $posts;
		$this->container = $container;
	}

    public function onKernelException(ExceptionEvent $event): ?RedirectResponse
    {
        $exception = $event->getException();

        if (!$exception instanceof NotFoundHttpException) {
            return null;
        }

        $uri = trim($this->container->get('request_stack')->getCurrentRequest()->getRequestUri(), '/');
		$article = $this->posts->findOneBy(['slug' => $uri]);

		if ($article instanceof Post) {
			$event->setResponse(new RedirectResponse(
				$this->router->generate('show_article_slug', ['slug' => $article->getSlug()])
			));
		}

		return null;
    }
}
