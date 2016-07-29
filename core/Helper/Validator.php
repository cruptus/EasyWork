<?php
namespace App\Helper;

class Validator
{

    private $data;
    private $errors = [];

    public function __construct($data){
        $this->data = $data;
    }

    private function getField($field){
        if (!isset($this->data[$field])) {
            return null;
        }
        return $this->data[$field];
    }

    private function setField($field, $value){
        if(isset($this->data[$field]))
           $this->data[$field] = $value;
    }

    public function isTaille($field, $errorMsg = false, $required = true){
        if($required == false && $this->getField($field) == null)
            return true;
        if (!preg_match("/^([012]|([0-1]\.[0-9][1-9]?)|(2\.[0-4][1-9]?)|2\.5?)$/",$this->getField($field))) {
            $this->errors[$field] = $errorMsg;
            return false;
        }
        return true;
    }

    public function isPicture($field, $errorMsg = false, $required = true){
        if($required == false && $this->getField($field) == null)
            return true;
        if (!preg_match("/^data:image\/png;base64,/",$this->getField($field))) {
            $this->errors[$field] = $errorMsg;
            return false;
        }
        return true;
    }

    public function isAlphaNumeric($field, $errorMsg = false, $required = true){
        if($required == false && $this->getField($field) == null)
            return true;
        if (!preg_match("/^[a-zA-Z0-9]+$/",$this->getField($field))) {
            $this->errors[$field] = $errorMsg;
            return false;
        }
        return true;
    }

    public function isAlphaCaractere($field, $errorMsg = false, $required = true){
        if($required == false && $this->getField($field) == null)
            return true;
        if (!preg_match("/^[a-zA-Z][a-zA-Z- ]+$/",$this->getField($field))) {
            $this->errors[$field] = $errorMsg;
            return false;
        }
        return true;
    }

    public function isName($field, $errorMsg = false, $required = true){
        if($required == false && $this->getField($field) == null)
            return true;
        if (!preg_match("/^[a-zA-ZáàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ-]+$/",$this->getField($field))) {
            $this->errors[$field] = $errorMsg;
            return false;
        }
        return true;
    }

    public function isBody($field, $errorMsg = false, $required = true){
        if($required == false && $this->getField($field) == null)
            return true;
        if (!preg_match("/^[0-9a-zA-ZáàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ.,_\r\s!?@'\"-]+$/",$this->getField($field))) {
            $this->errors[$field] = $errorMsg;
            return false;
        }
        return true;
    }

    public function isColor($field, $errorMsg = false, $required = true){
        if($required == false && $this->getField($field) == null)
            return true;
        if (!preg_match("/^#[a-f0-9]{6}$/",$this->getField($field))) {
            $this->errors[$field] = $errorMsg;
            return false;
        }
        return true;
    }

    public function isAlpha($field, $errorMsg = false, $required = true){
        if($required == false && $this->getField($field) == null)
            return true;
        if (!preg_match("/^[a-zA-Z]+$/",$this->getField($field))) {
            $this->errors[$field] = $errorMsg;
            return false;
        }
        return true;
    }

    public function isPassword($field, $errorMsg = false){
        if (!preg_match("/^[a-zA-Z0-9-]{6,20}$/",$this->getField($field))) {
            $this->errors[$field] = $errorMsg;
            return false;
        }
        return true;
    }

    public function isEmail($field, $errorMsg = false, $required = true){
        if($required == false && $this->getField($field) == null)
            return true;
        if (!filter_var($this->getField($field), FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field] = $errorMsg;
            return false;
        }
        return true;
    }

    public function isTel($field, $errorMsg = false, $required = true){
        if($required == false && $this->getField($field) == null)
            return true;
        if (!preg_match("/^[0-9]{10}$/", $this->getField($field))) {
            $this->errors[$field] = $errorMsg;
            return false;
        }
        return true;
    }

    public function isSexe($field, $errorMsg = false, $required = true){
        if($required == false && $this->getField($field) == null)
            return true;
        if (!preg_match("/^[fm]{1}$/", $this->getField($field))) {
            $this->errors[$field] = $errorMsg;
            return false;
        }
        return true;
    }

    public function isUrl($field, $errorMsg = false, $required = true){
        if($required == false && $this->getField($field) == null)
            return true;
        if (!filter_var($this->getField($field), FILTER_VALIDATE_URL)) {
            $this->errors[$field] = $errorMsg;
            return false;
        }
        return true;
    }

    public function isDate($field, $errorMsg = false, $required = true){
        if($required == false && $this->getField($field) == null)
            return true;
        try{
            $date = \DateTime::createFromFormat('Y-m-d', $this->getField($field));
            $this->setField($field, $date);
            return true;
        }catch(\Exception $e){
            $this->errors[$field] = $errorMsg;
            return false;
        }
    }

    public function isAdressIp($field, $errorMsg = false, $required = true) {
        if ($required == false && $this->getField($field) == null)
            return true;
        if (!filter_var($this->getField($field), FILTER_VALIDATE_IP)) {
            $this->errors[$field] = $errorMsg;
            return false;
        }
        return true;
    }

    public function isNumeric($field, $errorMsg = false, $required = true){
        if($required == false && $this->getField($field) == null)
            return true;
        if (!preg_match("/^[0-9]+$/", $this->getField($field))) {
            $this->errors[$field] = $errorMsg;
            return false;
        }
        return true;
    }

    public function isCard($field, $errorMsg = false, $required = true){
        if($required == false && $this->getField($field) == null)
            return true;
        if (!preg_match("/^0x[a-z0-9]+$/", $this->getField($field))) {
            $this->errors[$field] = $errorMsg;
            return false;
        }
        return true;
    }

    public function isChooseArray($field, $choose, $errorMsg = false, $required = true){
        if($required == false && $this->getField($field) == null)
            return true;
        for($i = 0; $i < count($choose); $i++)
            if($this->getField($field) === $choose[$i])
                return true;

        $this->errors[$field] = $errorMsg;
        return false;
    }

    public function isValid(){
        return empty($this->errors);
    }

    public function getErrors(){
        return $this->errors;
    }

}