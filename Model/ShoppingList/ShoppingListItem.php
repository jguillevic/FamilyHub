<?php

namespace Model\ShoppingList;

final class ShoppingListItem
{
    private $id;
    private $name;
    private $isChecked;

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
