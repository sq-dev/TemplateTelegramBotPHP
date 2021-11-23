<?php

namespace Core;

use Carbon\Carbon;
use Core\Models\Text;
use Core\Models\User;
use Zanzara\Context;

class Bot
{
    protected $bot;

    protected $config;

    protected $message;

    public function __construct(\Zanzara\Zanzara $bot, $config)
    {
        $this->bot = $bot;
        $this->config = $config;

        $this->listingCommands();
    }

    protected function listingCommands()
    {
        $this->bot->onCommand('start', function (Context $bot) {
            $user = new User();
            if (!$user->has($bot->getEffectiveUser()->getId())) {
                $user->user_id = $bot->getEffectiveUser()->getId();
                $user->reg_date = Carbon::now();
                $user->name = $bot->getEffectiveUser()->getFirstName() . ' ' . $bot->getEffectiveUser()->getLastName();
                $user->save();
            } else {
                $user->name = $user->name = $bot->getEffectiveUser()->getFirstName() . ' ' . $bot->getEffectiveUser()->getLastName();
                $user->update($bot->getEffectiveUser()->getId());
            }
            $bot->sendMessage(Text::get('start'));
        });
    }

    public function run()
    {
        $this->bot->run();
    }
}
