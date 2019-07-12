<?php

namespace App\Entity\User;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\User\UserRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class User implements UserInterface
{
	const ROLE_DEFAULT = 'ROLE_USER';
	const ROLE_ADMIN = 'ROLE_ADMIN';
	const ROLE_SUPER_ADMIN = 'ROLE_SUPER_ADMIN';

    /**
     * @var UuidInterface
     * @ORM\Id()
     * @ORM\Column(type="uuid", unique=true)
     */
    private $uuid;

	/**
	 * @var string
	 * @ORM\Column(type="string")
	 */
	private $email;

	/**
	 * @var string
	 * @ORM\Column(type="string")
	 */
    private $displayName;

	/**
	 * @var string
	 * @ORM\Column(type="string", nullable=true)
	 */
	protected $discordId;

    /**
     * @var array
     * @ORM\Column(type="json")
     */
    private $roles = [];

	/**
	 * @var DateTime
	 * @Gedmo\Timestampable(on="create")
	 * @ORM\Column(type="datetime")
	 */
	protected $createdAt;

	/**
	 * @var DateTime
	 * @Gedmo\Timestampable(on="update")
	 * @ORM\Column(type="datetime")
	 */
	protected $updatedAt;

	/**
	 * @var DateTime
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	protected $deletedAt;

	public function __construct()
	{
		$this->roles = array();
		$this->uuid = Uuid::uuid4();
	}

    public function getUuid(): ?UuidInterface
    {
        return $this->uuid;
    }

    public function __toString(): string
	{
		return (string) $this->getUsername();
	}

    public function getUsername(): string
    {
        return $this->uuid->toString();
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

	public function getPassword() {}
    public function getSalt() {}
    public function eraseCredentials() {}

	public function getDisplayName(): string
	{
		return $this->displayName;
	}

	public function setDisplayName(string $displayName): self
	{
		$this->displayName = $displayName;

		return $this;
	}

	public function getEmail(): string
	{
		return $this->email;
	}

	public function setEmail(string $email): self
	{
		$this->email = $email;

		return $this;
	}

	public function getDiscordId(): string
	{
		return $this->discordId;
	}

	public function setDiscordId(string $discordId): self
	{
		$this->discordId = $discordId;

		return $this;
	}
}
