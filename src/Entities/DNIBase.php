<?php

namespace AiluraCode\EcValidator\Entities;

use AiluraCode\EcValidator\Concerns\HasValidations;
use AiluraCode\EcValidator\Contracts\IsValidable;
use Exception;

abstract class DNIBase implements IsValidable
{
    use HasValidations;

    /**
     * @throws Exception
     */
    public function __construct(
        public string $dni,
    ) {
        $this->validate();
    }

    /**
     * @throws Exception
     */
    public function validate(): void
    {
        $this->initialValidation();
        $this->setData();
        $this->interimValidation();
        $this->setMatrix();
        $this->endValidation();
        $this->throwExceptionIfExists();
    }

    public function __toString(): string
    {
        return $this->dni;
    }
}