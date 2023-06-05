<?php

namespace BL\Service\User;

final class UserDTOModelConverter
{
    /**
     * Convertit un \DTO\User\User en \Model\User\User.
     *
     * @param \DTO\User\User $userDTO
     * @return \Model\User\User
     */
    public static function ConvertToModel($userDTO) : \Model\User\User
    {
        $user = new \Model\User\User();

        $user->setId($userDTO->getId());
        $user->SetUsername($userDTO->getUsername());
        $user->SetPassword($userDTO->getPassword());

        return $user;
    }

    /**
     * Convertit un \Model\User\User en \DTO\User\User.
     *
     * @param \Model\User\User $userModel
     * @return \DTO\User\User
     */
    public static function ConvertToDTO($userModel) : \DTO\User\User
    {
        $user = new \DTO\User\User();

        $user->setId($userModel->getId());
        $user->SetUsername($userModel->getUsername());
        $user->SetPassword($userModel->getPassword());

        return $user;
    }
}