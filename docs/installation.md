Installation
============

This document will guide you through the process of installing Yii2-Sms using **composer**. Installation is a quick and
easy two-step process.


Step 1: Download using composer
-------------------------------

Add Yii2-Sms to the require section of your **composer.json** file:

```
{
    "require": {
        "abhi1693/yii2-sms": "*"
    }
}
```

And run following command to download extension using **composer**:

```bash
$ php composer.phar update
```

Step 2: Configure your application
----------------------------------

```
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