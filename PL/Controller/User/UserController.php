<?php

namespace PL\Controller\User;

use \Framework\View\View;
use \Framework\Tools\Helper\RoutesHelper;
use \Framework\Tools\Helper\PathHelper;
use \PL\Controller\User\UserSession;
use \BL\Service\User\UserService;
use \DTO\User\UserLoginInfo;
use \DTO\User\UserAddInfo;

final class UserController
{
    private $userSession;
	private $userService;

    function __construct() 
	{
        $this->userSession = new UserSession();
		$this->userService = new UserService();
    }
	
    /**
     * Récupère la variable "login" dans $data.
     * Si la variable n'existe pas, "" est retourné.
     * 
     * @param array Infos réceptionnées.
     * @return string Identifiant de l'utilisateur.
     */
    public static function getUsername(array $data) : string {
        if (!array_key_exists("username", $data)) {
            return "";
        } else {
            return $data["username"];
        }
    }

    /**
     * Récupère la variable "email" dans $data.
     * Si la variable n'existe pas, "" est retourné.
     * 
     * @param array Infos réceptionnées.
     * @return string Adresse électronique de l'utilisateur.
     */
    public static function GetEmail(array $data) : string {
        if (!array_key_exists("email", $data)) {
            return "";
        } else {
            return $data["email"];
        }
    }

    /**
     * Récupère la variable "password" dans $data.
     * Si la variable n'existe pas, "" est retourné.
     * 
     * @param array Infos réceptionnées.
     * @return string Mot de passe de l'utilisateur.
     */
    public static function getPassword(array $data) : string {
        if (!array_key_exists("password", $data)) {
            return "";
        } else {
            return $data["password"];
        }
    }

	public function login($queryParameters) : void
    {
		if ($this->userSession->isLogin()) {
			RoutesHelper::redirect("DisplayHome");
		}

		if ($_SERVER['REQUEST_METHOD'] === 'GET') {
			$userLoginInfo = new UserLoginInfo();
			$userLoginInfo->setUsername("");
        	$userLoginInfo->setPassword("");
        	$userLoginInfo->setErrors([ "login" => [], "password" => [] ]);
		} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$userLoginInfo = new UserLoginInfo();
			
			$userLoginInfo->setUsername(self::getusername($queryParameters));
			$userLoginInfo->setPassword(self::getPassword($queryParameters));
			
			$userLoginInfo = $this->userService->login($userLoginInfo);

			if (count($userLoginInfo->getErrors()["username"]) == 0 
			&& count($userLoginInfo->getErrors()["password"]) == 0) {
				$this->userSession->login($userLoginInfo->getId(), $userLoginInfo->getUsername());
				RoutesHelper::redirect("DisplayHome");
				return;
			}
		} else {
			RoutesHelper::redirect("DisplayHome");
			return;
		}

		$path = PathHelper::getPath([ "User", "Login" ]);
		$view = new View($path);
		$view->render([ 
            "login" => $userLoginInfo->getUsername()
            , "password" => $userLoginInfo->getPassword()
            , "errors" => $userLoginInfo->getErrors()
            ]);
    }

    public function logout($queryParameters) : void
	{
		if (!$this->userSession->IsLogin()) {
			RoutesHelper::redirect("DisplayHome");
			return;
		}

		$this->userSession->logout();

		RoutesHelper::redirect("DisplayHome");
		return;
	}

	public function add($queryParameters) : void 
	{
        if ($this->userSession->IsLogin()) {
            RoutesHelper::redirect("DisplayHome");
			return;
		}

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
			$userAddInfo = new UserAddInfo();
			$userAddInfo->setUsername("");
			$userAddInfo->setEmail("");
        	$userAddInfo->setPassword("");
        	$userAddInfo->setErrors([ "username" => [], "email" => [], "password" => [], "technical" => [] ]);
        } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userAddInfo = new UserAddInfo();
			$userAddInfo->setUsername(self::getUsername($queryParameters));
			$userAddInfo->setEmail(self::getEmail($queryParameters));
        	$userAddInfo->setPassword(self::getPassword($queryParameters));

            $userAddInfo = $this->userService->add($userAddInfo);

			if (count($userAddInfo->getErrors()["username"]) == 0
			&&  count($userAddInfo->getErrors()["email"]) == 0
			&& count($userAddInfo->getErrors()["password"]) == 0
			&& count($userAddInfo->getErrors()["technical"]) == 0) {
				RoutesHelper::redirect("DisplayLogin");
				return;
			}
        } else {
            RoutesHelper::redirect("DisplayHome");
			return;
        }

		$path = PathHelper::getPath([ "User", "Add" ]);
		$view = new View($path);
		$view->render([ 
			"username" => $userAddInfo->getUsername()
        	, "email" => $userAddInfo->getEmail()
        	, "password" => $userAddInfo->getPassword()
        	, "errors" => $userAddInfo->getErrors()
			]);
    }
}
