<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * Class Partner
 * @ORM\Entity
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class Partner
{
	/**
	 * @var UuidInterface
	 * @ORM\Id
	 * @ORM\Column(type="uuid")
	 */
	protected $uuid;

	/**
	 * @var string
	 * @ORM\Column(type="string")
	 */
	protected $name;

	/**
	 * @var string
	 * @ORM\Column(type="text")
	 */
	protected $description;

	/**
	 * @var string
	 */
	protected $logo;

	/**
	 * @var string
	 * @ORM\Column(type="string")
	 */
	protected $website;

	/**
	 * @var string
	 * @ORM\Column(type="string")
	 */
	protected $twitter;

	/**
	 * @var string
	 * @ORM\Column(type="string")
	 */
	protected $facebook;

	/**
	 * @var string
	 * @ORM\Column(type="string")
	 */
	protected $instagram;

	/**
	 * @var DateTime
	 * @ORM\Column(type="datetime")
	 * @Gedmo\Timestampable(on="create")
	 */
	protected $createdAt;

	/**
	 * @var DateTime
	 * @ORM\Column(type="datetime")
	 * @Gedmo\Timestampable(on="update")
	 */
	protected $updatedAt;

	/**
	 * @var DateTime
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	protected $deletedAt;

	public function __construct()
	{
		$this->uuid = Uuid::uuid4();
	}
}