<?php

namespace BL\Service\User;

final class UserMessages {
    /**
     * @var string
    */
    public static $usernameEmpty = "La saisie de l'identifiant est obligatoire.";
    /**
     * @var string
     */
    public static $emailEmpty = "La saisie de l'adresse électronique est obligatoire.";
    /**
     * @var string
     */
    public static $passwordEmpty = "La saisie du mot de passe est obligatoire.";
    /**
     * @var string
     */
    public static $usernameIncorrect = "L'identifiant n'existe pas.";
    /**
     * @var string
     */
    public static $passwordIncorrect = "Le mot de passe est incorrect.";
    /**
     * @var string
     */
    public static $usernameAlreadyUsed = "L'identifiant est déjà utilisé. Veuillez en saisir un autre.";
    /**
     * @var string
     */
    public static $emailAlreadyUsed = "L'adresse électronique est déjà utilisée. Veuillez en saisir une autre.";
    /**
     * @var string
     */
    public static $usernameTooLong = "L'identifiant est trop long (%d caractères max).";
    /**
     * @var string
     */
    public static $emailTooLong = "L'adresse électronique est trop longue (%d caractères max).";
    /**
     * @var string
     */
    public static $passwordTooLong = "Le mot de passe est trop long (%d caractères max).";
        /**
     * @var string
     */
    public static $technicalErrorOnUserAdd = "Erreur technique lors de l'ajout de l'utilisateur.";
}