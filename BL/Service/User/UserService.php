<?php

namespace BL\Service\User;

use \DTO\User\UserLoginInfo;
use \DTO\User\UserAddInfo;
use \Model\User\User;
use \DAL\DBA\User\UserDBA;

final class UserService
{
    const USERNAME_MAX_LENGTH = 100;
    const EMAIL_MAX_LENGTH = 100;
    const PASSWORD_MAX_LENGTH = 100;

    private $userDBA;

    function __construct() 
	{
        $this->userDBA = new UserDBA();
    }

    /**
     * Tentative de connexion.
     * 
     * @param array Infos réceptionnées.
     * @return UserLoginInfo Infos d'identification.
     */
    public function login(UserLoginInfo $userLoginInfo) : UserLoginInfo {
        $errors = [ "username" => [], "password" => [] ];

        if (empty($userLoginInfo->getUsername())) {
            $errors["username"][] = UserMessages::$usernameEmpty;
        }
        if (empty($userLoginInfo->getPassword())) {
            $errors["password"][] = UserMessages::$passwordEmpty;
        }

        if (count($errors["username"]) == 0 && count($errors["password"]) == 0) {
            $isUsernameExists = $this->userDBA->isUsernameExists($userLoginInfo->getUsername());
            if (!$isUsernameExists) {
                $errors["username"][] = UserMessages::$usernameIncorrect;
            // Dans le cas où l'identifiant existe.
            } else {
                $hash = $this->userDBA->getHash($userLoginInfo->getUsername());
                if (!password_verify($userLoginInfo->getPassword(), $hash)) {
                    $errors["password"][] = UserMessages::$passwordIncorrect;
                }
            }
        }

        $userLoginInfo->SetErrors($errors);

        return $userLoginInfo;
    }

    public function add(UserAddInfo $userAddInfo) : UserAddInfo
    {
        $username = $userAddInfo->getUsername();
        $email = $userAddInfo->getEmail();
        $password = $userAddInfo->getPassword();
        $errors = $userAddInfo->getErrors();

        if (empty($username)) {
            $errors["username"][] = UserMessages::$usernameEmpty;
        } else if (strlen($username) > self::USERNAME_MAX_LENGTH) {
            $errors["username"][] = sprintf(UserMessages::$usernameTooLong, self::USERNAME_MAX_LENGTH);
        } else if ($this->userDBA->isUsernameExists($username)) {
            $errors["username"][] = UserMessages::$usernameAlreadyUsed;
        }

        $email = $userAddInfo->getEmail();
        if (empty($email)) {
            $errors["email"][] = UserMessages::$emailEmpty;
        } else if (strlen($email) > self::EMAIL_MAX_LENGTH) {
            $errors["email"][] = sprintf(UserMessages::$emailTooLong, self::EMAIL_MAX_LENGTH);
        } else if ($this->userDBA->IsEmailExists($email)) {
            $errors["email"][] = UserMessages::$emailAlreadyUsed;
        }

        $password = $userAddInfo->getPassword();
        if (empty($password)) {
            $errors["password"][] = UserMessages::$passwordEmpty;
        } else if (strlen($password) > self::PASSWORD_MAX_LENGTH) {
            $errors["password"][] = sprintf(UserMessages::$passwordTooLong, self::PASSWORD_MAX_LENGTH);
        }

        // S'il n'y a pas eu d'erreurs.
        if (count($errors["username"]) == 0 
            && count($errors["email"]) == 0 
            && count($errors["password"]) == 0) {

            $user = new User();
            $user->setUsername($username);
            $user->SetEmail($email);
            $hash = password_hash($password, PASSWORD_DEFAULT);

            if (!$this->userDBA->AddUser($user, $hash)) {
                $errors["technical"][] = UserMessages::$technicalErrorOnUserAdd;
            }
        }

        return $userAddInfo;
    }
}
