<?php

namespace DAL\DBA\ShoppingList;

use \Model\ShoppingList\ShoppingListItem;
use \Framework\Database\DbConnection;

final class ShoppingListItemDBA
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

    public function getAll(int $shoppingListId) : array
    {
        $slis = [];

        $query = "SELECT sli.id, sli.name, sli.is_checked"
                . "FROM shopping_list_items sli"
                . "WHERE sli.shopping_list_id = $shoppingListId;";

        try {
            if ($this->connect->beginTransac()) {
                $rows = $this->connect->fetchAll($query, [ ":shoppingListId" => $shoppingListId ]);

                for ($i = 0; $i < count($rows); $i++) {
                    $sli = new ShoppingListItem();

                    $row = $rows[$i];
                    $id = $row["id"];
                    $sli->setId($id);
                    $sli->setName($row["name"]);
                    $sli->setIsChecked($row["is_checked"]);

                    $slis[$id] = $sli;
                }

                $this->connect->commitTransac();
            }
        } catch (\Exception $e) {
            $this->connect->rollBackTransac();
        }

        return $slis;
    }

    public function add(int $shoppingListId, ShoppingListItem $sli) : int
    {
        $query = "INSERT INTO shopping_list_items (shopping_list_id, name, is_checked)"
        . "VALUES (:shoppingListId, :name, :isChecked);";

        $lastId = 0;

        try {
            if ($this->connect->beginTransac()) {
                $result = $this->connect->execute(
                    $query
                    , [
                        ":shoppingListId" => $shoppingListId
                        , ":name" => $sli->getName()
                        , ":isChecked" => $sli->getIsChecked()
                    ]
                );

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

    public function editName(int $id, string $newName) : bool
    {
        $query = "UPDATE shopping_list_items SET name = :newName WHERE id = :id;";

        $result = false;

        try {
            if ($this->connect->beginTransac()) {
                $result = $this->connect->execute(
                    $query
                    , [
                        ":id" => $id
                        , ":newName" => $newName
                    ]
                );

                if ($result) {
                    $this->connect->commitTransac();
                    $result = true;
                }
            }
        } catch (\Exception $e) {
            $this->connect->rollBackTransac();
        }

        return $result;
    }

    public function editIsChecked(int $id, bool $newValue) : bool
    {
        $query = "UPDATE shopping_list_items SET is_checked = :isChecked WHERE id = :id;";

        $result = false;

        try {
            if ($this->connect->beginTransac()) {
                $result = $this->connect->execute(
                    $query
                    , [
                        ":id" => $id
                        , ":isChecked" => $newValue
                    ]
                );

                if ($result) {
                    $this->connect->commitTransac();
                    $result = true;
                }
            }
        } catch (\Exception $e) {
            $this->connect->rollBackTransac();
        }

        return $result;
    }

    public function delete($id) : bool
    {
        $query = "DELETE shopping_list_items WHERE id = :id;";

        $result = false;

        try {
            if ($this->connect->beginTransac()) {
                $result = $this->connect->execute(
                    $query
                    , [
                        ":id" => $id
                    ]
                );

                if ($result) {
                    $this->connect->commitTransac();
                    $result = true;
                }
            }
        } catch (\Exception $e) {
            $this->connect->rollBackTransac();
        }

        return $result;
    }
}
