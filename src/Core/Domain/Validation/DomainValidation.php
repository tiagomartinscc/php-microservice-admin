<?php

namespace Core\Domain\Validation;

use Core\Domain\Exception\EntityValidationException;

class DomainValidation 
{
    public static function notNull(string $value, string $exceptionMessage = null)
    {
        if (empty($value)) {
            throw new EntityValidationException($exceptionMessage ?? 'Value cannot be null');
        }
    }

    public static function strMaxLength(string $value, int $maxLength = 255, string $exceptionMessage = null)
    {
        if (strlen($value) > $maxLength) {
            throw new EntityValidationException($exceptionMessage ?? 'Value cannot be greater than ' . $maxLength);
        }
    }

    public static function strMinLength(string $value, int $minLength = 2, string $exceptionMessage = null)
    {
        if (strlen($value) < $minLength) {
            throw new EntityValidationException($exceptionMessage ?? 'Value cannot be less than ' . $minLength);
        }
    }

    public static function strMCanNullAndMaxLength(string $value = '', int $minLength = 255, string $exceptionMessage = null)
    {
        if (!empty($value) && strlen($value) > $minLength) {
            throw new EntityValidationException($exceptionMessage ?? 'Value cannot be greater than ' . $minLength);
        }
    }    
}