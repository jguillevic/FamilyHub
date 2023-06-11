<?php

namespace PL\Controller\Family;

use \Framework\View\View;
use \Framework\Tools\Helper\RoutesHelper;
use \Framework\Tools\Helper\PathHelper;
use \PL\Controller\User\UserSession;
use \BL\Service\Family\FamilyService;
use \DTO\Family\FamilyAssociateInfo;
use \DTO\Family\FamilyAddInfo;

final class FamilyController
{
    private $familyService;

    function __construct() 
	{
		$this->familyService = new FamilyService();
    }

    public function display(array $queryParameters) : void 
    {
        if (!UserSession::isLogin()) {
			RoutesHelper::redirect("DisplayHome");
		}

        $userInfo = UserSession::getUser();
        if ($this->familyService->hasFamily($userInfo->getId()) === true) {
            $family = $this->familyService->getFamilyFromUserId($userInfo->getId());

            $path = PathHelper::GetPath([ "Family", "Display" ]);
		    $view = new View($path);
		    $view->Render([ 
                "code" => $family->getCode()
                , "name" => $family->getName() 
            ]);
		    return;
        } else {
            $path = PathHelper::GetPath([ "Family", "DisplayNoFamily" ]);
		    $view = new View($path);
		    $view->Render();
            return;
        }
    }

    public function add(array $queryParameters) : void
    {
        if (!UserSession::isLogin()) {
			RoutesHelper::redirect("DisplayHome");
            return;
		}
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $fai = FamilyAddInfo::createEmpty();
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $fai = FamilyAddInfo::createEmpty();
            $fai->setName($queryParameters["name"]->getValue());
            $userInfo = UserSession::getUser();
            $fai->setUserId($userInfo->getId());

            $fai = $this->familyService->addAndAssociate($fai);

            if (count($fai->getErrors()["name"]) == 0
			&& count($fai->getErrors()["name"]) == 0) {
                RoutesHelper::redirect("DisplayFamily");
                return;
            }
        }

        $path = PathHelper::getPath([ "Family", "Add" ]);
		$view = new View($path);
		$view->render([ 
			"name" => $fai->getName()
        	, "errors" => $fai->getErrors()
			]);
    }

    public function associate(array $queryParameters) : void
    {
        if (!UserSession::isLogin()) {
			RoutesHelper::redirect("DisplayHome");
		}

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $fai = FamilyAssociateInfo::createEmpty();
            $fai->setCode($queryParameters["code"]->getValue());
            $userInfo = UserSession::getUser();
            $fai->setUserId($userInfo->getId());

            $fai = $this->familyService->associate($fai);

            RoutesHelper::redirect("DisplayFamily");
            return;
        }

        RoutesHelper::redirect("DisplayHome");
        return;
    }
}
