<?php

namespace Core\Models;

use Envms\FluentPDO\Queries\Select;
use Envms\FluentPDO\Query;

use function Core\Helpers\config;

abstract class Model
{
    public Query $connection;

    public function __construct()
    {
        $config = config('database');

        $pdo = new \PDO(
            $config->connection . ':' . $config->host,
            $config->user,
            $config->password
        );

        $this->connection = new Query($pdo);
    }

    abstract protected function table();

    public function all()
    {
        return $this->table()->fetchAll();
    }

    public function getById(int $id)
    {
        return $this->table()->where('id', $id)->fetch();
    }

}
