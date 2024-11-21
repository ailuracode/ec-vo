<?php

namespace AiluraCode\EcValidator\Concerns;

use AiluraCode\EcValidator\Enums\States;
use AiluraCode\EcValidator\Enums\Types;
use Exception;

/**
 * Contiene métodos y propiedades para la validación de los datos.
 */
trait HasValidations
{
    /** @var array Dígitos del número de documento. */
    public array $digits = [];

    /** @var array Matriz de validación. */
    public array $validation_matrix = [];

    /** @var Types|null Tipo de documento. */
    protected ?Types $type = Types::NATURAL;

    /** @var array Stack de errores. */
    public array $stack_error = [];

    /** @var States Provincia donde se emite el documento. */
    public States $state;

    /** @var int Dígito de validación (último dígito del documento). */
    public int $validation_digit;

    /** @var array Coeficientes de validación. Para más información sobre los coeficientes ingresar al link.
     *
     * @link https://goo.su/FVHY
     * */
    protected array $validation_coefficients = [2, 1, 2, 1, 2, 1, 2, 1, 2];

    protected int $mod = 10;

    /**
     * Validación inicial del el número de documento.
     *
     * @throws Exception
     *
     * @return void
     */
    public function initialValidation(): void
    {
        $this->initialValidateValue();
        $this->initialValidateLength();
        $this->throwExceptionIfExists();
    }

    /**
     * Verifica que el número de documento sea solo números.
     *
     * @return void
     */
    public function initialValidateValue(): void
    {
        if (!preg_match('/^\d+$/', $this->dni)) {
            $this->pushStackError("La cadena debe de contener solo n meros, se recibe $this->dni");
        }
    }

    /**
     * Verifica que el número de documento tenga 10 o 13 caracteres.
     *
     * @return void
     */
    public function initialValidateLength(): void
    {
        $length = strlen($this->dni);
        if ($length !== 10 && $length !== 13) {
            $this->pushStackError("La cadena debe de contener 10 o 13 caracteres, se recibe $length");
        }
    }

    /**
     * Validación intermedia del número de documento.
     *
     * @throws Exception
     *
     * @return void
     */
    public function interimValidation(): void
    {
        $this->interimValidateStateCode();
        $this->interimValidateType();
        $this->throwExceptionIfExists();
    }

    /**
     * Valida el código de provincia.
     */
    public function interimValidateStateCode(): void
    {
        $code = $this->state->code();
        if ($code < 1 || $code > 24) {
            $this->pushStackError("Código de provincia no válido, se espera un valor entre 1 y 24, se recibe $code");
        }
    }

    /**
     * Valida el tipo de documento.
     *
     * @throws Exception
     *
     */
    public function interimValidateType(): void
    {
        $this->type ??= Types::customFrom($this->digits[2]);
        if ($this->type->value !== $this->digits[2]) {
            $this->pushStackError("Número de tipo no valida, se esperaba {$this->type->value}, se recibe {$this->digits[2]}");
        }
    }

    /**
     * Validación final del número de documento.
     */
    public function endValidation(): void
    {
        $validation_digit = ($this->mod - array_sum($this->validation_matrix) % $this->mod) % $this->mod;
        if ($validation_digit != $this->validation_digit) {
            $this->pushStackError("Digito de validación no valido, se esperaba $validation_digit, se recibe $this->validation_digit");
        }
    }

    /**
     * Asigna los datos necesarios para las validaciones.
     */
    public function setData(): void
    {
        $this->setDigits();
        $this->setState();
        $this->setValidationDigit();
    }

    /**
     * Establece la matriz de validación.
     */
    public function setMatrix(): void
    {
        $this->validation_matrix = array_map(
            fn($index, $coefficient) => (array_sum(str_split($this->digits[$index] * $coefficient)) % $this->mod),
            array_keys($this->validation_coefficients),
            $this->validation_coefficients
        );
    }

    /**
     * Establece los dígitos del número de documento.
     *
     * @return void
     */
    public function setDigits(): void
    {
        $this->digits = array_map('intval', str_split($this->dni ?: ''));
    }

    /**
     * Establece el código de provincia a partir del número de documento.
     *
     * @see \AiluraCode\EcValidator\Enums\States
     * @return void
     */
    public function setState(): void
    {
        $this->state = States::from((int) ($this->digits[0] . $this->digits[1]));
    }

    /**
     * Establece el dígito de validación.
     */
    public function setValidationDigit(): void
    {
        $this->validation_digit = $this->digits[9];
    }


    /**
     * Lanza una excepción si hay errores en la validación.
     *
     * @throws Exception
     */
    public function throwExceptionIfExists(): void
    {
        if ($this->stack_error) {
            throw new Exception('Errores en la validación: ' . implode(',', $this->stack_error));
        }
    }

    /**
     * Agrega un mensaje de error a la pila de errores.
     *
     * @param string $message El mensaje de error a agregar.
     *
     * @return void
     */
    public function pushStackError(string $message): void
    {
        $this->stack_error[] = $message;
    }
}