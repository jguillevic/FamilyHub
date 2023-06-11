<?php

namespace Model\Family;

final class Family
{
    private $id;
	private $code;
	private $name;

	public function getId() : int
    {
        return $this->id;
    }

    public function setId(int $id) : void
    {
        $this->id = $id;
    }

	public function getCode() : string
	{
		return $this->code;
	}

	public function setCode(string $value) : void
	{
		$this->code = $value;
	}

	public function getName() : string
	{
		return $this->name;
	}

	public function setName(string $value) : void
	{
		$this->name = $value;
	}
}
