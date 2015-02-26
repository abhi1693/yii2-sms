Yii2-Sms
========

[![Dependency Status](https://www.versioneye.com/user/projects/54e1e66a0a910b25de0001b0/badge.svg?style=flat)](https://www.versioneye.com/user/projects/54e1e66a0a910b25de0001b0)
[![Latest Stable Version](https://poser.pugx.org/abhi1693/yii2-sms/v/stable.svg)](https://packagist.org/packages/abhi1693/yii2-sms) [![Total Downloads](https://poser.pugx.org/abhi1693/yii2-sms/downloads.svg)](https://packagist.org/packages/abhi1693/yii2-sms) [![Latest Unstable Version](https://poser.pugx.org/abhi1693/yii2-sms/v/unstable.svg)](https://packagist.org/packages/abhi1693/yii2-sms) [![License](https://poser.pugx.org/abhi1693/yii2-sms/license.svg)](https://packagist.org/packages/abhi1693/yii2-sms)

Yii2-Sms sends free messages using Swift Mail

Documentation
=============

## Installation


This document will guide you through the process of installing Yii2-Sms using **composer**.


#### Download using composer


Add Yii2-Sms to the require section of your **composer.json** file:

```php
{
    "require": {
        "abhi1693/yii2-sms": "2.0.0"
    }
}
```

And run following command to download extension using **composer**:

```php
$ php composer.phar update
```

## Basic Usage

#### Valid Carriers

- AT&T
- Boost Mobile
- Cingular
- Metro PCS
- Nextel
- Sprint
- T-Mobile
- Verizon
- Virgin Mobile

#### Usage

```php
$sms = new Sms();

$sms->transportType    = 'php'; // php/smtp
$sms->transportOptions = [
        'host'       => 'smtp.gmail.com'                  // Other domains can also be used
                'username'   => 'your@gmail.com',
                'password'   => '******',
                'port'       => '465',
                'encryption' => 'ssl'
    ];
$carrier = "T-Mobile";
$number = "0123456789";
$subject = "Subject";
$message = "Message";
$sms->send($carrier, $number, $subject, $message);
```

#### How to contribute?

Contributing instructions are located in [CONTRIBUTING.md](CONTRIBUTING.md) file.

## License

Yii2-sms is released under the MIT License. See the bundled [LICENSE](LICENSE.md) for details.
