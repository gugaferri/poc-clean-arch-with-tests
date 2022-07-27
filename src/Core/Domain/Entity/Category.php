<?php

namespace Core\Domain\Entity;

use Core\Domain\Entity\Traits\MagicMethodsTrait;
use Core\Domain\Validaton\DomainValidation;
use Core\Domain\ValueObject\Uuid;
use DateTime;

class Category
{
    use MagicMethodsTrait;
    public function __construct(
        protected Uuid|string $id = '',
        protected string $name = '',
        protected string $description = '',
        protected bool $isActive = true,
        protected DateTime|string $createdAt = '',
    ){
        $this->id = $this->id ? new Uuid($this->id) : Uuid::random();
        $this->createdAt = new DateTime($this->createdAt ?? 'now');
        $this->validate();
    }

    public function activate(): void
    {
        $this->isActive = true;
    }

    public function disable(): void
    {
        $this->isActive = false;
    }

    public function update(string $name, string $description = null)
    {
        $this->name = $name;
        $this->description = $description ?? $this->description;
    }

    private function validate()
    {
        DomainValidation::notNull($this->name);
        DomainValidation::stringMinLength($this->name);
        DomainValidation::stringMaxLength($this->name);
        DomainValidation::stringCanNullOrMaxLength($this->description);
    }
}

