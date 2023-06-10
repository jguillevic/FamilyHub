<?php

namespace PL\Controller\User;

use PL\Controller\User\UserInfo;

final class UserSession {
    public function isLogin() : bool 
    {
        return array_key_exists("user_id", $_SESSION);
    }

    public function login(int $id, string $username) : void 
    {
        $_SESSION["user_id"] = $id;
        $_SESSION["user_username"] = $username;
    }

    public function logout() : bool 
    {
        return session_destroy();
    }

    public function getUser() : UserInfo 
    {
        $user = new UserInfo();
        $user->setId($_SESSION["user_id"]);
        $user->setUsername($_SESSION["user_username"]);
        return $user;
    }
}