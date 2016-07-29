<?php
namespace App\Helper;
use \PDO;
/**
 * Class Database
 */
class Database{

    /**
     * @var PDO
     */
    private $pdo;

    /**
     * @param string $login
     * @param string $password
     * @param string $database_name
     * @param string $host
     */
    public function __construct($login, $password, $database_name, $host = 'localhost'){
        $this->pdo = new PDO("mysql:dbname=$database_name;host=$host", $login, $password);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    }


    /**
     * @param $statement
     * @param $class_name
     * @return array
     */
    public function query($statement, $class_name){
        $req = $this->pdo->query($statement);
        return $req->fetchAll(PDO::FETCH_CLASS, $class_name);
    }


    /**
     * @param $statement
     * @param $attributes
     * @param $class_name
     * @param bool $one
     * @return array|mixed
     */
    public function prepare($statement, $attributes, $class_name = false, $one = false){
        $req = $this->pdo->prepare($statement);
        $req->execute($this->protect($attributes));
        if($one){
            if($class_name){
                $datas = $req->fetch(PDO::FETCH_CLASS, $class_name);
            }else{
                $datas = $req->fetch();
            }
        }else{
            if($class_name){
                $datas = $req->fetchAll(PDO::FETCH_CLASS, $class_name);
            }else{
                $datas = $req->fetchAll();
            }
        }
        return $datas;
    }

    /**
     * Protege des injections SQL
     * @param array $params
     * @return array
     */
    private function protect($params){
        $params_temp = array();
        for($i = 0; $i < count($params); $i++){
            if(ctype_digit($params[key($params)]))
                $temp = intval($params[key($params)]);
            else
            {
                $temp = $this->pdo->quote($params[key($params)]);
                $temp = addcslashes($temp, '%_');
            }
            $params_temp[key($params)] = $temp;
            next($params);
        }
        return $params_temp;
    }


    /**
     * Retourne le dernier id inséré
     * @return int
     */
    public function lastInsertId(){
        return $this->pdo->lastInsertId();
    }

}