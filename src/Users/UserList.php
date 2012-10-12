<?php

namespace Users;

class UserList
{
    
    private $list = array();
    
    public function add(User $user)
    {
        $this->list[] = $user;
    }
    
    public function clear()
    {
        $this->list = array();
    }
    
    public function getUsers()
    {
        return $this->list;
    }
}

