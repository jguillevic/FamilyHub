<?php

namespace DTO\Family;

final class FamilyAssociateInfo
{
    private $code;
    private $userId;
    private $errors;

    function __construct() 
	{
        $this->setErrors([]);
    }

    public function getCode() : string
    {
        return $this->code;
    }
 
    public function setCode(string $code) : void
    {
        $this->code = $code;
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

    public static function createEmpty() : FamilyAssociateInfo
    {
        $fai = new FamilyAssociateInfo();

		$fai->setCode("");
        $fai->setUserId(0);
        $fai->setErrors([ "code" => [], "userId" => [], "technical" => [] ]);
        
        return $fai;
    }
}