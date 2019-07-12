<?php

namespace App\Entity\Team;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class Member
{
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
     * @ORM\Column(type="string")
     */
    protected $nickname;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $firstname;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $lastname;

    /**
     * @var Role
     * @ORM\ManyToOne(targetEntity="App\Entity\Team\Role", inversedBy="members")
     */
    protected $role;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $twitch;

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
