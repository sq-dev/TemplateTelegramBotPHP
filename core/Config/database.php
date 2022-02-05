<?php

return [
    'connection' => $_ENV['DB_CONNECTION'],
    'host' => $_ENV['DB_HOST'],
    'port' =>$_ENV['DB_PORT'],
    'user' => $_ENV['DB_USER'],
    'password' => $_ENV['DB_PASS']
];