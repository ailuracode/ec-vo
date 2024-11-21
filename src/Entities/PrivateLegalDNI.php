<?php

namespace AiluraCode\EcValidator\Entities;

use AiluraCode\EcValidator\Enums\Types;
use Exception;

class PrivateLegalDNI extends PublicLegalDNI
{
    protected ?Types $type = Types::PRIVATE_LEGAL;

    protected array $validation_coefficients = [4, 3, 2, 7, 6, 5, 4, 3, 2];

    public function setValidationDigit(): void
    {
        $this->validation_digit = $this->digits[9];
    }

    public function interimValidateType(): void
    {
        if ($this->type->value < $this->digits[2]) {
            $this->pushStackError("Numero de tipo no valida, se esperaba un numero entre 6, se recibe {$this->digits[2]}");
        }
    }
}