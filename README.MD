# Monolog Handler for wp_mail

This library contains one class, that can be registered to send mails with wordpress' `wp_mail` function.
Does only work in wordpress, which is *not* listed as dependency in composer.

For using this, you should check out monolog's documentation: https://github.com/Seldaek/monolog/

## Example:
```php
use Monolog\Logger;
use phylogram\MonologWPMailHandler\WPMailHandler;

$logger = new Logger('channel');
$logger->pushHandler(new WPMailHandler(['any.valid@mail.addresses'], Logger::WARNING));
$logger->alert('No more coffee in office');
```
