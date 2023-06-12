<?php

namespace PL\Controller\ShoppingList;

use \Framework\View\View;
use \Framework\Tools\Helper\RoutesHelper;
use \Framework\Tools\Helper\PathHelper;
use \PL\Controller\User\UserSession;

final class ShoppingListController
{
    public function display(array $queryParameters) : void
    {
        if (!UserSession::isLogin()) {
			RoutesHelper::redirect("DisplayHome");
		}

        $path = PathHelper::GetPath([ "ShoppingList", "DIsplay" ]);
		$view = new View($path);
		$view->Render();
    }

    public function addItem(array $queryParameters) : void
    {

    }

    public function deleteItem(array $queryParameters) : void
    {

    }

    public function editItem(array $queryParameters) : void
    {

    }

    public function checkItem(array $queryParameters) : void
    {

    }
}
