<?php
namespace App\Database\MySql;

use PDO;

class DB extends \App\Database\DB
{
    private $pdo;

    public function __construct(array $config)
    {
        $dsn = "mysql:dbname={$config['db']};host={$config['host']}";
//        $this->pdo = new PDO($dsn, $config['username'], $config['password'], [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        $this->pdo = new PDO($dsn, $config['username'], $config['password'], [PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING]);
        $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    }

    public function getPDO()
    {
        return $this->pdo;
    }

    public function query(string $sql, array $args, ?string $class = null)
    {
        $sth = $this->pdo->prepare($sql);
        if ($class) {
            $sth->setFetchMode(PDO::FETCH_CLASS, $class);
        } else {
            $sth->setFetchMode(PDO::FETCH_OBJ);
        }
        $sth->execute($args);
        return $sth->fetchAll();
    }

    public function execute(string $sql, array $args)
    {
        $sth = $this->pdo->prepare($sql);
        $sth->execute($args);
    }
}

