<?php

namespace DTO\Family;

final class FamilyAddInfo
{
    private $id;
    private $name;
    private $userId;
    private $errors;

    function __construct() 
	{
        $this->setErrors([]);
    }

    public function getId() : int
    {
        return $this->id;
    }

    public function setId(int $id) : void
    {
        $this->id = $id;
    }

    public function getName() : string
    {
        return $this->name;
    }
 
    public function setName(string $name) : void
    {
        $this->name = $name;
    }

    public function getUserId() : int
    {
        return $this->userId;
    }
 
    public function setUserId(string $userId) : void
    {
        $this->userId = $userId;
    }

    public function getErrors() : array
    {
        return $this->errors;
    }

    public function setErrors(array $errors) : void
    {
        $this->errors = $errors;
    }

    public static function createEmpty() : FamilyAddInfo
    {
        $fai = new FamilyAddInfo();

        $fai->setId(0);
		$fai->setName("");
        $fai->setUserId(0);
        $fai->setErrors([ "name" => [], "userId" => [], "technical" => [] ]);
        
        return $fai;
    }
}