# IPPanel Laravel Notification Channel

[![Packagist Downloads](https://img.shields.io/packagist/dt/mirvan/ippanel?style=for-the-badge)](https://packagist.org/packages/mirvan/ippanel)
[![Packagist Version](https://img.shields.io/packagist/v/mirvan/ippanel?style=for-the-badge)](https://packagist.org/packages/mirvan/ippanel)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=for-the-badge)](LICENSE.md)

## Contents

- [Installation](#installation)
	- [Setting up the IPPanel service](#setting-up-the-ippanel-service)
- [Usage](#usage)
	- [Available Message methods](#available-message-methods)
- [Changelog](#changelog)
- [Security](#security)
- [Contributing](#contributing)
- [Credits](#credits)
- [License](#license)


## Installation

You can install the package via composer:
``` bash
$ composer require mirvan/ippanel
```


### Setting up the IPPanel service
You need to set your api key in `config/services.php`
```php
"ippanel"   => [
    'api_key'  =>  'API_KEY_SECRET',
],
```
## Usage
You can set Reference in your model
``` php
public function routeNotificationForIPPanel()
{
    return '09121234567';
}
```

You can set Originator in your model
``` php
public function ippanelOriginator()
{
    return '+983000505';
}
```

Set channel in notification class
``` php
use Mirvan\IPPanel\IPPanelChannel;

public function via($notifiable)
{
    return [IPPanelChannel::class];
}
```
For send normal message
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
For pattern message
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
Remember: `reference()` and `originator()` is overwrite  `routeNotificationForIPPanel()` and `ippanelOriginator()`
``` php
return (new IPPanelMessage)
    ->originator('+983000505')
    ->reference('09121231212')
    ->body('message');
```

### Available Message methods

- `originator('')`: Accepts a string value between 1 and 11 characters, used as the message sender name. This will overwrite `ippanelOriginator()`
- `reference('')`: Accepts a string value for your message reference. This information will be returned in a status report so you can match the message and it's status. Restrictions: 1 - 32 alphanumeric characters. This will overwrite `routeNotificationForIPPanel()`

Available options for **Normal Message**
- `body('')`: Accepts a string value for the message body.

Available options for **Pattern Message**
- `pattern('')`: Accepts a string value for the pattern code.
- `variable('name','value')`: Accepts an string for variable name and another string for variable value
- `variables([])`: Accepts an array for variables 

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Security

If you discover any security related issues, please email me@mirvan.ir instead of using the issue tracker.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [MirVan](https://github.com/MirvanGh)
- [MVHost](https://sms.mvhost.ir)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
