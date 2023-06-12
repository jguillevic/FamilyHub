<?php

namespace DAL\DBA\ShoppingList;

use \Model\ShoppingList\ShoppingList;
use \Framework\Database\DbConnection;

final class ShoppingListDBA
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

    public function getFromFamilyId(int $familyId) : ShoppingList
    {
        $query = "SELECT sl.id FROM shopping_list sl WHERE sl.family_id = :familyId;";

        $shoppingList = new ShoppingList();

        try {
            if ($this->connect->beginTransac()) {
                $result = $this->connect->fetchAll($query, [ ":familyId" => $familyId ]);

                $this->connect->commitTransac();

                if (!empty($result)) {
                    $shoppingList->setId($result[0]["id"]);
                }
            }
        } catch (\Exception $e) {
            $this->connect->rollBackTransac();
        }

        return $shoppingList;
    }

    public function add(int $familyId) : int
    {
        $query = "INSERT INTO shopping_lists (family_id) VALUES (:familyId);";

        $lastId = 0;

        try {
            if ($this->connect->beginTransac()) {
                $result = $this->connect->execute($query, [ ":familyId" => $familyId ]);

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
}
