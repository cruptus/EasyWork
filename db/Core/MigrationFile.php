<?php

namespace DB\Core;


class MigrationFile
{

    private $action;
    private $table;
    private $time;
    private $color;
    private $migration;

    public function __construct($action, $table)
    {
        $this->action = $action;
        $this->table = $table;
        $this->time = date('YmdHis', time());
        $this->color = new Color();
        $this->create_file();
    }

    public function create_file(){
        $this->migration = fopen(__DIR__.'/../Migrations/'.$this->time.'_'.$this->action.'_'.$this->table.'.php', 'w+');
        $this->write_file();
        fclose($this->migration);
        $this->color->getColoredString('Migration '.$this->time.'_'.$this->action.'_'.$this->table.' create', 'green');
    }

    public function write_file(){
        fputs($this->migration, '<');
        fseek($this->migration, 1);
        ob_start();
        $name = ucfirst($this->action).'_'.$this->table.'_'.$this->time;
        require 'File.php';
        $content = ob_get_clean();
        fputs($this->migration, $content);
    }


}