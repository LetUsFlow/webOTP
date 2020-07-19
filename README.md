# webOTP

webOTP is a web-based [TOTP](https://en.wikipedia.org/wiki/Time-based_One-time_Password_algorithm)-Client like Google Authenticator but just in your browser.

## How it works
webOTP utilizes [php-totp](https://github.com/greymich/php-totp) for the generation of the OTP-Codes and [PHP QR Code](http://phpqrcode.sourceforge.net/) for QR-Code generation.
As for the database, a MariaDB databse is used but with PDO (PHP Data Object) almost every type of database can be used.
For password-hashing salted sha3-512 is used as it is more secure than sha2.



© Florentin Schäfer
