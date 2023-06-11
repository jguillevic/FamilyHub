<?php

namespace DAL\DBA\Family;

use \Model\Family\Family;
use \Framework\Database\DbConnection;

final class FamilyDBA
{
    /**
     * @var DbConnection
     */
    private $connect;

    public function __construct(DbConnection $connect = null) 
    {
        if ($connect == null) {
            $this->connect = new DbConnection();
        } else {
            $this->connect = $connect;
        }
    }

    public function hasFamily(int $userId) : bool
    {
        $query = "SELECT COUNT(1) AS count
FROM families F
INNER JOIN users_families UF ON F.id = UF.family_id
WHERE UF.user_id = :userId;";

        $result = true;

        try {
            if ($this->connect->beginTransac()) {
                $count = $this->connect->fetchAll(
                    $query
                    , [ ":userId" => $userId ]
                )[0]["count"];

                if ($count > 0) {
                    $result = true;
                } else {
                    $result = false;
                }

                $this->connect->commitTransac();
            }
        } catch (\Exception $e) {
            $this->connect->rollBackTransac();
        }

        return $result;
    }

    public function get(int $id)
    {
        $query = "SELECT id, code, name FROM families F WHERE F.id = :id";

        $family = new Family();

        try {
            if ($this->connect->beginTransac()) {
                $result = $this->connect->fetchAll($query, [ ":id" => $id ]);

                $this->connect->commitTransac();

                if (count($result) > 0) {
                    $family->setId($result[0]["id"]);
                    $family->setCode($result[0]["code"]);
                    $family->SetName($result[0]["name"]);
                }
            }
        } catch (\Exception $e) {
            $this->connect->rollBackTransac();
        }

        return $family;
    }

    public function getFamilyFromUserId(int $userId) : Family
    {
        $query = "SELECT id, code, name 
FROM families F
INNER JOIN users_families UF ON F.id = UF.family_id
WHERE UF.user_id = :userId;";

        $family = new Family();

        try {
            if ($this->connect->beginTransac()) {
                $result = $this->connect->fetchAll($query, [ ":userId" => $userId ]);

                $this->connect->commitTransac();

                if (count($result) > 0) {
                    $family->setId($result[0]["id"]);
                    $family->setCode($result[0]["code"]);
                    $family->SetName($result[0]["name"]);
                }
            }
        } catch (\Exception $e) {
            $this->connect->rollBackTransac();
        }

        return $family;
    }

    public function add(string $familyName) : int
    {
        $query = "INSERT INTO families (code, name) VALUES (:code, :name);";

        $lastId = 0;

        try {
            if ($this->connect->beginTransac()) {
                $result = $this->connect->execute(
                    $query
                    , [ 
                        ":code" => com_create_guid()
                        , ":name" => $familyName
                    ]);

                $lastId = $this->connect->getLastInsertId();

                if ($result) {
                    $this->connect->commitTransac();
                }
            }
        } catch (\Exception $e) {
            $this->connect->rollBackTransac();
        }

        return $lastId;
    }

    public function isCodeExists(string $familyCode) : bool
    {
        $query = "SELECT COUNT(1) AS count FROM families WHERE code = :familyCode;";

        $result = true;

        try {
            if ($this->connect->beginTransac()) {
                $count = $this->connect->fetchAll(
                    $query
                    , [ ":code" => $familyCode ]
                )[0]["count"];

                if ($count > 0) {
                    $result = true;
                } else {
                    $result = false;
                }

                $this->connect->commitTransac();
            }
        } catch (\Exception $e) {
            $this->connect->rollBackTransac();
        }

        return $result;
    }

    public function associate(string $familyId, int $userId) : bool
    {
        $query = "INSERT INTO users_families (user_id, family_id) VALUES (:userId, :familyId);";

        $result = false;

        try {
            if ($this->connect->beginTransac()) {
                $result = $this->connect->execute(
                    $query
                    , [ 
                        ":familyId" => $familyId
                        , ":userId" => $userId
                    ]);

                if ($result)
                    $this->connect->commitTransac();
            }
        } catch (\Exception $e) {
            $this->connect->rollBackTransac();
        }

        return $result;
    }
}