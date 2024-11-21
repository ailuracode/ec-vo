<?php

namespace AiluraCode\EcValidator\Entities;

use AiluraCode\EcValidator\Contracts\IsValidable;
use AiluraCode\EcValidator\Enums\Types;
use Exception;

class DNI
{
    /**
     * @throws Exception
     */
    public static function Natural(string $dni): NaturalDNI
    {
        return new NaturalDNI($dni);
    }

    /**
     * @throws Exception
     */
    public static function PublicLegal(string $dni): PublicLegalDNI
    {
        return new PublicLegalDNI($dni);
    }

    /**
     * @throws Exception
     */
    public static function PrivateLegal(string $dni): PrivateLegalDNI
    {
        return new PrivateLegalDNI($dni);
    }

    /**
     * @throws Exception
     */
    public static function parserFromString(string $dni): DNIBase
    {
        $third_digit = substr($dni, 2, 1);

        return match (true) {
            $third_digit <= Types::NATURAL->value => new NaturalDNI($dni),
            $third_digit == Types::PUBLIC_LEGAL->value => new PublicLegalDNI($dni),
            $third_digit == Types::PRIVATE_LEGAL->value => new PrivateLegalDNI($dni),
            default => throw new Exception("Tipo de cedula incorrecta, se esperaba un numero entre 0 y 6 o 9, se recibe $third_digit"),
        };
    }
}