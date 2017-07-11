<?php

namespace DZR\Application\Model;


use DZR\Entity;

class Song extends Entity
{



    public static function getTableName()
    {
        return 'song';
    }

    public static function getIdFieldName()
    {
        return 'id';
    }


}