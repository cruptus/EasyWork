<?php

namespace DB\Core;


class Migration {

    private $query;

    /**
     * @var Table
     */
    private $table;

    public function __construct()
    {
        $this->query = '';
    }


    public function create_table(string $table){
        $this->query = "CREATE TABLE {$table}";
        $this->table = new Table('(', ')');
        return $this->table;
    }

    public function delete_table(string $table){
        $this->query = "DROP TABLE {$table}";
        $this->table = new Table();
    }

    public function alter_table(string $table){
        $this->query = "ALTER TABLE {$table}";
        $this->table = new Table();
        return $this->table;
    }

    public function getQuery(){
        $this->migrate();
        return $this->query.' '.$this->table->getQuery();
    }

    public function migrate(){}

}