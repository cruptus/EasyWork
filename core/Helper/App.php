<?php
namespace App\Helper;
use App\Config;

/**
 * Class App
 */
class App{

    /**
     * Stock l'instance de la base de donnée
     * @var null
     */
    static $db = null;

    /**
     * Sauvegarde l'instance de la app_class App
     * @var App
     */
    private static $instance;

    /**
     * Retourne l'instance de la app_class App
     * @return App
     */
    static function getInstance(){
        if(is_null(self::$instance))
            self::$instance = new App();
        return self::$instance;
    }

    /**
     * Retourne l'instance de la base de donnée
     * @return Database|null
     */
    static function getDataBase(){
        if(!self::$db){
            self::$db = new Database(Config::$DB_USER, Config::$DB_PASSWORD, Config::$DB_NAME, Config::$DB_HOST);
        }
        return self::$db;
    }

    /**
     * Retourne l'instance de la sessions
     * @return Auth
     */
    static function getAuth(){
        return new Auth(Session::getInstance());
    }
}