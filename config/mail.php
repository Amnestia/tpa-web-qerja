<?php

return [

    'driver' => 'smtp',

    'host' => 'smtp.gmail.com',

    'port' => 587,

    'from' => array('address' => 'tpa@workhard.com', 'name' => 'Working Hard'),

    'encryption' => 'tls',

    'username' => 'test.tpa.web@gmail.com',

    'password' => 'testtpaweb',

    'sendmail' => '/usr/sbin/sendmail -bs',

    'pretend' => false,

];
