<?php

namespace Orh\Rsa;

use Orh\Rsa\Exceptions\InvalidArgumentException;

class Rsa
{
    /**
     * 公钥.
     *
     * @var string
     */
    protected $publicKey = '';

    /**
     * 私钥.
     *
     * @var string
     */
    protected $privateKey = '';

    /**
     * 加/解密模式.
     *
     * @var string
     */
    protected $mode = 'public';

    public function __construct(string $publicKey, string $privateKey)
    {
        $this->setKey($publicKey, $privateKey);
    }

    /**
     * 设置密钥.
     */
    public function setKey(string $publicKey, string $privateKey): Rsa
    {
        $this->publicKey = Key::public($publicKey);
        $this->privateKey = Key::private($privateKey);

        return $this;
    }

    /**
     * 切换公钥模式: 公钥加密，私钥解密.
     */
    public function publicMode(): Rsa
    {
        $this->mode = 'public';

        return $this;
    }

    /**
     * 切换私钥模式: 私钥加密，公钥解密.
     */
    public function privateMode(): Rsa
    {
        $this->mode = 'private';

        return $this;
    }

    /**
     * 获取当前加/解密模式.
     */
    public function getMode(): string
    {
        return $this->mode;
    }

    /**
     * 加密.
     *
     * @param string|array $data
     *
     * @throws
     */
    public function encrypt($data): string
    {
        if (! is_string($data) && ! is_array($data)) {
            throw new InvalidArgumentException('The encrypt data must be a string or an array.');
        }

        if (is_array($data)) {
            $data = json_encode($data);
        }

        if ('public' == $this->mode) {
            $key = openssl_get_publickey($this->publicKey);
            openssl_public_encrypt($data, $encrypted, $key);
        } else {
            $key = openssl_get_privatekey($this->privateKey);
            openssl_private_encrypt($data, $encrypted, $key);
        }

        openssl_free_key($key);

        return base64_encode($encrypted);
    }

    /**
     * 解密.
     *
     * @return string|array
     */
    public function decrypt(string $data)
    {
        $data = base64_decode($data);

        if ('public' == $this->mode) {
            $key = openssl_get_privatekey($this->privateKey);
            openssl_private_decrypt($data, $decrypted, $key);
        } else {
            $key = openssl_get_publickey($this->publicKey);
            openssl_public_decrypt($data, $decrypted, $key);
        }

        openssl_free_key($key);

        $array = json_decode($decrypted, true);

        return is_array($array) ? $array : $decrypted;
    }

    /**
     * 生成签名.
     */
    public function sign(string $data): string
    {
        $key = openssl_get_privatekey($this->privateKey);
        openssl_sign($data, $signature, $key, OPENSSL_ALGO_SHA1);

        openssl_free_key($key);

        return base64_encode($signature);
    }

    /**
     * 校验签名.
     */
    public function verify(string $data, string $sign): bool
    {
        $sign = base64_decode($sign);
        $key = openssl_get_publickey($this->publicKey);
        $verify = openssl_verify($data, $sign, $key, OPENSSL_ALGO_SHA1);

        openssl_free_key($key);

        return 1 === $verify;
    }
}
