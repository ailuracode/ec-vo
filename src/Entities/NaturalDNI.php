<?php

namespace AiluraCode\EcValidator\Entities;

use AiluraCode\EcValidator\Enums\Types;
use Exception;

class NaturalDNI extends DNIBase
{
    public function interimValidateType(): void
    {
        if ($this->type->value < $this->digits[2]) {
            $this->pushStackError("Numero de tipo no valida, se esperaba un numero entre 0 y 5, se recibe {$this->digits[2]}");
        }
    }

    /**
     * @throws Exception
     */
    public function initialValidateLength(): void
    {
        if (strlen($this->dni) != $this->type->length()) {
            $this->pushStackError("La cadena debe de contener exactamente {$this->type->length()} caracteres, se recibe " . strlen($this->dni) . '.');
        }
    }
}