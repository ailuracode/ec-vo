<?php

use AiluraCode\EcValidator\Entities\DNI;


require '../vendor/autoload.php';

//$dni = new Natural("0602910945");
try {
    $dni2 = DNI::parserFromString("1790085783001");
    $json = json_encode($dni2);
    print_r($json);
} catch (Exception $e) {
    echo $e->getMessage();
}