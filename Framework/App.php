<?php

namespace Framework;

use \Framework\Tools\Autoloader;
use \Framework\Controller\FrontController;

final class App
{
	public function run()
	{
		$vendorPath = join(DIRECTORY_SEPARATOR, array(__DIR__, '..', 'vendor', 'autoload.php'));
		if (file_exists($vendorPath))
		{
			require_once $vendorPath;
		}

		$path = join(DIRECTORY_SEPARATOR, array(__DIR__, 'Tools', 'Autoloader.php'));
		require_once $path;

		$autoloader = new Autoloader();
		$autoloader->Run();

		$frontController = new FrontController();
		return $frontController->Run();
	}
}