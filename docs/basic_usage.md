Basic Usage
===========

Valid Carriers
--------------

- AT&T
- Boost Mobile
- Cingular
- Metro PCS
- Nextel
- Sprint
- T-Mobile
- Verizon
- Virgin Mobile

Usage
-----

```
$sms = new Sms();

$carrier = "T-Mobile";
$number = "0123456789";
$subject = "Subject";
$message = "Message";
$sms->send($carrier, $number, $subject, $message);
```