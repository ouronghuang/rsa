<?php

namespace Orh\Rsa;

class Key
{
    /**
     * 生成公钥.
     */
    public static function public(string $key): string
    {
        return self::gen('public', $key);
    }

    /**
     * 生成私钥.
     */
    public static function private(string $key): string
    {
        return self::gen('private', $key);
    }

    /**
     * 生成相应的密钥.
     */
    protected static function gen(string $name, string $key): string
    {
        if (! preg_match('/^-----BEGIN/', $key)) {
            $name = strtoupper($name);
            $start = str_replace(':TYPE', $name, "-----BEGIN :TYPE KEY-----\n");
            $end = str_replace(':TYPE', $name, "\n-----END :TYPE KEY-----");
            $key = $start.wordwrap($key, 64, "\n", true).$end;
        }

        return $key;
    }
}
