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

    public function getFamilyFromUserId(int $userId) : Family
    {
        $family = new Family();

        $query = "SELECT id, code, name 
FROM families F
INNER JOIN users_families UF ON F.id = UF.family_id
WHERE UF.user_id = :userId;";

        try {
            if ($this->connect->BeginTransac()) {
                $result = $this->connect->FetchAll($query, [ ":userId" => $userId ]);

                $this->connect->CommitTransac();

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

    public function addFamily(string $familyName) : bool
    {
        $query = "INSERT INTO families (code, name) VALUES (:code, :name);";

        $result = false;

        try {
            if ($this->connect->beginTransac()) {
                $result = $this->connect->execute(
                    $query
                    , [ 
                        ":code" => com_create_guid()
                        , ":name" => $familyName
                    ]);

                if ($result)
                    $this->connect->commitTransac();
            }
        } catch (\Exception $e) {
            $this->connect->rollBackTransac();
        }

        return $result;
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

    public function associateFamily(string $familyCode, int $userId) : bool
    {
        $query = "SET @familyId = 0;
SELECT @familyId = id FROM families WHERE code = :familyCode;
INSERT INTO users_families (user_id, family_id) VALUES (:userId, @familyId);";

        $result = false;

        try {
            if ($this->connect->beginTransac()) {
                $result = $this->connect->execute(
                    $query
                    , [ 
                        ":familyCode" => $familyCode
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