<?php

namespace Core\Models;

class Post extends Model
{
    protected $table = 'posts';

    protected function table()
    {
        return $this->connection->from($this->table);
    }

    public function create($data)
    {
        return $this->connection
                    ->insertInto($this->table)
                    ->values($data)
                    ->execute();
    }

    public function update($id, $data)
    {
        return $this->connection->update($this->table)->set($data)->where('id', $id)->execute();
    }

}
