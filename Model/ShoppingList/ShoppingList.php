<?php

namespace Model\ShoppingList;

final class ShoppingList
{
    private $id;
    private $items;

    public function getId() : int
    {
        return $this->id;
    }

    public function setId(int $id) : void
    {
        $this->id = $id;
    }

    public function getItems() : array
    {
        return $this->items;
    }

    public function setItems(array $items) : void
    {
        $this->items = $items;
    }
}
