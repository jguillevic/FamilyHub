<?php

namespace Framework\Database;

final class DbTransaction {
    /**
     * @var int 
     */
    private $count;
    /**
     * @var \PDO
     */
    private $pdo;

    public function __construct(\PDO $pdo) 
    {
        if ($pdo == null)
            throw new \InvalidArgumentException("\$pdo should be set !");

        $this->pdo = $pdo;
    }

    public function begin() : bool 
    {
        $result = false;

        if ($this->count == 0)
            $result = $this->pdo->beginTransaction();
        else
            $result = true;

        if ($result)
            $this->count++;

        return $result;
    }

    public function commit() : bool 
    {
        if ($this->count == 1)
            $result = $this->pdo->commit();
        else
            $result = true;

        if ($result)
            $this->count--;

        return $result;
    }

    public function rollBack() : bool 
    {
        if ($this->count > 0) {
            $this->count = 0;
            return $this->pdo->rollBack();
        } else {
            return true;
        }
    }
}