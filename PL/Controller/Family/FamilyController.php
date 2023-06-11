<?php

namespace PL\Controller\Family;

use \Framework\View\View;
use \Framework\Tools\Helper\RoutesHelper;
use \Framework\Tools\Helper\PathHelper;
use \PL\Controller\User\UserSession;

final class FamilyController
{
    public function display(array $queryParameters) : void 
    {
        $userInfo = UserSession::getUser();

        $path = PathHelper::GetPath([ "Family", "Display" ]);
		$view = new View($path);
		$view->Render();
		return;
    }
}