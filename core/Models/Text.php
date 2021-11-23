<?php

namespace Core\Models;

class Text  
{
    public static function get(string $name)
    {
        return (new PDO)->from('texts')
                        ->select('value')
                        ->where('name', $name)
                        ->fetch()['value'] ?? 'Not Found';
    }
}
