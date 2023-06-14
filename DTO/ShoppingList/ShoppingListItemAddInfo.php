<?php

namespace DTO\ShoppingList;

final class ShoppingListItemAddInfo
{
    private $shoppingListId;
    private $id;
    private $name;
    private $isChecked;

    public function getShoppingListId() : int
    {
        return $this->shoppingListId;
    }

    public function setShoppingListId(int $shoppingListId) : void
    {
        $this->shoppingListId = $shoppingListId;
    }

    public function getId() : int
    {
        return $this->id;
    }

    public function setId(int $id) : void
    {
        $this->id = $id;
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function setName(string $name) : void
    {
        $this->name = $name;
    }

    public function getIsChecked() : bool
    {
        return $this->isChecked;
    }

    public function setIsChecked(bool $isChecked) : void
    {
        $this->isChecked = $isChecked;
    }
}
