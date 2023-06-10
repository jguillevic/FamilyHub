<?php

namespace PL\Controller\User;

final class UserInfo
{
	private $id;
	private $username;

	public function getId() : string
    {
        return $this->id;
    }

    public function setId($id) : void
    {
        $this->id = $id;
    }

	public function getUsername() : string
	{
		return $this->username;
	}

	public function setUsername($value) : void
	{
		$this->username = $value;
	}
}