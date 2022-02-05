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
        $this->zanzara->onCommand('start', function (Context $bot) {
            $bot->sendMessage('/add - добавить пост /all - все посты');
        });

        $this->zanzara->onCommand('add', function (Context $bot) {
            $bot->sendMessage('Отправьте пост для публикации');
            $bot->nextStep([PostAdd::class, 'start']);
        });

        $this->zanzara->onCommand('all', function (Context $bot){
            $posts = new Post;
            $text = '';
            $i = 1;
            $textData = ['Отправлено', 'Неотправлено'];
            foreach ($posts->all() as $post) {
                $text .= $i.') '.$post['public_time'].' '.$textData[$post['active']]."\n";
                $i++;
            }
            $bot->sendMessage($text, [
                'reply_markup' => [
                    'inline_keyboard' => [
                        [['callback_data' => 'publicAll', 'text' => 'Отправить все сейчас']]
                    ]
                ]
            ]);
        });

        $this->zanzara->onCbQueryData(['publicAll'], function (Context $bot){
            $bot->deleteMessage(
                $bot->getEffectiveChat()->getId(),
                $bot->getCallbackQuery()->getMessage()->getMessageId()
            );

            $posts = new Post;
            $activePosts = $posts->connection->from('posts')->where('active', 1)->fetchAll();
            foreach ($activePosts as $post ) {
                $bot->copyMessage(
                    config('bot')->channel['id'], 
                    config('bot')->channel['cache_id'],
                    $post['cache_id']
                );

                $posts->update($post['id'], ['active' => 0]);
            }
            $bot->sendMessage('Успешно отправлено');
        });

        $this->zanzara->run();
    }
}
