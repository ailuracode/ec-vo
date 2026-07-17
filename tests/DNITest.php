<?php

use AiluraCode\EcValidator\Entities\DNI;
use AiluraCode\EcValidator\Entities\NaturalDNI;
use AiluraCode\EcValidator\Entities\PrivateLegalDNI;
use AiluraCode\EcValidator\Entities\PublicLegalDNI;
use AiluraCode\EcValidator\Enums\States;

describe('cédulas naturales', function () {
    test('valida una cédula natural de 10 dígitos', function () {
        $dni = new NaturalDNI('1805206479');

        expect($dni)->toBeInstanceOf(NaturalDNI::class)
            ->and((string) $dni)->toBe('1805206479')
            ->and($dni->state)->toBe(States::TUNGURAHUA);
    });

    test('crea una cédula natural mediante el factory', function () {
        $dni = DNI::Natural('1805206479');

        expect($dni)->toBeInstanceOf(NaturalDNI::class)
            ->and((string) $dni)->toBe('1805206479');
    });
});

describe('cédulas jurídicas', function () {
    test('parsea una cédula jurídica privada desde una cadena', function () {
        $dni = DNI::parserFromString('1790085783001');

        expect($dni)->toBeInstanceOf(PrivateLegalDNI::class)
            ->and((string) $dni)->toBe('1790085783001')
            ->and($dni->state)->toBe(States::PICHINCHA);
    });

    test('parsea una cédula jurídica pública desde una cadena', function () {
        $dni = DNI::parserFromString('1760000070000');

        expect($dni)->toBeInstanceOf(PublicLegalDNI::class)
            ->and((string) $dni)->toBe('1760000070000')
            ->and($dni->state)->toBe(States::PICHINCHA);
    });

    test('crea una cédula jurídica privada mediante el factory', function () {
        $dni = DNI::PrivateLegal('1790085783001');

        expect($dni)->toBeInstanceOf(PrivateLegalDNI::class)
            ->and((string) $dni)->toBe('1790085783001');
    });

    test('crea una cédula jurídica pública mediante el factory', function () {
        $dni = DNI::PublicLegal('1760000070000');

        expect($dni)->toBeInstanceOf(PublicLegalDNI::class)
            ->and((string) $dni)->toBe('1760000070000');
    });
});

describe('serialización', function () {
    test('serializa una cédula jurídica privada parseada a json', function () {
        $dni = DNI::parserFromString('1790085783001');

        expect(json_encode($dni))->toBe(json_encode([
            'dni' => '1790085783001',
            'digits' => [1, 7, 9, 0, 0, 8, 5, 7, 8, 3, 0, 0, 1],
            'validation_matrix' => [4, 21, 18, 0, 0, 40, 20, 21, 16],
            'stack_error' => [],
            'state' => 17,
            'validation_digit' => 3,
        ]));
    });

    test('serializa una cédula jurídica pública parseada a json', function () {
        $dni = DNI::parserFromString('1760000070000');

        expect(json_encode($dni))->toBe(json_encode([
            'dni' => '1760000070000',
            'digits' => [1, 7, 6, 0, 0, 0, 0, 0, 7, 0, 0, 0, 0],
            'validation_matrix' => [3, 14, 42, 0, 0, 0, 0, 0],
            'stack_error' => [],
            'state' => 17,
            'validation_digit' => 7,
        ]));
    });
});

describe('validaciones de error', function () {
    test('rechaza un tipo de cédula inválido', function () {
        DNI::parserFromString('1770085783001');
    })->throws(Exception::class, 'Tipo de cedula incorrecta');

    test('rechaza una cadena no numérica', function () {
        new NaturalDNI('abc');
    })->throws(Exception::class, 'La cadena debe de contener solo n meros');

    test('rechaza una longitud inválida', function () {
        new NaturalDNI('123');
    })->throws(Exception::class, 'La cadena debe de contener exactamente 10 caracteres');

    test('rechaza un dígito verificador incorrecto', function () {
        new NaturalDNI('1805206470');
    })->throws(Exception::class, 'Digito de validación no valido');
});
