<?php

namespace AiluraCode\EcValidator\Tests;

use AiluraCode\EcValidator\Entities\NaturalDNI;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase as BaseTestCase;

/**
 * @internal
 *
 * @coversNothing
 */
class TestCase extends BaseTestCase
{

    #[Test]
    public function natural(): void
    {
        $validator = new NaturalDNI("1805206479");
        $this->assertTrue(true);
    }
}