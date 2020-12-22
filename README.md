<h1 align="center">
    The PHP RSA encrypt and decrypt
</h1>

<p align="center">
    <a href="https://packagist.org/packages/orh/rsa">
        <img alt="Packagist PHP Version Support" src="https://img.shields.io/packagist/php-v/orh/rsa">
    </a>
    <a href="https://packagist.org/packages/orh/rsa">
        <img alt="Packagist Version" src="https://img.shields.io/packagist/v/orh/rsa?color=df8057">
    </a>
    <a href="https://packagist.org/packages/orh/rsa">
        <img alt="Packagist Downloads" src="https://img.shields.io/packagist/dt/orh/rsa">
    </a>
    <a href="https://github.com/ouronghuang/rsa">
        <img alt="GitHub" src="https://img.shields.io/github/license/ouronghuang/rsa">
    </a>
</p>

## 安装

```
$ composer require orh/rsa
```

## 使用

```php
use Orh\Rsa\Rsa;

$publicKey = '';
$privateKey = '';

$rsa = new Rsa($publicKey, $privateKey);

// 设置密钥
// $rsa->setKey($publicKey, $privateKey);

$data = '';
// $data = [];

// 【默认】切换公钥模式: 公钥加密，私钥解密
// $rsa->publicMode();
$encrypt = $rsa->encrypt($data);
$decrypt = $rsa->decrypt($encrypt);

// 切换私钥模式: 私钥加密，公钥解密
$rsa->privateMode();
$encrypt = $rsa->encrypt($data);
$decrypt = $rsa->decrypt($encrypt);

// 获取当前加/解密模式
$mode = $rsa->getMode();

// 加签/验签
$sign = $rsa->sign($data);
$result = $rsa->verify($data, $sign);
```

## License

MIT
