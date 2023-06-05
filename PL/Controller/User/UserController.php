<?php

namespace PL\Controller\User;

use \Framework\View\View;
use \Framework\Tools\Helper\RoutesHelper;
use \Framework\Tools\Helper\PathHelper;

final class UserController
{
    public function DisplayLoginForm($queryParameters) : void
    {
		if ($_SERVER['REQUEST_METHOD'] !== 'GET')
		{
			RoutesHelper::Redirect("DisplayHome");
		}

        $path = PathHelper::GetPath([ "User", "DisplayLoginForm" ]);
		$view = new View($path);
		$view->Render();
		
		return;
    }

	public function Login($queryParameters) : string
	{
		return "En train de te logguer coco !";
	}

    public function Logout($queryParameters) : string
	{
		return "Bye bye !";
	}
}