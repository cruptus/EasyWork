<?php

namespace DB\Core;
use App\Config;
use \PDO;

class App{

    private $user;
    private $password;
    /**
     * @var PDO;
     */
    private $pdo;
    private $color;
    private $exec;

    public function __construct($exec,$user, $password) {
        $this->user = $user;
        $this->password = $password;
        $this->exec = $exec;
        $this->color = new Color();
        $this->checkingDatabase();
    }

    public function checkingDatabase(){
        $this->color->getColoredString('Checking Database', 'yellow');
        try {
            $this->pdo = new \PDO("mysql:dbname=".Config::$DB_NAME.";host=localhost", $this->user, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->color->getColoredString('Connexion succefull', 'green', 2);
        }catch(\Exception $e){
            $this->color->getColoredString($e, 'red', 1);
            $this->color->getColoredString('Connexion failed', 'red', 2);
        }
        try{
            switch($this->exec){
                case 'migrate':
                    $this->init();
                    break;
                case 'drop':
                    $this->drop();
                    break;
                default:
                    $this->init();
                    break;
            }
            $this->color->getColoredString("Succefull", 'green', 2);
        }catch(\Exception $e){
            $this->color->getColoredString("\n".$e, 'red', 1);
            $this->color->getColoredString('ERROR', 'red', 2);
        }
    }

    public function init(){
        $req = $this->pdo->query("SHOW TABLES LIKE 'migration'");
        if($req->rowCount() == 0){
            $this->color->getColoredString('Initialisation migration', 'yellow');
            $this->pdo->exec("CREATE TABLE migration (
              id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
              time TIMESTAMP NOT NULL,
              table_desc VARCHAR(255) NOT NULL,
              detail VARCHAR(7) NOT NULL
            )");
            $this->color->getColoredString('Table migration create', 'green', 2);
            $this->init();
        } else {
            $this->color->getColoredString('Begin migration','yellow');
            $this->migration();
        }
    }

    public function migration(){
        $files = array_diff(scandir(__DIR__.'/../Migrations'), array('..', '.'));
        $req = $this->pdo->query('SELECT time FROM migration ORDER BY time DESC LIMIT 1')->fetch()['time'];
        if($req == null)
            $last = 0;
        else {
            $date = new \DateTime($req);
            $last = $date->format('YmdHis');
        }
        foreach($files as $file){
            $string = explode('_', $file);
            if($string[0] > $last) {
                $this->color->getColoredString('Migration ' . $file, null, 0);
                $string[2] = explode('.', $string[2])[0];
                require __DIR__ . "/../Migrations/{$file}";
                $class = ucfirst($string[1]) . '_' . $string[2] . '_' . $string[0];
                $migration = new $class();
                $this->pdo->exec($migration->getQuery());
                $this->color->getColoredString(' Ok', 'green');

                $req = $this->pdo->prepare('INSERT INTO migration (time, table_desc, detail) VALUES (:time, :table_desc, :detail)');
                $req->execute(array(
                    'time' => $string[0],
                    'table_desc' => $string[2],
                    'detail' => $string[1]
                ));
            }
        }
    }

    public function drop(){
        $this->color->getColoredString('Drop begin','yellow');

        $req = $this->pdo->query("SELECT table_desc FROM migration WHERE detail = 'create'");
        while($donne = $req->fetch()){
            $this->pdo->exec("DROP TABLE ".$donne['table_desc']);
            $this->color->getColoredString("Delete table ".$donne['table_desc'], 'green');
        }
        $this->pdo->exec('TRUNCATE TABLE migration');
    }

}