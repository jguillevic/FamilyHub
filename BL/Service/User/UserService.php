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

    public function __construct()
	{
        $this->userDBA = new UserDBA();
    }

    /**
     * Tentative de connexion.
     *
     * @param array Infos réceptionnées.
     * @return UserLoginInfo Infos d'identification.
     */
    public function login(UserLoginInfo $userLoginInfo) : UserLoginInfo
    {
        $errors = $userLoginInfo->getErrors();

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
                } else {
                    $user = $this->userDBA->getUser($userLoginInfo->getUsername());
                    $userLoginInfo->setId($user->getId());
                }
            }
        }

        $userLoginInfo->SetErrors($errors);

        return $userLoginInfo;
    }

    public function add(UserAddInfo $userAddInfo) : UserAddInfo
    {
        $username = $userAddInfo->getUsername();
        $errors = $userAddInfo->getErrors();

        if (empty($username)) {
            $errors["username"][] = UserMessages::$usernameEmpty;
        } elseif (strlen($username) > self::USERNAME_MAX_LENGTH) {
            $errors["username"][] = sprintf(UserMessages::$usernameTooLong, self::USERNAME_MAX_LENGTH);
        } elseif ($this->userDBA->isUsernameExists($username)) {
            $errors["username"][] = UserMessages::$usernameAlreadyUsed;
        }

        $email = $userAddInfo->getEmail();
        if (empty($email)) {
            $errors["email"][] = UserMessages::$emailEmpty;
        } elseif (strlen($email) > self::EMAIL_MAX_LENGTH) {
            $errors["email"][] = sprintf(UserMessages::$emailTooLong, self::EMAIL_MAX_LENGTH);
        } elseif ($this->userDBA->isEmailExists($email)) {
            $errors["email"][] = UserMessages::$emailAlreadyUsed;
        }

        $password = $userAddInfo->getPassword();
        if (empty($password)) {
            $errors["password"][] = UserMessages::$passwordEmpty;
        } elseif (strlen($password) > self::PASSWORD_MAX_LENGTH) {
            $errors["password"][] = sprintf(UserMessages::$passwordTooLong, self::PASSWORD_MAX_LENGTH);
        }

        // S'il n'y a pas eu d'erreurs.
        if (count($errors["username"]) == 0
            && count($errors["email"]) == 0
            && count($errors["password"]) == 0) {
            $user = new User();
            $user->setUsername($username);
            $user->setEmail($email);
            $hash = password_hash($password, PASSWORD_DEFAULT);

            if (!$this->userDBA->addUser($user, $hash)) {
                $errors["technical"][] = UserMessages::$technicalErrorOnUserAdd;
            }
        }

        $userAddInfo->setErrors($errors);

        return $userAddInfo;
    }
}
