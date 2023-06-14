<?php

namespace BL\Service\ShoppingList;

use \Model\ShoppingList\ShoppingList;
use \Model\ShoppingList\ShoppingListItem;
use \DTO\ShoppingList\ShoppingListAddInfo;
use \DTO\ShoppingList\ShoppingListItemAddInfo;
use \DAL\DBA\ShoppingList\ShoppingListDBA;
use \DAL\DBA\ShoppingList\ShoppingListItemDBA;

final class ShoppingListService
{
    public function add(ShoppingListAddInfo $shoppingListAddInfo) : ShoppingListAddInfo
    {
        $slDBA = new ShoppingListDBA();

        $slId = $slDBA->add($shoppingListAddInfo->getFamilyId());

        $shoppingListAddInfo->setId($slId);

        return $shoppingListAddInfo;
    }

    public function addItem(ShoppingListItemAddInfo $shoppingListItemAddInfo) : ShoppingListItemAddInfo
    {
        $sliDBA = new ShoppingListItemDBA();

        $shoppingListId = $shoppingListItemAddInfo->getShoppingListId();      
        $sli = new ShoppingListItem();
        $sli->setName($shoppingListItemAddInfo->getName());
        $sli->setIsChecked($shoppingListItemAddInfo->getIsChecked());

        $sliId = $sliDBA->add($shoppingListId, $sli);
        
        $shoppingListItemAddInfo->setId($sliId);

        return $shoppingListItemAddInfo;
    }
}
