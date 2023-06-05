<?php

namespace Framework\Tools\Helper;

class PathHelper
{
	public static function GetPath($params) : string
	{
		return join(DIRECTORY_SEPARATOR, $params);
	}

	public static function GetRelativePathToRootFromCurrentFolder() : string
	{
		$currentPath = explode(DIRECTORY_SEPARATOR, str_replace('/', DIRECTORY_SEPARATOR, $_SERVER['DOCUMENT_ROOT']));
		$rootPath = explode(DIRECTORY_SEPARATOR, str_replace('/',DIRECTORY_SEPARATOR, dirname($_SERVER["SCRIPT_FILENAME"])));
		$relPath = array();
		$dotted = 0;

		for ($i = 0; $i < count($rootPath); $i++) 
		{
			if ($i >= count($currentPath)) 
			{
				$dotted++;
			}
			elseif ($currentPath[$i] != $rootPath[$i]) 
			{
				$relPath[] = $currentPath[$i]; 
				$dotted++;
			}
		}

		return str_repeat('../', $dotted) . implode('/', array_merge($relPath, array_slice($currentPath, count($rootPath))));
	}
	
	public static function GetAssetsFolderPath() : string
	{
		return PathHelper::GetPath([ PathHelper::GetRelativePathToRootFromCurrentFolder(), 'Assets' ]);
	}

	public static function GetCssFolderPath() : string
	{
		return PathHelper::GetPath([ PathHelper::GetAssetsFolderPath(), 'css' ]);
	}

	public static function GetCssStyleFilePath() : string
	{
		return PathHelper::GetPath([ PathHelper::GetCssFolderPath(), 'style.css' ]);
	}

	public static function GetJsFolderPath() : string
	{
		return PathHelper::GetPath([ PathHelper::GetAssetsFolderPath(), 'js' ]);
	}

	public static function GetJsFilePath($relativeFilePath) : string
	{
		return PathHelper::GetPath([ PathHelper::GetJsFolderPath(), $relativeFilePath ]);
	}

	public static function GetJsModuleFolderPath() : string
	{
		return PathHelper::GetPath([ PathHelper::GetJsFolderPath(), 'module' ]);
	}

	public static function GetJsModuleFilePath($relativeFilePath) : string
	{
		return PathHelper::GetPath([ PathHelper::GetJsModuleFolderPath(), $relativeFilePath ]);
	}
}