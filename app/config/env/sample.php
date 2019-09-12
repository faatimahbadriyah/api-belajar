<?php

return new \Phalcon\Config([
    'database' => [
        'adapter'    => 'Mysql',
        'host'       => 'localhost',
        'username'   => 'root',
        'password'   => '',
        'dbname'     => 'test',
        'charset'    => 'utf8',
    ],
    "application"=>[
      "swagger"=>"/swagger",
      "limit_sales_pembiayaan"=>10 , // per day
    ],
    "token"=>[
      "expire"=>60*5, // In seconds
    ],
    "mail"=> [
        'driver'     => 'smtp',
        'host'       => 'smtp.gmail.com',
        'port'       => 465,
        'encryption' => 'ssl',
        'username'   => 'example@gmail.com',
        'password'   => 'your_password',
        'from'       => [
                'email' => 'example@gmail.com',
                'name'  => 'YOUR FROM NAME'
            ]
    ],
    "file"=>[
        "base"=>BASE_PATH ."/data/",
        "activity_photo"=>"activity/photo/",
    ],
]);
