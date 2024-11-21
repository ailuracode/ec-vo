<?php

namespace AiluraCode\EcValidator\Entities;

use AiluraCode\EcValidator\Enums\Types;
use Exception;

class PublicLegalDNI extends NaturalDNI
{
    protected ?Types $type = Types::PUBLIC_LEGAL;

    protected int $mod = 11;

    protected array $validation_coefficients = [3, 2, 7, 6, 5, 4, 3, 2];

    /**
     * Establece el dígito de validación.
     */
    public function setValidationDigit(): void
    {
        $this->validation_digit = $this->digits[8];
    }

    public function interimValidateType(): void
    {
        if ($this->type->value != $this->digits[2]) {
            $this->pushStackError("Numero de tipo no valida, se esperaba {$this->type->value}, se recibe {$this->digits[2]}");
        }
    }

    /**
     * Establece la matriz de validación.
     */
    public function setMatrix(): void
    {
        $this->validation_matrix = array_map(
            fn($index, $coefficient) => $this->digits[$index] * $coefficient,
            array_keys($this->validation_coefficients),
            $this->validation_coefficients
        );
    }

    /**
     * Validación final del número de documento.
     */
    public function endValidation(): void
    {
        $validation_digit = ($this->mod - array_sum($this->validation_matrix) % $this->mod) % 11;
        if ($validation_digit != $this->validation_digit) {
            $this->pushStackError("Digito de validación no valido, se esperaba $validation_digit, se recibe $this->validation_digit");
        }
    }
}