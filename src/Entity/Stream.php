<?php


namespace App\Entity;

use App\Entity\User\User;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class Stream
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
	 * @ORM\Column(type="string", nullable=false)
	 * @Assert\NotNull
	 * @Assert\NotBlank
	 */
	protected $streamName;

	/**
	 * @var string
	 * @ORM\Column(type="text", nullable=false)
	 * @Assert\NotNull
	 * @Assert\NotBlank
	 */
	protected $activityName;

	/**
	 * @var string
	 * @ORM\Column(type="string", nullable=true)
	 */
	protected $picture;

	/**
	 * @var User
	 * @ORM\ManyToOne(targetEntity="App\Entity\User\User", inversedBy="streams")
	 */
	protected $author;

	/**
	 * @var DateTime
	 * @ORM\Column(type="datetime")
	 * @Gedmo\Timestampable(on="create")
	 */
	protected $createdAt;

	/**
	 * @var DateTime
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	protected $updatedAt;

	/**
	 * @var DateTime
	 * @ORM\Column(type="datetime")
	 * @Gedmo\Timestampable(on="update")
	 */
	protected $streamedAt;

	/**
	 * @var DateTime
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	protected $deletedAt;

	public function __construct()
	{
		$this->uuid = Uuid::uuid4();
	}

	public function setUuid(UuidInterface $uuid): self
	{
		$this->uuid = $uuid;

		return $this;
	}

	public function getStreamName(): string
	{
		return $this->streamName;
	}

	public function setStreamName(string $streamName): self
	{
		$this->streamName = $streamName;

		return $this;
	}

	public function getActivityName(): string
	{
		return $this->activityName;
	}

	public function setActivityName(string $activityName): self
	{
		$this->activityName = $activityName;

		return $this;
	}

	public function getAuthor(): User
	{
		return $this->author;
	}

	public function setAuthor(UserInterface $author): self
	{
		$this->author = $author;

		return $this;
	}

	public function getCreatedAt(): DateTime
	{
		return $this->createdAt;
	}

	public function getUpdatedAt(): DateTime
	{
		return $this->updatedAt;
	}

	public function getStreamedAt(): ?DateTime
	{
		return $this->streamedAt;
	}

	public function setStreamedAt(?DateTime $streamedAt): self
	{
		$this->streamedAt = $streamedAt;

		return $this;
	}

	public function getPicture(): ?string
	{
		return $this->picture;
	}

	public function setPicture(?string $picture): self
	{
		$this->picture = $picture;

		return $this;
	}

}
