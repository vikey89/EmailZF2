[![Total Downloads](https://poser.pugx.org/email-zf2/emailzf2/downloads.png)](https://packagist.org/packages/email-zf2/emailzf2)
EmailZF2
========
Version 1.1

Module which allows sending emails in Zend Framework 2 with or without template.

Installation
------------
For the installation use composer [composer](http://getcomposer.org "composer - package manager").

```sh
php composer.phar require email-zf2/emailzf2:dev-master
```
If you have installed composer:
```sh
composer require email-zf2/emailzf2:dev-master
```

Post Installation
------------
Once the installation with composer pass to the configuration.

- Add the module of `config/application.config.php` under array `modules`, insert `EmailZF2`
- Create a file named `email.local.php` under `config/autoload/`. 
- Add the following lines to the file you just created:

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

In this way we have just created our configuration file. In this file we can choose whether to send emails with sendmail installed on the server or send email using smtp. If you want to leave the sendmail configuration file so as it is.

Usage
------------
Just create any module in a folder to save the template to use for emails. By convention we put the folder in the Application Module.
- create a folder `emails` under `Application/view/`.
- create a template `hello_world.phtml`.
- Come in any Controller and ship our test message, in this case for test use `IndexController` under module `Application`. 

Controller
------------

- Normal version

```php
$view = new ViewModel(array(
    			'fullname' => 'Vincenzo Provenza',
            ));
$view->setTerminal(true);
$view->setTemplate('Application/view/emails/hello_world');
$this->mailerZF2()->send(array(
	'to' => 'email@domain.it',
	'subject' => 'This is subject'
), $view);
```

- With Version Cc

```php
$view = new ViewModel(array(
        		'fullname' => 'Vincenzo Provenza',
            ));
$view->setTerminal(true);
$view->setTemplate('Application/view/emails/hello_world');
$this->mailerZF2()->send(array(
	'to' => 'email@domain.com',
    'cc' => 'email2@domain.com'
	'subject' => 'This is subject'
), $view);
```

- With Version Cc & Bcc

```php
$view = new ViewModel(array(
            	'fullname' => 'Vincenzo Provenza',
            ));
$view->setTerminal(true);
$view->setTemplate('Application/view/emails/hello_world');
$this->mailerZF2()->send(array(
	'to' => 'email@domain.com',
    'cc' => 'email2@domain.com'
    'bcc' => 'email3@domain.com'
	'subject' => 'This is subject'
), $view);
```

- With Version addReplyTo

```php
$view = new ViewModel(array(
                'fullname' => 'Vincenzo Provenza',
            ));
$view->setTerminal(true);
$view->setTemplate('Application/view/emails/hello_world');
$this->mailerZF2()->send(array(
    'to' => 'email@domain.com',
    'replyTo' => 'mariorossi@domain.com'
    'replyNameTo' => 'Mario Rossi'
    'subject' => 'This is subject'
), $view);
```

Template
------------
```php
<h4>Hi, <?= $fullname; ?></h4>
```




