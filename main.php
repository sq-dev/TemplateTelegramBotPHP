<?php

use Core\Helpers\InlineKeyboard;
use Zanzara\Config;
use Zanzara\Zanzara;

use function Core\Helpers\config;

require_once 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$config = new Config();
$config->setParseMode(Config::PARSE_MODE_MARKDOWN_LEGACY);
$config->setApiTelegramUrl('https://api.tlgr.org');

$zanzara = new Zanzara(config('bot')->token, $config);

$bot = new Core\Bot($zanzara);

$bot->run();