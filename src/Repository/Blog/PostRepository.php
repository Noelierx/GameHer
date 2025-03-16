<?php

namespace App\Repository\Blog;

use App\Entity\Blog\Post;
use App\Entity\Blog\Tag;
use App\Entity\User\User;
use App\Pagination\Paginator;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Validator\Constraints\Date;

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

    public function findLatest(int $page = 1, array $options = []): Paginator
    {
        $qb = $this->createQueryBuilder('p')
            ->addSelect('a', 't')
            ->innerJoin('p.authors', 'a')
            ->leftJoin('p.tags', 't')
            ->where('p.publishedAt <= :now')
            ->orderBy('p.publishedAt', 'DESC')
            ->setParameter('now', new DateTime());

        if ($options['tag'] instanceof Tag) {
            $qb->andWhere(':tag MEMBER OF p.tags')->setParameter('tag', $options['tag']);
        }
        if ($options['author'] instanceof User) {
            $qb->andWhere(':authors MEMBER OF p.authors')->setParameter('authors', $options['authors']);
        }
        if ($options['query'] !== null) {
            $qb
                ->andWhere('p.title LIKE :query OR p.slug LIKE :query OR p.content LIKE :query')
                ->setParameter('query', '%'.$options['query'].'%');
        }
        
        return (new Paginator($qb))->paginate($page);
    }

    public function getRecommended(int $int)
    {
        return $this->createQueryBuilder('p')
            ->where('p.publishedAt <= :now')
            ->orderBy('p.publishedAt', 'DESC')
            ->setMaxResults(3)
            ->setParameter('now', new DateTime())
            ->getQuery()
            ->getResult();
    }
}
