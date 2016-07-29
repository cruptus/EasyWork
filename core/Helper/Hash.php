<?php

namespace App\Helper;

class Hash{

    public static function make($password){
        return hash("sha256", $password);
    }
}