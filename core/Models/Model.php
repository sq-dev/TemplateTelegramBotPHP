<?php

namespace Core\Models;

use Envms\FluentPDO\Queries\Select;
use Envms\FluentPDO\Query;

use function Core\Helpers\config;

abstract class Model extends Query
{

    public function __construct()
    {
        $config = config('database');

        $pdo = new \PDO(
            $config->connection . ':' . $config->host,
            $config->user,
            $config->password
        );

        parent::__construct($pdo);

        $this->setTableName($this->table());
    }

    abstract protected function table();

    public function all()
    {
        return $this->from()->fetchAll();
    }

    public function getById(int $id)
    {
        return $this->from()->where('id', $id)->fetch();
    }

}
