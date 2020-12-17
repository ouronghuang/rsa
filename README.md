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

$data = '';
// $data = [];

//默认：公钥加密，私钥解密
$encrypt = $rsa->encrypt($data);
$decrypt = $rsa->decrypt($encrypt);

// 切换到：私钥加密，公钥解密
$rsa->switchMode();
$encrypt = $rsa->encrypt($data);
$decrypt = $rsa->decrypt($encrypt);

// 加签/验签
$sign = $rsa->sign($data);
$result = $rsa->verify($data, $sign);
```

## License

MIT
