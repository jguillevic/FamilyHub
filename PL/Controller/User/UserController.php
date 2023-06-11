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
	private $userService;

    function __construct() 
	{
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
            return $data["username"]->getValue();
        }
    }

    /**
     * Récupère la variable "email" dans $data.
     * Si la variable n'existe pas, "" est retourné.
     * 
     * @param array Infos réceptionnées.
     * @return string Adresse électronique de l'utilisateur.
     */
    public static function getEmail(array $data) : string {
        if (!array_key_exists("email", $data)) {
            return "";
        } else {
            return $data["email"]->getValue();
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
            return $data["password"]->getValue();
        }
    }

	public function login(array $queryParameters) : void
    {
		if (UserSession::isLogin()) {
			RoutesHelper::redirect("DisplayHome");
		}

		if ($_SERVER['REQUEST_METHOD'] === 'GET') {
			$userLoginInfo = UserLoginInfo::createEmpty();
		} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$userLoginInfo = UserLoginInfo::createEmpty();
			
			$userLoginInfo->setUsername(self::getusername($queryParameters));
			$userLoginInfo->setPassword(self::getPassword($queryParameters));
			
			$userLoginInfo = $this->userService->login($userLoginInfo);

			if (count($userLoginInfo->getErrors()["username"]) == 0 
			&& count($userLoginInfo->getErrors()["password"]) == 0) {
				UserSession::login($userLoginInfo->getId(), $userLoginInfo->getUsername());
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

    public function logout(array $queryParameters) : void
	{
		if (!UserSession::isLogin()) {
			RoutesHelper::redirect("DisplayHome");
			return;
		}

		UserSession::logout();

		RoutesHelper::redirect("DisplayHome");
		return;
	}

	public function add(array $queryParameters) : void 
	{
        if (UserSession::isLogin()) {
            RoutesHelper::redirect("DisplayHome");
			return;
		}

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
			$userAddInfo = UserAddInfo::createEmpty();
        } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userAddInfo = UserAddInfo::createEmpty();

			$userAddInfo->setUsername(self::getUsername($queryParameters));
			$userAddInfo->setEmail(self::getEmail($queryParameters));
        	$userAddInfo->setPassword(self::getPassword($queryParameters));

            $userAddInfo = $this->userService->add($userAddInfo);

			if (count($userAddInfo->getErrors()["username"]) == 0
			&&  count($userAddInfo->getErrors()["email"]) == 0
			&& count($userAddInfo->getErrors()["password"]) == 0
			&& count($userAddInfo->getErrors()["technical"]) == 0) {
				RoutesHelper::redirect("LoginUser");
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
