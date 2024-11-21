<?php

namespace AiluraCode\EcValidator\Enums;

use Exception;

enum Types: int
{
    case NATURAL = 5;

    case PUBLIC_LEGAL = 6;

    case PRIVATE_LEGAL = 9;

    /**
     * @throws Exception
     */
    public static function customFrom(int $value): self
    {
        return match (true) {
            $value <= self::NATURAL->value => self::NATURAL,
            $value == self::PUBLIC_LEGAL->value => self::PUBLIC_LEGAL,
            $value == self::PRIVATE_LEGAL->value => self::PRIVATE_LEGAL,
            default => throw new Exception("Tipo de cedula incorrecta, se esperaba un numero entre 0 y 6 o 9, se recibe $value"),
        };
    }

    public function length(): int
    {
        return match ($this->value) {
            self::NATURAL->value => 10,
            self::PRIVATE_LEGAL->value, self::PUBLIC_LEGAL->value => 13,
        };
    }

    public function validationDigit(): int
    {
        return match ($this->value) {
            self::NATURAL->value, self::PRIVATE_LEGAL->value => 1,
            self::PUBLIC_LEGAL->value => 2,
        };
    }
}