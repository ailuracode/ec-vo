<?php

namespace AiluraCode\EcValidator\Enums;

enum States: int
{
    case AZUAY = 1;
    case BOLIVAR = 2;
    case CANAR = 3;
    case CARCHI = 4;
    case COTOPAXI = 5;
    case CHIMBORAZO = 6;
    case ELORO = 7;
    case ESMERALDAS = 8;
    case GUAYAS = 9;
    case IMBABURA = 10;
    case LOJA = 11;
    case LOSRIOS = 12;
    case MANABI = 13;
    case MORONA = 14;
    case NAPO = 15;
    case PASTAZA = 16;
    case PICHINCHA = 17;
    case TUNGURAHUA = 18;
    case ZAMORA = 19;
    case GALAPAGOS = 20;
    case SUCUMBIOS = 21;
    case ORELLANA = 22;
    case SANTODOMINGO = 23;
    case OTHERS = 24;

    public function name(): string
    {
        return match ($this) {
            self::AZUAY => 'Azuay',
            self::BOLIVAR => 'Bolivar',
            self::CANAR => 'Canar',
            self::CARCHI => 'Carchi',
            self::COTOPAXI => 'Cotopaxi',
            self::CHIMBORAZO => 'Chimborazo',
            self::ELORO => 'El Oro',
            self::ESMERALDAS => 'Esmeraldas',
            self::GUAYAS => 'Guayas',
            self::IMBABURA => 'Imbabura',
            self::LOJA => 'Loja',
            self::LOSRIOS => 'Los Rios',
            self::MANABI => 'Manabi',
            self::MORONA => 'Morona',
            self::NAPO => 'Napo',
            self::PASTAZA => 'Pastaza',
            self::PICHINCHA => 'Pichincha',
            self::TUNGURAHUA => 'Tungurahua',
            self::ZAMORA => 'Zamora',
            self::GALAPAGOS => 'Galapagos',
            self::SUCUMBIOS => 'Sucumbios',
            self::ORELLANA => 'Orellana',
            self::SANTODOMINGO => 'Santo Domingo',
            self::OTHERS => 'Others',
        };
    }

    public function code(): int {
        return $this->value;
    }
}
