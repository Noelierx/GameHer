<?php

namespace App\Entity\Team;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 */
class Member extends AMember
{
    /**
     * @var Role
     * @ORM\ManyToOne(targetEntity="App\Entity\Team\Role", inversedBy="members")
     * @Assert\NotNull
     */
    protected $role;

    public function getRole(): ?Role
    {
        return $this->role;
    }

    public function setRole(Role $role): self
    {
        $this->role = $role;

        return $this;
    }
}
