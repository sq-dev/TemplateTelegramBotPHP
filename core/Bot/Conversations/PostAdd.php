<?php

namespace Core\Bot\Conversations;

use Carbon\Carbon;
use Core\Models\Post;
use Zanzara\Context;
use Zanzara\Telegram\Type\Message;

use function Core\Helpers\config;

class PostAdd
{
    public function start(Context $bot)
    {
        $bot->forwardMessage(
            config('bot')->channel['cache_id'], 
            $bot->getEffectiveChat()->getId(), 
            $bot->getMessage()->getMessageId()
        )->then(function (Message $message) use ($bot){
            $bot->setUserDataItem('message_id', $message->getMessageId());
        });

        $bot->sendMessage('Принято теперь введите дату отправки в формате (д.м.г ч:м)');

        $bot->nextStep([self::class, 'getDate']);
    }

    public function getDate(Context $bot)
    {
        if (!Carbon::hasFormat($bot->getMessage()->getText(), 'd.m.Y H:i')) {
            $bot->sendMessage('Не правильный формат, вот пример `12.09.2021 12:30`');
        }else {
            $time = Carbon::parse($bot->getMessage()->getText());
            
            if(Carbon::now() > $time){
                $bot->sendMessage('Это уже прошлое');
            }else {
                $post = new Post;
                $bot->getUserDataItem('message_id')->then(function ($messageId) use ($post, $time){
                    $post->create([
                        'public_time' => $time,
                        'cache_id' => $messageId
                    ]);
                });

                $bot->sendMessage('Успешно Сохранено');
                $bot->endConversation();
            }
        }
    }
}
