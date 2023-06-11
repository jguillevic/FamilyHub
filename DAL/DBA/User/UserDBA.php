<?php

namespace DAL\DBA\User;

use \Model\User\User;
use \Framework\Database\DbConnection;

final class UserDBA
{
    /**
     * @var DbConnection
     */
    private $connect;

    public function __construct(DbConnection $connect = null) 
    {
        if ($connect == null) {
            $this->connect = new DbConnection();
        } else {
            $this->connect = $connect;
        }
    }

    public function isUsernameExists(string $username) : bool 
    {
        $query = "SELECT COUNT(1) AS count FROM users WHERE username = :username;";

        $result = true;

        try {
            if ($this->connect->BeginTransac()) {
                $count = $this->connect->FetchAll(
                    $query
                    , [ ":username" => $username ]
                )[0]["count"];

                if ($count > 0) {
                    $result = true;
                } else {
                    $result = false;
                }

                $this->connect->CommitTransac();
            }
        } catch (\Exception $e) {
            $this->connect->RollBackTransac();
        }

        return $result;
    }

    /**
     * Est-ce que l'adresse électronique est déjà utilisée.
     * 
     * @param string $email Adresse électronique dont l'existance est à vérifier
     * @return bool true si elle existe false sinon
     */
    public function isEmailExists(string $email) : bool 
    {
        $query = "SELECT COUNT(1) AS count FROM users WHERE email = :email;";

        $result = true;

        try {
            if ($this->connect->BeginTransac()) {
                $count = $this->connect->FetchAll(
                    $query
                    , [ ":email" => $email ]
                )[0]["count"];

                if ($count > 0) {
                    $result = true;
                } else {
                    $result = false;
                }

                $this->connect->CommitTransac();
            }
        } catch (\Exception $e) {
            $this->connect->RollBackTransac();
        }

        return $result;
    }

    public function getHash(string $username) : string 
    {
        $query = "SELECT hash FROM users WHERE username = :username;";

        $hash = "";

        try {
            if ($this->connect->BeginTransac()) {
                $hash = $this->connect->FetchAll($query, [ ":username" => $username ])[0]["hash"];

                $this->connect->CommitTransac();
            }
        } catch (\Exception $e) {
            $this->connect->RollBackTransac();
        }

        return $hash;
    }

    /**
     * Retourne l'utilisateur associé au mot de passe en paramètre.
     * 
     * @param string $username Identifiant de l'utilisateur
     * @return User Utilisateur associé
     */
    public function getUser(string $username) : User 
    {
        $query = "SELECT id, username, email FROM users WHERE username = :username;";

        $user = new User();

        try {
            if ($this->connect->BeginTransac()) {
                $result = $this->connect->FetchAll($query, [ ":username" => $username ]);

                $this->connect->CommitTransac();

                if (count($result) > 0) {
                    $user->SetId($result[0]["id"]);
                    $user->SetUsername($result[0]["username"]);
                    $user->SetUsername($result[0]["email"]);
                }
            }
        } catch (\Exception $e) {
            $this->connect->RollBackTransac();
        }

        return $user;
    }

    /**
     * Ajoute l'utilisateur.
     * 
     * @param User $user Informations sur l'utilisateur sauf le mot de passe
     * @param string $hash Mot de passe hashé
     * @return bool true si l'ajout est un succès, false sinon
     */
    public function addUser(User $user, string $hash) : bool 
    {
        $query = "INSERT INTO users (username, email, hash) VALUES (:username, :email, :hash);";

        $result = false;

        try {
            if ($this->connect->BeginTransac()) {
                $result = $this->connect->Execute(
                    $query
                    , [ 
                        ":username" => $user->GetUsername() 
                        , ":email" => $user->GetEmail()
                        , ":hash" => $hash
                    ]);

                if ($result)
                    $this->connect->CommitTransac();
            }
        } catch (\Exception $e) {
            $this->connect->RollBackTransac();
        }

        return $result;
    }
}