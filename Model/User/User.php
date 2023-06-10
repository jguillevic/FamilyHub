<?php

namespace Model\User;

final class User
{
	private $id;
	private $username;
	private $email;

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

	public function getEmail() : string
	{
		return $this->email;
	}

	public function setEmail($value) : void
	{
		$this->email = $value;
	}
}
