<?php

namespace DZR\Application\Controller;

use DZR\Controller;
use DZR\Datasource;
use DZR\Application\Model\Song as EntitySong;

class Song extends Controller
{

    /**
     * @var Datasource
     */
    protected $datasource;

    public function getInfoById($id)
    {

        $entitySong = new EntitySong($this->datasource);
        $entitySong->loadById($id);

        return $entitySong;

    }
}
