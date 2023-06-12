<?php

namespace PL\Controller\Contact;

use \Framework\View\View;
use \Framework\Tools\Helper\PathHelper;

final class ContactController
{
	public function display($queryParameters) : void
	{
		$path = PathHelper::GetPath([ "Contact", "Display" ]);
		$view = new View($path);
		$view->Render();
	}

    public function send($queryParameters) : bool
    {
        return true;
    }
}