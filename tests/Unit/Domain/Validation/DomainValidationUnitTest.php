<?php

namespace Tests\Unit\Domain\Validation;

use Core\Domain\Exception\EntityValidationException;
use Core\Domain\Validaton\DomainValidation;
use PHPUnit\Framework\TestCase;

class DomainValidationUnitTest extends TestCase
{
    public function testNotNull()
    {
        try {
            $value = '';
            DomainValidation::notNull($value);
            $this->assertTrue(false);
        } catch(\Throwable $throwable) {
            $this->assertInstanceOf(EntityValidationException::class, $throwable);
        }
    }

    public function testNotNullCustomMessageException()
    {
        $customMessage = 'custom message';
        try {
            $value = '';
            DomainValidation::notNull($value, $customMessage);
            $this->assertTrue(false);
        } catch(\Throwable $throwable) {
            $this->assertEquals($customMessage, $throwable->getMessage());
            $this->assertInstanceOf(EntityValidationException::class, $throwable);
        }
    }

    public function testStringMaxLength()
    {
        try {
            $value = 'Length';
            DomainValidation::stringMaxLength($value, 5, 'Length not allowed');
            $this->assertTrue(false);
        } catch(\Throwable $throwable) {
            $this->assertInstanceOf(EntityValidationException::class, $throwable);
        }
    }

    public function testStringMinLength()
    {
        try {
            $value = 'Length';
            DomainValidation::stringMinLength($value, 7, 'Length not allowed');
            $this->assertTrue(false);
        } catch(\Throwable $throwable) {
            $this->assertInstanceOf(EntityValidationException::class, $throwable);
        }
    }

    public function testStringCanNullOrMaxLength()
    {
        try {
            $value = '1234';
            DomainValidation::stringCanNullOrMaxLength($value, 3, 'Custom message');
            $this->assertTrue(false);

        } catch (\Throwable $throwable) {
            $this->assertInstanceOf(EntityValidationException::class, $throwable);
        }
    }
}
