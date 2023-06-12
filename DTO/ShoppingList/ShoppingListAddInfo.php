<?php

namespace DTO\ShoppingList;

final class ShoppingListAddInfo
{
    private $familyId;

    public function getFamilyId() : int
    {
        return $this->familyId;
    }

    public function setFamilyId(int $familyId) : void
    {
        $this->familyId = $familyId;
    }
}