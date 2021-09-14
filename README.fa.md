# IPPanel Laravel Notification Channel

[![Packagist Downloads](https://img.shields.io/packagist/dt/mirvan/ippanel?style=for-the-badge)](https://packagist.org/packages/mirvan/ippanel)
[![Packagist Version](https://img.shields.io/packagist/v/mirvan/ippanel?style=for-the-badge)](https://packagist.org/packages/mirvan/ippanel)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=for-the-badge)](LICENSE.md)


## نصب
این پکیج یک آداپتور برای پکیج رسمی [ippanel/php-rest-sdk](https://packagist.org/packages/ippanel/php-rest-sdk)

مزایا
* دسترسی ساده به کلاس `IPPanel`
* استفاده آسان در نوتیفیکیشن لاراول

نصب با کامپوزر
``` bash
$ composer require mirvan/ippanel
```


### تنظیم 
در فایل `config/services.php` کلید دسترسی پنل خود را بشکل زیر وارد نمایید
```php
"ippanel"   => [
    'api_key'  =>  'API_KEY_SECRET',
],
```
## استفاده 

### پکیج رسمی 
برای استفاده از پکیج رسمی بصورت مستقیم

```php
use Mirvan\IPPanel\IPPanel;

$client = new IPPanel();

# return float64 type credit amount
$credit = $client->getCredit();

$bulkID = $client->send(
    "+9810001",          // originator
    ["98912xxxxxxx"],    // recipients
    "ippanel is awesome" // message
);
```
استفاده ساده تر با facade
```php
# return float64 type credit amount
$credit = \IPPanel::getCredit();

$bulkID = \IPPanel::send(
    "+9810001",          // originator
    ["98912xxxxxxx"],    // recipients
    "ippanel is awesome" // message
);
```
[مشاهده داکیومت کامل پکیج رسمی](https://github.com/ippanel/php-rest-sdk/blob/master/README.md)

### Notification Channel

میتونید شماره موبایل مقصد را در فایل مدل بشکل زیر وارد کنید
``` php
public function routeNotificationForIPPanel()
{
    return '09121234567';
}
```

همچنین میتونید شماره مبدا را در فایل مدل بشکل زیر وارد کنید 
``` php
public function ippanelOriginator()
{
    return '+983000505';
}
```

در کلاس نوتیفیکیشن ، چنل نوتیفیکیشن رو ست کنید
``` php
use Mirvan\IPPanel\IPPanelChannel;

public function via($notifiable)
{
    return [IPPanelChannel::class];
}
```
برای ارسال اس ام اس معمولی بشکل زیر عمل کنید
``` php
use Mirvan\IPPanel\IPPanelMessage;

 public function toIPPanel($notifiable)
{
    return (new IPPanelMessage)
        ->reference('09121231212')
        ->originator('+983000505')
        ->body('message');
}
```
برای ارسال پیام پترن بشکل زیر عمل کنید
``` php
use Mirvan\IPPanel\IPPanelMessage;

 public function toIPPanel($notifiable)
{
    return (new IPPanelMessage)
        ->reference('09121231212')
        ->originator('+983000505')
        ->pattern('pattern_code')
        ->variable('variable-name','1234');
}
```
بخاطر بسپارید که `reference()` و `originator()` روی  `routeNotificationForIPPanel()` و `ippanelOriginator()` بازنویسی میشوند
``` php
return (new IPPanelMessage)
    ->originator('+983000505')
    ->reference('09121231212')
    ->body('message');
```

### Available Notification Message methods

Available options for **Normal Message**
- `originator('')`: Accepts a string value between 1 and 11 characters, used as the message sender name. This will overwrite `ippanelOriginator()`
- `reference('')`: Accepts a string|array value for your message reference. This information will be returned in a status report so you can match the message and it's status. Restrictions: 1 - 32 alphanumeric characters. This will overwrite `routeNotificationForIPPanel()`
- `body('')`: Accepts a string value for the message body.

Available options for **Pattern Message**
- `originator('')`: Accepts a string value between 1 and 11 characters, used as the message sender name. This will overwrite `ippanelOriginator()`
- `reference('')`: Accepts a string value for your message reference. This information will be returned in a status report so you can match the message and it's status. Restrictions: 1 - 32 alphanumeric characters. This will overwrite `routeNotificationForIPPanel()`
- `pattern('')`: Accepts a string value for the pattern code.
- `variable('name','value')`: Accepts an string for variable name and another string for variable value
- `variables([])`: Accepts an array for variables 

## Credits

- [MirVan](https://github.com/MirvanGh)
- [MVHost](https://sms.mvhost.ir)
- [All Contributors](../../contributors)

