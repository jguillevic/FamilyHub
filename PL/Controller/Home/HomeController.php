<?php

namespace PL\Controller\Home;

use \Framework\View\View;
use \Framework\Tools\Helper\PathHelper;

final class HomeController
{
	public function display($queryParameters) : void {
		$path = PathHelper::GetPath([ "Home", "Display" ]);
		$view = new View($path);
		$view->Render();
		return;
	}
}