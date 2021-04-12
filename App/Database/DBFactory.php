<?php
namespace App\Database;

class DBFactory
{
    const CONFIG_FILE = '/../config/db.json';

    public static function newInstance()
    {
        $configFile = file_get_contents(dirname(__DIR__) . self::CONFIG_FILE);
        $dbConfig = json_decode($configFile, true);

        $dbClass = __NAMESPACE__.'\\'.$dbConfig['type'].'\\DB';
        return new $dbClass($dbConfig);
    }
}

