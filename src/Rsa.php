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
     * 加解密方式 [public: 公钥加密，私钥解密；private: 私钥加密，公钥解密].
     *
     * @var string
     */
    protected $mode = 'public';

    public function __construct(string $publicKey, string $privateKey)
    {
        $this->publicKey = Key::public($publicKey);
        $this->privateKey = Key::private($privateKey);
    }

    // 切换模式
    public function switchMode(): Rsa
    {
        $this->mode = 'public' == $this->mode ? 'private' : 'public';

        return $this;
    }

    /**
     * 加密.
     *
     * @param string|array $data
     *
     * @return string
     */
    public function encrypt($data)
    {
        if (! is_string($data) || ! is_array($data)) {
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

    // 生成签名
    public function sign(string $data): string
    {
        $key = openssl_get_privatekey($this->privateKey);
        openssl_sign($data, $signature, $key, OPENSSL_ALGO_SHA1);

        openssl_free_key($key);

        return base64_encode($signature);
    }

    // 校验签名
    public function verify(string $data, string $sign): bool
    {
        $sign = base64_decode($sign);
        $key = openssl_get_publickey($this->publicKey);
        $verify = openssl_verify($data, $sign, $key, OPENSSL_ALGO_SHA1);

        openssl_free_key($key);

        return 1 === $verify;
    }
}
