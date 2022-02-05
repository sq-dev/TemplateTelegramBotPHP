<?php

use function DI\env;

return [
    'token' => $_ENV['BOT_TOKEN'],

    'channel' => [
        'id' => $_ENV['CHANNEL_ID'],
        'cache_id' => $_ENV['CACHE_CHAT_ID']
    ]
];