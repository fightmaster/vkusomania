<?php
namespace Users;

class User
{
    private $id;
    private $login;
    private $FIO;
    private $email;
    private $role;

    
    public function getId()
    {
        return $this->id;
    }
    
    public function setId($id)
    {
        $this->id = $id;
    }
    
    public function getLogin()
    {
        return $this->login;
    }
    
    public function setLogin($login)
    {
        $this->login = $login;
    }
    
    public function getFIO()
    {
        return $this->FIO;
    }
    
    public function setFIO($FIO)
    {
        $this->FIO = $FIO;
    }
    
    public function getEmail()
    {
        return $this->email;
    }
    
    public function setEmail($email)
    {
        $this->email = $email;
    }
    
    public function getRole()
    {
        return $this->role;
    }
    
    public function setRole($role)
    {
        $this->role = $role;
    }

}
