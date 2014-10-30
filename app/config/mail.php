<?php

return array(

    'feedback' => array(
        #'address' => 'support@grapheme.ru',
        'address' => 'az@grapheme.ru',
        #'subject' => 'Обратная связь',
        'cc' => [],
    ),

    'driver' => 'smtp',
    'host' => 'in.mailjet.com',
    'port' => 587,
    'from' => array(
        #'address' => 'support@grapheme.ru',
        'address' => 'edkh@funcfunc.ru',
        'name' => 'Netrika'
    ),
    'username' => '16b6231ee39f29d2b9df28e422037884',
    'password' => '648e2fd2af3e71d714ccf5e702f0782b',

    'sendmail' => '/usr/sbin/sendmail -bs',
    'encryption' => 'tls',

    'pretend' => 0,
);