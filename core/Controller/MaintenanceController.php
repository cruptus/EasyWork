<?php

namespace App\Controller;


use App\Config;
use App\Helper\Captcha;
use App\Helper\Mail;
use App\Helper\Validator;

class MaintenanceController extends Controller
{

    public function __construct() {
        if(!Config::$MAINTENANCE)
            header('Location: /');
        $this->template = 'maintenance';
    }

    public function maintenance(){
        $this->render('maintenance');
    }
}