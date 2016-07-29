<?php
namespace App\Helper\Html;

class Form{

    private $data;

    public function __construct($data = []){
        $this->data = $data;
    }

    private function getValue($index){
        return isset($this->data[$index]) ? $this->data[$index] : null;
    }

    private function getLabel($label, $name){
        return "<label for=\"" . $name ."\">$label</label>";
    }

    private function surround($html){
        return "<div class=\"form-group\">$html</div>";
    }

    public function input($label, $name, $placeholder = null, $option = null){
        return $this->surround($this->getLabel($label, $name) . "
        <input type='text' name='" . $name . "' id='" . $name . "' value='" . $this->getValue($name) ."' class='form-control' placeholder='".$placeholder."' ".$option." />");
    }

    public function password($label, $name, $placeholder = null){
        return $this->surround($this->getLabel($label, $name) . "
        <input type='password' name='" . $name . "' id='" . $name . "' value='" . $this->getValue($name) ."' class='form-control' placeholder='".$placeholder."' />");
    }

    public function email($label, $name, $placeholder = null, $option = null){
        return $this->surround($this->getLabel($label, $name) . "
        <input type='email' name='" . $name . "' id='" . $name . "' value='" . $this->getValue($name) ."' class='form-control' placeholder='".$placeholder."' ".$option." />");
    }

    public function date($label, $name, $placeholder = null, $option = null){
        return $this->surround($this->getLabel($label, $name) . "
        <input type='date' name='" . $name . "' id='" . $name . "' value='" . $this->getValue($name) ."' class='form-control' placeholder='".$placeholder."' ".$option." />");
    }

    public function time($label, $name, $placeholder = null, $option = null){
        return $this->surround($this->getLabel($label, $name) . "
        <input type='time' name='" . $name . "' id='" . $name . "' value='" . $this->getValue($name) ."' class='form-control' placeholder='".$placeholder."' ".$option." />");
    }

    public function text($label, $name, $row = 3, $placeholder = null, $option = null){
        return $this->surround($this->getLabel($label, $name) . "
        <textarea class='form-control' id='" .$name."' name='" . $name . "' rows='".$row."' placeholder='".$placeholder."' ".$option." >".$this->getValue($name)."</textarea>");
    }

    public function select($label, $name, $values = []){
        $html = "<select name='$name' id='$name' class='form-control'>";
        foreach($values as $value){
            $cle = key($values);
            if($this->getValue($name) != null && $this->getValue($name) == $cle)
                $html .= "<option value='$cle' selected='selected'>$value</option>";
            else
                $html .= "<option value='$cle'>$value</option>";
            next($values);
        }
        $html .= "</select>";
        return $this->surround($this->getLabel($label, $name).$html);
    }

    public function submit($texte){
        return $this->surround("<div class=\"col-sm-offset-3 col-sm-9\">
                    <button type=\"submit\" class=\"btn btn-default\">$texte</button>
                </div>");
    }

    public function lien($lien, $texte){
        return $this->surround('<div class="col-sm-offset-2 col-sm-10">
                    <a href="' .$lien .'" class="body-form-lien">' . $texte .'</a>
                </div>');
    }
}