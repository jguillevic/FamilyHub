<?php

namespace DTO\ShoppingList;

final class ShoppingListItemAddInfo
{
    private $shoppingListId;
    private $name;

    public function getShoppingListId() : int
    {
        return $this->shoppingListId;
    }

    public function setShoppingListId(int $shoppingListId) : void
    {
        $this->shoppingListId = $shoppingListId;
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function setName(string $name) : void
    {
        $this->name = $name;
    }
}
