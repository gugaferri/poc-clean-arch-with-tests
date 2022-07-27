<?php

namespace Core\Domain\Entity\Traits;

use Exception;

trait MagicMethodsTrait
{
    public function __get($name)
    {
        if (!isset($this->$name)) {
            throw new Exception('Property [' . $name . '] not found in class ' . get_class($this));
        }

        return $this->$name;
    }

    public function id(): string
    {
        return (string) $this->id;
    }

    public function createdAt(): string
    {
        return $this->createdAt->format('Y-m-d H:i:s');
    }
}
