<?php

use Zanzara\Config;
use Zanzara\Zanzara;

require_once 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$config = new Config();
$config->setParseMode(Config::PARSE_MODE_MARKDOWN_LEGACY);

$zanzara = new Zanzara($_ENV['BOT_TOKEN'], $config);

$bot = new Core\Bot($zanzara, $config);

$bot->run();