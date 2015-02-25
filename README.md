Yii2-Sms
========

[![Dependency Status](https://www.versioneye.com/user/projects/54e1e66a0a910b25de0001b0/badge.svg?style=flat)](https://www.versioneye.com/user/projects/54e1e66a0a910b25de0001b0)
[![Latest Stable Version](https://poser.pugx.org/abhi1693/yii2-sms/v/stable.svg)](https://packagist.org/packages/abhi1693/yii2-sms) [![Total Downloads](https://poser.pugx.org/abhi1693/yii2-sms/downloads.svg)](https://packagist.org/packages/abhi1693/yii2-sms) [![Latest Unstable Version](https://poser.pugx.org/abhi1693/yii2-sms/v/unstable.svg)](https://packagist.org/packages/abhi1693/yii2-sms) [![License](https://poser.pugx.org/abhi1693/yii2-sms/license.svg)](https://packagist.org/packages/abhi1693/yii2-sms)

Yii2-Sms sends free messages using Swift Mail

Documentation
=============

## Installation


This document will guide you through the process of installing Yii2-Sms using **composer**. Installation is a quick and
easy two-step process.


#### Step 1: Download using composer


Add Yii2-Sms to the require section of your **composer.json** file:

```php
{
    "require": {
        "abhi1693/yii2-sms": "1.0.0"
    }
}
```

And run following command to download extension using **composer**:

```bash
$ php composer.phar update
```

#### Step 2: Configure your application

```php
$config = [
    ...
    'components' => [
        ...
        'sms' => [
            'class'             => 'abhimanyu\sms\components\Sms' // Class (Required)
            'transportType'     => 'smtp'                         // smtp/php (Optional)
            'transportOptions'  => [                              // (Required)
                'host'       => 'smtp.gmail.com'                  // Other domains can also be used
                'username'   => 'your@gmail.com',
                'password'   => '******',
                'port'       => '465',
                'encryption' => 'ssl'
            ]
        ]
    ]
]
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
