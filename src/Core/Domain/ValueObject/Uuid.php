<?php

namespace Core\Domain\ValueObject;

use Ramsey\Uuid\Uuid as RamseyUuid;
use InvalidArgumentException;

class Uuid
{
    public function __construct(private string $id)
    {
        $this->ensureIsValid($id);
    }

    public static function random(): self
    {
        return new self(RamseyUuid::uuid4()->toString());
    }

    private function ensureIsValid(string $id)
    {
        if (!RamseyUuid::isValid($id)) {
            throw new InvalidArgumentException('Invalid uuid');
        }
    }

    public function __toString(): string
    {
        return $this->id;
    }
}
