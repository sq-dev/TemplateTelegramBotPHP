<?php

namespace Core;

use Carbon\Carbon;
use Core\Bot\Conversations\PostAdd;
use Core\Models\Post;
use Zanzara\Context;
use Zanzara\Telegram\Type\Message;

use function Core\Helpers\config;

class Bot
{
    protected $zanzara;

    public function __construct(\Zanzara\Zanzara $bot)
    {
        $this->zanzara = $bot;
    }

    public function run()
    {
        $this->zanzara->run();
    }
}
