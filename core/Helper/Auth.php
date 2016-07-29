<?php
namespace App\Helper;

/**
 * Class Auth
 */
class Auth{

    /**
     * @var session
     */
    private $session;

    /**
     * @param $session
     */
    public function __construct($session){
        $this->session = $session;
    }

    /**
     * Retourne si l'utilisateur est connecté
     * @return bool
     */
    public function isConnect(){
        return is_numeric($this->session->read('auth')) ? true : false;
    }

    /**
     * Ajoute à la session l'id de l'utilisateur et le connecte
     * @param $user
     */
    public function connect($user){
        $this->session->write('auth', $user);
    }

    /**
     * retourne l'id de l'utilisateur connecté
     * @return integer
     */
    public function idAuth(){
        return $this->session->read('auth');
    }

    /**
     *  Deconnecte l'utilisateur
     */
    public function disconnect(){
        $this->session->delete('auth');
        header('Location: /signin');
        exit();
    }

    /**
     * Redirige si l'utilisateur n'est pas connecté
     */
    public function redirect(){
        if(!$this->isConnect()){
            header('Location: /signin');
            exit();
        }
    }
}