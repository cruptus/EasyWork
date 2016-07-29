<?php

namespace App\Model;

use App\Helper\App;
use App\Helper\Validator;

class Model
{

    protected $className = null;
    protected $valid_item = [];
    protected $errors = [];
    protected $fields = [];

    /**
     * Retourne les attributs
     * @param $key
     * @return mixed
     */
    public function __get($key){
        return $this->$key;
    }

    /**
     * Vérifie si tous les attributs correspondent aux normes
     * @return bool
     */
    public function isValid(){
        $value = [];
        foreach($this->valid_item as $key => $message){
            $value[$key] = $this->$key;
        }
        $validator = new Validator($value);

        foreach($this->valid_item as $key => $specification){
            foreach($specification['validation'] as $validation => $message){
                $method = 'is'.ucfirst($validation);
                $validator->$method($key, $message, $specification['required'] ?? true);
            }
        }
        $this->errors = $validator->getErrors();
        return $validator->isValid();
    }

    /**
     * Retourne les erreurs
     * @return array
     */
    public function getErrors(){
        return $this->errors;
    }


    public function save(){
        $attributes = array();
        for($i = 0; $i < count($this->fields); $i++){
            $attribute = $this->fields[$i];
            $attributes[$attribute] = $this->$attribute;
        }
        return App::getDataBase()->insert($this->className, $attributes);
    }
}