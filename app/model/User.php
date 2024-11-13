<?php

namespace App\Model;

use App\Controller\Main;
use Connection\SQLGenerator;

class User implements Table {

    protected int $idUser;
    protected string $userEmail;
    protected string $userPassword;
    protected int $userPermission;

    public function getIdUser()
    {
        return $this->idUser;
    }

    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;

        return $this;
    }

    public function getUserEmail() 
    {
        return $this->userEmail;
    }

    public function setUserEmail($userEmail)
    {
        $this->userEmail = $userEmail;

        return $this;
    }

    public function getUserPassword()
    {
        return $this->userPassword;
    }

    public function setUserPassword($userPassword)
    {
        $this->userPassword = Main::hashPassword($userPassword);

        return $this;
    }

    public function getUserPermission()
    {
        return $this->userPermission;
    }

    public function setUserPermission($userPermission)
    {
        $this->userPermission = $userPermission;

        return $this;
    }

    public function __construct(string $userEmail, string $userPassword, int $userPermission = 0)
    {
        $this->userEmail = $userEmail;
        $this->userPassword = $userPassword;
        $this->userPermission = $userPermission;
    }

    public function insert() : int
    {
        $data = [
            'userEmail' => $this->userEmail,
            'userPassword' => $this->userPassword,
            'userPermission' => $this->userPermission
        ];
        return SQLGenerator::insertSQL(__METHOD__, $data);
    }

    public function update(int $id) : bool
    {
        $data = [
            'userEmail' => $this->userEmail,
            'userPassword' => $this->userPassword,
            'userPermision' => $this->userPermission
        ];
        return SQLGenerator::updateSQL(__CLASS__, $this->idUser, $data);
    }

    public function delete(int $id) : bool
    {
        return SQLGenerator::deleteSQL(__CLASS__, $this->idUser);
    }

    public function select()
    {
        $where = [
            'userEmail' => $this->userEmail,
            'userPassword' => $this->userPassword,
            'userPermission' => $this->userPermission
        ];
        return SQLGenerator::selectSQL(null, __CLASS__, null, $where);
    }

    public function selectById(int $id)
    {
        return SQLGenerator::selectSQL(null, __CLASS__, null, ['id' => $id]);
    }

    public function selectByUsername()
    {
        return SQLGenerator::selectSQL(null, __CLASS__, null, ['userEmail' => $this->userEmail]);
    }
}
