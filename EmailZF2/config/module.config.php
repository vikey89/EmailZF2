<?php
return array(
    'email' => array(
        'credentials' => array(
            'from_mail' => 'support@domain.com',
            'from_name' => 'yourname',
        ),
        'transport' => 'sendmail', //use smtp or sendmail
        'smtp' => array(
            'host' => 'smtp.domain.com',
            'port' => 587,
            'connection_class' => 'login',
            'connection_config' => array(
                'ssl'      => 'tls',
                'username' => 'yourgmailusername',
                'password' => 'yourgmailpassword'
            ),
        ),
    ),
);
