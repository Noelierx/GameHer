<?php

namespace App\Command;

use App\Entity\Blog\Post;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GeneratePostUuids extends Command
{
    protected static $defaultName = 'app:post:uuid';

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(string $name = null, EntityManagerInterface $entityManager)
    {
        parent::__construct($name);
        $this->entityManager = $entityManager;
    }

    protected function configure()
    {
        $this->setDescription('Generates a Uuid for each post that doesn\'t have one');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $posts = $this->entityManager->getRepository(Post::class)->findAll();

        foreach ($posts as $post) {
            /** @var Post $post */
            if (null !== $post->getUuidAsString()) {
                continue;
            }

            $post->setUuid(Uuid::uuid4());
            echo 'Set uuid for post ' . $post->getUuidAsString() .'\n';
        }

        $this->entityManager->flush();
    }
}
