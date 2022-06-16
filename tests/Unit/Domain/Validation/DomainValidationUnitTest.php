<?php

namespace Tests\Unit\Domain\Validation;

use Core\Domain\Validation\DomainValidation;
use Core\Domain\Exception\EntityValidationException;
use PHPUnit\Framework\TestCase;

class DomainValidationUnitTest extends TestCase 
{
    public function testNotNull()
    {
        try {
            $value = '';
            DomainValidation::notNull($value);
            $this->assertTrue(false);
        } catch (\Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th);
        }
    }

    public function testNotNullCustomMessageException()
    {
        try {
            $value = '';
            DomainValidation::notNull($value, 'custom message exception');
            $this->assertTrue(false);
        } catch (\Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th, 'custom message exception');
        }
    }

    public function testStringMaxLength()
    {
        try {
            $value = 'Teste';
            DomainValidation::strMaxLength($value, 3, 'custom message exception');
            $this->assertTrue(false);
        } catch (\Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th, 'custom message exception');
        }
    }

    public function testStringMinLength()
    {
        try {
            $value = 'Test';
            DomainValidation::strMinLength($value, 8, 'custom message exception');
            $this->assertTrue(false);
        } catch (\Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th, 'custom message exception');
        }
    }

    public function testStringMCanNullAndMaxLength()
    {
        try {
            $value = 'teste';
            DomainValidation::strMCanNullAndMaxLength($value, 3, 'custom message exception');
            $this->assertTrue(false);
        } catch (\Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th, 'custom message exception');
        }
    }    
}