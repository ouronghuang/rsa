<?php

namespace Orh\Rsa\Tests;

use Orh\Rsa\Rsa;
use PHPUnit\Framework\TestCase;

class RsaTest extends TestCase
{
    protected $publicKey = '-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCmkANmC849IOntYQQdSgLvMMGm
8V/u838ATHaoZwvweoYyd+/7Wx+bx5bdktJb46YbqS1vz3VRdXsyJIWhpNcmtKhY
inwcl83aLtzJeKsznppqMyAIseaKIeAm6tT8uttNkr2zOymL/PbMpByTQeEFlyy1
poLBwrol0F4USc+owwIDAQAB
-----END PUBLIC KEY-----';

    protected $privateKey = '-----BEGIN PRIVATE KEY-----
MIICdgIBADANBgkqhkiG9w0BAQEFAASCAmAwggJcAgEAAoGBAKaQA2YLzj0g6e1h
BB1KAu8wwabxX+7zfwBMdqhnC/B6hjJ37/tbH5vHlt2S0lvjphupLW/PdVF1ezIk
haGk1ya0qFiKfByXzdou3Ml4qzOemmozIAix5ooh4Cbq1Py6202SvbM7KYv89syk
HJNB4QWXLLWmgsHCuiXQXhRJz6jDAgMBAAECgYAIF5cSriAm+CJlVgFNKvtZg5Tk
93UhttLEwPJC3D7IQCuk6A7Qt2yhtOCvgyKVNEotrdp3RCz++CY0GXIkmE2bj7i0
fv5vT3kWvO9nImGhTBH6QlFDxc9+p3ukwsonnCshkSV9gmH5NB/yFoH1m8tck2Gm
BXDj+bBGUoKGWtQ7gQJBANR/jd5ZKf6unLsgpFUS/kNBgUa+EhVg2tfr9OMioWDv
MSqzG/sARQ2AbO00ytpkbAKxxKkObPYsn47MWsf5970CQQDIqRiGmCY5QDAaejW4
HbOcsSovoxTqu1scGc3Qd6GYvLHujKDoubZdXCVOYQUMEnCD5j7kdNxPbVzdzXll
9+p/AkEAu/34iXwCbgEWQWp4V5dNAD0kXGxs3SLpmNpztLn/YR1bNvZry5wKew5h
z1zEFX+AGsYgQJu1g/goVJGvwnj/VQJAOe6f9xPsTTEb8jkAU2S323BG1rQFsPNg
jY9hnWM8k2U/FbkiJ66eWPvmhWd7Vo3oUBxkYf7fMEtJuXu+JdNarwJAAwJK0YmO
LxP4U+gTrj7y/j/feArDqBukSngcDFnAKu1hsc68FJ/vT5iOC6S7YpRJkp8egj5o
pCcWaTO3GgC5Kg==
-----END PRIVATE KEY-----';

    public function testUseStringByPublic()
    {
        $rsa = new Rsa($this->publicKey, $this->privateKey);

        $data = 'This is need encrypt data.';
        $encrypt = $rsa->encrypt($data);
        $decrypt = $rsa->decrypt($encrypt);

        $this->assertSame($decrypt, $data);
    }

    public function testUseArrayByPublic()
    {
        $rsa = new Rsa($this->publicKey, $this->privateKey);

        $data = [
            'This',
            'is',
            'need',
            'encrypt',
            'data',
        ];
        $encrypt = $rsa->encrypt($data);
        $decrypt = $rsa->decrypt($encrypt);

        $this->assertSame($decrypt, $data);
    }

    public function testUseStringByPrivate()
    {
        $rsa = new Rsa($this->publicKey, $this->privateKey);
        $rsa->privateMode();

        $data = 'This is need encrypt data.';
        $encrypt = $rsa->encrypt($data);
        $decrypt = $rsa->decrypt($encrypt);

        $this->assertSame($decrypt, $data);
    }

    public function testUseArrayByPrivate()
    {
        $rsa = new Rsa($this->publicKey, $this->privateKey);
        $rsa->privateMode();

        $data = [
            'This',
            'is',
            'need',
            'encrypt',
            'data',
        ];
        $encrypt = $rsa->encrypt($data);
        $decrypt = $rsa->decrypt($encrypt);

        $this->assertSame($decrypt, $data);
    }

    public function testVerify()
    {
        $rsa = new Rsa($this->publicKey, $this->privateKey);

        $data = 'This is need sign data.';
        $sign = $rsa->sign($data);
        $result = $rsa->verify($data, $sign);

        $this->assertTrue($result);
    }
}
