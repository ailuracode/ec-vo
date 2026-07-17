<?php

use AiluraCode\EcValidator\Entities\DNI;
use AiluraCode\EcValidator\Entities\NaturalDNI;
use AiluraCode\EcValidator\Entities\PrivateLegalDNI;
use AiluraCode\EcValidator\Enums\States;

test('valida una cédula natural de 10 dígitos', function () {
    $dni = new NaturalDNI('1805206479');

    expect($dni)->toBeInstanceOf(NaturalDNI::class)
        ->and((string) $dni)->toBe('1805206479')
        ->and($dni->state)->toBe(States::TUNGURAHUA);
});

test('parsea una cédula jurídica privada desde una cadena', function () {
    $dni = DNI::parserFromString('1790085783001');

    expect($dni)->toBeInstanceOf(PrivateLegalDNI::class)
        ->and((string) $dni)->toBe('1790085783001')
        ->and($dni->state)->toBe(States::PICHINCHA);
});

test('serializa una cédula parseada a json', function () {
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

test('crea una cédula natural mediante el factory', function () {
    $dni = DNI::Natural('1805206479');

    expect($dni)->toBeInstanceOf(NaturalDNI::class)
        ->and((string) $dni)->toBe('1805206479');
});

test('rechaza un tipo de cédula inválido', function () {
    DNI::parserFromString('1770085783001');
})->throws(Exception::class, 'Tipo de cedula incorrecta');
