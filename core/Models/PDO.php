<?php

namespace Core\Models;

use Envms\FluentPDO\Query;

class PDO extends Query
{
    public function __construct(){
        parent::__construct(new \PDO('sqlite:'.$_ENV['DB_DIR'].'bot.db'));
    }
}
