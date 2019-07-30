<?php


namespace App\Repository\Team;

use App\Entity\Team\Member;
use App\Entity\Team\Role;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use InvalidArgumentException;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Member|null find($id, $lockMode = null, $lockVersion = null)
 * @method Member|null findOneBy(array $criteria, array $orderBy = null)
 * @method Member[]    findAll()
 * @method Member[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MemberRepository extends ServiceEntityRepository
{
	public function __construct(RegistryInterface $registry)
	{
		parent::__construct($registry, Member::class);
	}

	public function getByCategory(string $category)
	{
		if (!in_array($category, Role::getAvailableCategories())) {
			throw new InvalidArgumentException();
		}

		return $this->createQueryBuilder('members')
			->leftJoin('members.role', 'role')
			->where('role.category = :category')
			->setParameter('category', $category)
			->getQuery()
			->getResult();
	}
}
