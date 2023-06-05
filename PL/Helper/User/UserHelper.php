<?php

namespace PL\Helper\User;

/**
 * @author JGuillevic
 */
final class UserHelper
{
	const USER_KEY = "user";

	public static function IsLogin()
	{
		return isset($_SESSION[self::USER_KEY]);
	}

	private static function GetUser()
	{
		$user = null;

		if (self::IsLogin())
		{
			$user = $_SESSION[self::USER_KEY];
		}

		return $user;
	}

	/**
	 * Ajoute l'utilisateur dans la variable de session.
	 *
	 * @param \DTO\User\User $user
	 * @return void
	 */
	public static function Login($user) : void
	{
		$_SESSION[self::USER_KEY] = $user;
	}

	/**
	 * Retire l'utilisateur de la variable de session.
	 *
	 * @return void
	 */
	public static function Logout()
	{
		if (self::IsLogin())
		{
			unset($_SESSION[self::USER_KEY]);

			return true;
		}
		
		return false;
	}
}