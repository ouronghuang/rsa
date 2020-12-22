<?php

namespace Orh\Rsa\Tests;

use Orh\Rsa\Key;
use PHPUnit\Framework\TestCase;

class KeyTest extends TestCase
{
    public function testPublic()
    {
        $originalKey = 'PUBLIC KEY';
        $key = Key::public($originalKey);

        $expected = "-----BEGIN PUBLIC KEY-----\n".
            wordwrap($originalKey, 64, "\n", true).
            "\n-----END PUBLIC KEY-----";

        $this->assertSame($expected, $key);
    }

    public function testFullPublic()
    {
        $originalKey = "-----BEGIN PUBLIC KEY-----\nPUBLIC KEY\n-----END PUBLIC KEY-----";
        $key = Key::public($originalKey);

        $this->assertSame($originalKey, $key);
    }

    public function testPrivate()
    {
        $originalKey = 'PRIVATE KEY';
        $key = Key::private($originalKey);

        $expected = "-----BEGIN PRIVATE KEY-----\n".
            wordwrap($originalKey, 64, "\n", true).
            "\n-----END PRIVATE KEY-----";

        $this->assertSame($expected, $key);
    }

    public function testFullPrivate()
    {
        $originalKey = "-----BEGIN PRIVATE KEY-----\nPRIVATE KEY\n-----END PRIVATE KEY-----";
        $key = Key::private($originalKey);

        $this->assertSame($originalKey, $key);
    }
}
