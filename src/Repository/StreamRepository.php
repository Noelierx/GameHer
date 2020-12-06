<?php


namespace App\Repository;

use App\Entity\Stream;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Stream|null find($id, $lockMode = null, $lockVersion = null)
 * @method Stream|null findOneBy(array $criteria, array $orderBy = null)
 * @method Stream[]    findAll()
 * @method Stream[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StreamRepository extends ServiceEntityRepository
{
	public function __construct(RegistryInterface $registry)
	{
		parent::__construct($registry, Stream::class);
	}
}
