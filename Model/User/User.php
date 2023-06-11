<?php

namespace Model\User;

final class User
{
	private $id;
	private $username;
	private $email;

	public function getId() : int
    {
        return $this->id;
    }

    public function setId(int $id) : void
    {
        $this->id = $id;
    }

	public function getUsername() : string
	{
		return $this->username;
	}

	public function setUsername(string $value) : void
	{
		$this->username = $value;
	}

	public function getEmail() : string
	{
		return $this->email;
	}

	public function setEmail(string $value) : void
	{
		$this->email = $value;
	}
}
