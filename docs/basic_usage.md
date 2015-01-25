Basic Usage
===========

Send Sms
--------
```
$carrier = "T-Mobile";
$number = "0123456789";
$subject = "Subject";
$message = "Message";
$sms->send($carrier, $number, $subject, $message);
```