<?php

namespace Core\Helpers;

class InlineKeyboard
{
    protected array $keyboards = [
        'inline_keyboard' => []
    ];

    public function add(array ...$button)
    {
        $this->keyboards['inline_keyboard'][] = func_get_args();

        return $this;
    }

    public static function button($text, ?array $other = null)
    {
        $button['text'] = $text;

        if ($other) {
            $button = array_merge($button, $other);
        }

        return $button;
    }

    public function getKeyboard($json = false)
    {
        if ($json) return json_encode($this->keyboards, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        return $this->keyboards;
    }

    public function __toString()
    {
        return json_encode($this->keyboards);
    }
}
