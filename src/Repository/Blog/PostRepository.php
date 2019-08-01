<?php

namespace App\Repository\Blog;

use App\Entity\Blog\Post;
use App\Entity\Blog\Tag;
use App\Pagination\Paginator;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Post::class);
    }

    public function findLatest(int $page = 1, Tag $tag = null): Paginator
    {
        $qb = $this->createQueryBuilder('p')
            ->addSelect('a', 't')
            ->innerJoin('p.author', 'a')
            ->leftJoin('p.tags', 't')
            ->where('p.publishedAt <= :now')
            ->orderBy('p.publishedAt', 'DESC')
            ->setParameter('now', new DateTime());

        if (null !== $tag) {
            $qb->andWhere(':tag MEMBER OF p.tags')->setParameter('tag', $tag);
        }

        return (new Paginator($qb))->paginate($page);
    }

	public function getRecommended(int $int)
	{
		return $this->createQueryBuilder('p')
			->orderBy('p.publishedAt', 'DESC')
			->setMaxResults(3)
			->getQuery()
			->getResult();
	}
}
