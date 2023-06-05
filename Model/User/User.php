<?php

namespace Model\User;

class User
{
	private $id;
	private $username;
	private $password;

	public function GetId()
    {
        return $this->id;
    }

    public function SetId($id)
    {
        $this->id = $id;
    }

	public function GetUsername()
	{
		return $this->username;
	}

	public function SetUsername($value)
	{
		$this->username = $value;

		return $this;
	}

	public function GetPassword()
	{
		return $this->password;
	}

	public function SetPassword($value)
	{
		$this->password = $value;

		return $this;
	}
}