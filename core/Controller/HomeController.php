<?php

namespace App\Controller;

use App\Helper\Validator;
use App\Helper\Captcha;
use App\Helper\Mail;
use App\Config;
use App\Model\Account;

class HomeController extends Controller {

    /**
     * HomeController constructor
     */
    public function __construct() {

    }

    /**
     * permet de retourner la home page
     * @throws \App\Router\RouterException
     */
    public function index(){
        $this->render("home");
    }

    /**
     * Redirection vers la page home
     */
    public function racine(){
        header('Location: /home');
        die();
    }

}