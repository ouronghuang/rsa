<?php

namespace Orh\Rsa;

use Orh\Rsa\Exceptions\InvalidArgumentException;
use Orh\Rsa\Exceptions\InvalidMethodException;

class Key
{
    public static function __callStatic(string $name, array $arguments): string
    {
        $name = strtolower($name);

        if (!in_array($name, ['public', 'private'])) {
            throw new InvalidMethodException("The method [{$name}] is not allowed.");
        }

        if (!isset($arguments[0])) {
            throw new InvalidArgumentException('The argument [key] is required.');
        }

        $key = $arguments[0];

        if (!is_string($key)) {
            throw new InvalidArgumentException('The argument [key] must be a string.');
        }

        if (!preg_match('/^-----BEGIN/', $key)) {
            $name = strtoupper($name);
            $start = str_replace(':TYPE', $name, "-----BEGIN :TYPE KEY-----\n");
            $end = str_replace(':TYPE', $name, "\n-----END :TYPE KEY-----");
            $key = $start.wordwrap($key, 64, "\n", true).$end;
        }

        return $key;
    }
}
