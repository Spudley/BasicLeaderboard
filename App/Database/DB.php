<?php
namespace App\Database;

abstract class DB
{
    public function getTableClass(string $tablename)
    {
        $classname = preg_replace('/DB$/', $tablename, get_class($this));
        return $classname;
    }
}

