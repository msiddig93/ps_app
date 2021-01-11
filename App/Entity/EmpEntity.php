<?php

namespace App\Entity;
use App;

class EmpEntity
{
    public function getUrl()
    {
        return App::$path.'user/profile/'.$this->id;
    }

    public function __get($key)
    {
        $method = 'get'.ucfirst($key);
        $this->$key = $this->$method();
        return $this->$key;
    }
}