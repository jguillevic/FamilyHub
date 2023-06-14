<?php

namespace DTO\ShoppingList;

final class ShoppingListAddInfo
{
    private $familyId;
    private $id;

    public function getFamilyId() : int
    {
        return $this->familyId;
    }

    public function setFamilyId(int $familyId) : void
    {
        $this->familyId = $familyId;
    }

    public function getid() : int
    {
        return $this->id;
    }

    public function setId(int $id) : void
    {
        $this->id = $id;
    }
}