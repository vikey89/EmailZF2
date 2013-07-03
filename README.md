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

- Aggiungiamo il modulo su `config/application.config.php` sotto l'array `modules`, inseriamo `EmailZF2`
- Crea un file nominato `email.local.php` sotto `config/autoload/`. 
- Aggiungi le seguenti righe al file appena creato:

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
```

In questo modo abbiamo appena creato il nostro file di configurazione. In questo file possiamo scegliere se mandare le email con sendmail installato sul server oppure inviare email utilizzando smtp. Se vuoi utilizzare sendmail lascia il file di configurazione cosi per come è.

Come si usa
------------
Basta creare in qualsiasi modulo una cartella per salvare i template da usare per le email. Per convenzione mettiamo la cartella sotto il modulo Application. 
- Quindi creiamo una cartella `emails` sotto `Application/view/`.
- Creiamo un template di prova chiamato `hello_world.phtml`.
- Andiamo in un qualsiasi controller e spediamo il nostro messaggio di test, in questo caso per test usiamo `IndexController` sotto il modulo `Application`. 

Controller
------------
```php
$view = new ViewModel(array(
        		'fullname' => 'Vincenzo Provenza',
));
$view->setTerminal(true);
$view->setTemplate('Application/view/emails/hello_world');
$this->mailerZF2()->send('youremail@domain.com', 'Subject: Hello World!', $view);
```

Template
------------
```php
<h4>Hi, <?= $fullname; ?></h4>
```

