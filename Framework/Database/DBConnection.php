<?php

namespace Framework\Database;

use \Framework\Database\DbTransaction;

class DbConnection {
    /**
     * @var \PDO
     */
    private $pdo;
    /**
     * @var Transaction
     */
    private $transac;

    public function __construct() {
        $this->pdo = new \PDO(getenv("DB_ENGINE") . ":dbname=" . getenv("DB_NAME") . ";host=" . getenv("DB_SERVER"), getenv("DB_USERNAME"), getenv("DB_PASSWORD"), [ \PDO::ATTR_AUTOCOMMIT=>FALSE ]);
        $this->transac = new DbTransaction($this->pdo);
    }

    public function beginTransac() : bool {
        return $this->transac->Begin();
    }

    public function commitTransac() : bool {
        return $this->transac->Commit();
    }

    public function rollBackTransac() : bool {
        return $this->transac->RollBack();
    }

    public function execute(string $query, array $params) : bool {
        $st = $this->pdo->prepare($query);
        return $st->execute($params);
    }

    public function fetchAll(string $query, array $params) : array {
        $st = $this->pdo->prepare($query);
        $st->execute($params);
        return $st->fetchAll();
    }

    public function getLastInsertId() : string {
        return $this->pdo->lastInsertId();
    }
}
