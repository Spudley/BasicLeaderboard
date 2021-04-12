<?php
namespace App\Database\Session;

class DB extends \App\Database\DB
{
    public function __construct(array $config)
    {
        session_start();
    }
}

