<?php

namespace PL\Controller\User;

use PL\Controller\User\UserInfo;

final class UserSession
{
    const USER_ID = "user_id";
    const USER_USERNAME = "user_username";

    public static function isLogin() : bool
    {
        return array_key_exists(self::USER_ID, $_SESSION);
    }

    public static function login(int $id, string $username) : void
    {
        $_SESSION[self::USER_ID] = $id;
        $_SESSION[self::USER_USERNAME] = $username;
    }

    public static function logout() : bool
    {
        return session_destroy();
    }

    public static function getUser() : UserInfo
    {
        $userInfo = new UserInfo();
        $userInfo->setId($_SESSION[self::USER_ID]);
        $userInfo->setUsername($_SESSION[self::USER_USERNAME]);
        return $userInfo;
    }
}
