<?php

namespace BL\Service\ShoppingList;

use \Model\ShoppingList\ShoppingList;
use \Model\ShoppingList\ShoppingListItem;
use \DTo\ShoppingList\ShoppingListAddInfo;
use \DTo\ShoppingList\ShoppingListItemAddInfo;

final class ShoppingListService
{
    public function add(ShoppingListAddInfo $shoppingList) : bool
    {
        return true;
    }

    public function addItem(ShoppingListItemAddInfo $shoppingListItem) : bool
    {
        return true;
    }
}
