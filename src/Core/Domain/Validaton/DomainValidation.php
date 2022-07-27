<?php

namespace Core\Domain\Validaton;

use Core\Domain\Exception\EntityValidationException;

class DomainValidation
{
    public static function notNull(string $value, string $exceptMessage = null)
    {
        if (empty($value)) {
            throw new EntityValidationException($exceptMessage ?? 'Empty field');
        }
    }

    public static function stringMaxLength(string $value, int $length = 255, $exceptMessage = '')
    {
        if (strlen($value) > $length) {
            throw new EntityValidationException($exceptMessage ?? 'Max caracteres allowed');
        }
    }

    public static function stringMinLength(string $value, int $length = 3, $exceptMessage = '')
    {
        if (strlen($value) < $length) {
            throw new EntityValidationException($exceptMessage ?? 'Min caracteres allowed');
        }
    }

    public static function stringCanNullOrMaxLength(string $value, int $length = 255, $exceptMessage = '')
    {
        if (!empty($value) && (strlen($value) > $length)) {
            throw new EntityValidationException($exceptMessage ?? 'Max caracteres allowed');
        }
    }
}
