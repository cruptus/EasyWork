<?php

namespace DB\Core;


class Table
{

    private $begin;
    private $end;
    private $attribut = [];

    public function __construct(string $begin = '', string $end = '')
    {
        $this->begin = $begin;
        $this->end = $end;
    }

    /**
     * Construit l'attribut
     * @param $string
     * @param bool $null
     * @param null $default
     * @return $this
     */
    private function buildString($string, $null = true, $default = null){
        if(!$null && $default != null){
            $string .= " DEFAULT {$default}";
        } elseif(!null) {
            $string .= ' NOT NULL';
        }
        $this->attribut[] = $string;
        return $this;
    }

    /**
     * Ajoute une attribut de type STRING
     * @param $name
     * @param int $size
     * @param bool $null
     * @param null $default
     * @return Table
     */
    public function string($name, $size = 255, $null = true, $default = null){
        $string = "{$name} VARCHAR({$size})";
        return $this->buildString($string, $null, $default);
    }

    /**
     * Ajoute un attribut de type INT
     * @param $name
     * @param int $size
     * @param bool $null
     * @param null $default
     * @return Table
     */
    public function int($name, $size = 255, $null = true, $default = null){
        $string = "{$name} INT({$size})";
        return $this->buildString($string, $null, $default);
    }

    /**
     * Ajoute un attribut id
     * @param $name
     * @return Table
     */
    public function id($name){
        $string = "{$name} INT PRIMARY KEY";
        return $this->buildString($string);
    }

    /**
     * Retourne la QUERY
     * @return string
     */
    public function getQuery(){
        $string = $this->begin;
        foreach($this->attribut as $key => $query){
            $string .= $query;
            if($key != count($this->attribut)-1)
                $string .= ', ';
        }
        return $string.$this->end;
    }
}