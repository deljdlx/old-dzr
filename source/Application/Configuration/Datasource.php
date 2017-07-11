<?php

namespace DZR\Application\Configuration;

class Datasource
{

    public static function getDSN()
    {
        //return 'sqlite:'.__DIR__.'/../data/database.sqlite';
        return 'mysql:host=127.0.0.1.;dbname=dzr';
    }

    public static function getLogin()
    {
        return 'root';
    }

    public static function getPassword()
    {
        return '';
    }

}

