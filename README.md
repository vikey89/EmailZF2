EmailZF2
========
Version 1.0

Modulo che consente l'invio di email in zend framework 2 con o senza template.

Installazione
------------
Per l'installazione usa composer [composer](http://getcomposer.org "composer - package manager").

```sh
php composer.phar require email-zf2/emailzf2:dev-master
```

Post Installazione
------------
Una volta effettuata l'installazione con composer passiamo alla configurazione.

- Crea un file nominato `email.local.php` sotto `config/autoload/`. 
Aggiungi le seguenti righe al file appena creato:

```php
<?php
return array(
    'email' => array(
        'credentials' => array(
            'from_mail' => 'support@domain.com',
            'from_name' => 'yourname',
        ),
        //use smtp or sendmail
        'transport' => 'sendmail',
        'smtp' => array(
            'host' => 'smtp.domain.com',
            'port' => 587,
            'connection_class' => 'login',
            'connection_config' => array(
                'ssl'      => 'tls',
                'username' => 'youremail',
                'password' => 'yourpassword'
            ),
        ),
    ),
);
