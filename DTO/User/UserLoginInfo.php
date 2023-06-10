<?php

namespace DTO\User;

final class UserLoginInfo
{
    /**
     * Identifiant.
     *
     * @var int
     */
    private $id;
    /**
     * Nom d'utilisateur.
     * 
     * @var string
     */
    private $username;
    /**
     * Mot de passe.
     * 
     * @var string
     */
    private $password;
    /**
     * Tableaux des erreurs rencontrées au cours du processus d'authentification.
     * 
     * @var array
     */
    private $errors;

    /**
     * Get identifiant.
     *
     * @return int
     */ 
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * Set identifiant.
     *
     * @param string $id identifiant.
     */ 
    public function setid(string $id) : void
    {
        $this->id = $id;
    }

    /**
     * Get nom d'utilisateur.
     *
     * @return string
     */ 
    public function getUsername() : string
    {
        return $this->username;
    }

    /**
     * Set nom d'utilisateur.
     *
     * @param string  $username nom d'utilsateur.
     */ 
    public function setUsername(string $username) : void
    {
        $this->username = $username;
    }

    /**
     * Get mot de passe de l'utilisateur.
     *
     * @return string
     */ 
    public function getPassword() : string
    {
        return $this->password;
    }

    /**
     * Set mot de passe de l'utilisateur.
     *
     * @param string  $password  Mot de passe de l'utilisateur.
     */ 
    public function setPassword(string $password)  : void
    {
        $this->password = $password;
    }

    /**
     * Get tableaux des erreurs rencontrées au cours du processus d'authentification.
     *
     * @return array
     */ 
    public function getErrors() : array
    {
        return $this->errors;
    }

    /**
     * Set tableaux des erreurs rencontrées au cours du processus d'authentification.
     *
     * @param array  $errors  Tableaux des erreurs rencontrées au cours du processus d'authentification.
     */ 
    public function setErrors(array $errors) : void
    {
        $this->errors = $errors;
    }
}
