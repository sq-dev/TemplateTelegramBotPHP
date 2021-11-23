<?php

namespace Core\Models;


class User  
{
    protected PDO $db;

    public array $options;

    public function __construct() {
        $this->db = new PDO();
    }

    public function getAll()
    {
        return $this->db->from('users')->fetchAll();
    }

    public function save(array $option = null)
    {
        $this->db->insertInto('users')->values($option ?? $this->options)->execute();
    }

    public function update(int $id)
    {
        return $this->db->update('users')->set($this->options)->where('user_id', $id)->execute();
    }

    public function select(string $column, int $id = null)
    {
        return $this->db->from('users')->select($column)->where('user_id', $id ?? $this->options['id'])->fetch()[$column] ?? 0;
    }



    public function has(int $id)
    {
        $row = $this->db->from('users')->where('user_id', $id);

        return count($row) > 0;
    }

    public function __set($name, $value)
    {
        $this->options[$name] = $value;
    }
}
