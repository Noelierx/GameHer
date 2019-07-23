<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class Streamer
{
	use StringUuidTrait;

	/**
	 * @var int
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 * @ORM\Column(type="integer")
	 */
	protected $id;

	/**
	 * @var UuidInterface
	 * @ORM\Column(type="uuid")
	 */
	protected $uuid;

	/**
	 * @var string
	 * @ORM\Column(type="string")
	 * @Assert\NotNull
	 * @Assert\NotBlank
	 */
	protected $name;

	/**
	 * @var string
	 * @ORM\Column(type="string", nullable=false)
	 */
	protected $picture;

	/**
	 * @var string
	 * @ORM\Column(type="string", nullable=false)
	 */
	protected $channel;

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

	public function getName(): string
	{
		return $this->name;
	}

	public function setName(string $name): self
	{
		$this->name = $name;

		return $this;
	}

	public function getPicture(): string
	{
		return $this->picture;
	}

	public function setPicture(string $picture): self
	{
		$this->picture = $picture;

		return $this;
	}

	public function getChannel(): string
	{
		return $this->channel;
	}

	public function setChannel(string $channel): self
	{
		$this->channel = $channel;

		return $this;
	}
}
