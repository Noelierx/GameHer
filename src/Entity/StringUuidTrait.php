<?php

namespace App\Entity;

use Ramsey\Uuid\UuidInterface;

trait StringUuidTrait
{
    /**
     * Helper to get uuid as a string.
     *
     * @return string
     */
    public function getUuidAsString()
    {
        return $this->uuid instanceof UuidInterface ? $this->uuid->toString() : $this->uuid;
    }
}
