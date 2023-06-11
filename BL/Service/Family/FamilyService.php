<?php

namespace BL\Service\Family;

use \Model\Family\Family;
use \DAL\DBA\Family\FamilyDBA;
use \DTO\Family\FamilyAssociateInfo;
use \DTO\Family\FamilyAddInfo;

final class FamilyService
{
    private $familyDBA;

    function __construct() 
	{
        $this->familyDBA = new FamilyDBA();
    }

    public function hasFamily(int $userId) : bool
    {
        return $this->familyDBA->hasFamily($userId);
    }

    public function getFamilyFromUserId(int $userId) : Family
    {
        return $this->familyDBA->getFamilyFromUserId($userId);
    }

    public function addAndAssociate(FamilyAddInfo $fai) : FamilyAddInfo
    {   
        // TODO : Gérer les erreurs.
        // Gérer les transaction.
        $familyId = intval($this->familyDBA->add($fai->getName()));

        if ($familyId > 0) {
            $fai->setId($familyId);
            $family = $this->familyDBA->get($familyId);
            $famAssInfo = FamilyAssociateInfo::createEmpty();
            $famAssInfo->setCode($family->getCode());
            $famAssInfo = $this->associate($famAssInfo);
        }

        return $fai;
    }

    public function associate(FamilyAssociateInfo $fai) : FamilyAssociateInfo
    {
        // TODO : Gérer les erreurs.
        // Gérer les transaction.
        $isCodeExists = $this->familyDBA->isCodeExists($fai->getCode());

        if ($isCodeExists === true) {
            $result = $this->familyDBA->associate($fai->getCode(), $fai->getUserId());
        }

        return $fai;
    }
}