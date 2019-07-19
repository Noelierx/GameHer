<?php

namespace App\Entity\Team;

use App\Entity\StringUuidTrait;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class Role
{
    use StringUuidTrait;

    const CATEGORY_DIRECTION = 'direction';
    const CATEGORY_ADMINISTRATION = 'administration';
    const CATEGORY_MEMBERS = 'members';
    const CATEGORY_ESPORT = 'esport';

    /**
     * @var int
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
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
     */
    protected $category;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=false)
     */
    protected $name;

    /**
     * @var ArrayCollection|Member[]
     * @ORM\OneToMany(targetEntity="App\Entity\Team\Member", mappedBy="role")
     */
    protected $members;

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

    public static function getAvailableCategories()
    {
        return [
            self::CATEGORY_ADMINISTRATION,
            self::CATEGORY_DIRECTION,
            self::CATEGORY_ESPORT,
            self::CATEGORY_MEMBERS,
        ];
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;

        return $this;
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

    public function getMembers()
    {
        return $this->members;
    }

    public function setMembers($members): self
    {
        $this->members = $members;

        return $this;
    }

    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }
}
