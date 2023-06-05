<?php

namespace PL\Controller\Contact;

use \Framework\View\View;
use \Framework\Tools\Helper\PathHelper;

final class ContactController
{
	public function Display($queryParameters) : void
	{
		$path = PathHelper::GetPath([ "Contact", "Display" ]);
		$view = new View($path);
		$view->Render();
		return;
	}

    public function Send($queryParameters) : bool
    {
        return true;
    }
}