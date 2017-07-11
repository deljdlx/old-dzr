<?php

namespace DZR\Application\Controller;

use DZR\Controller;
use DZR\Datasource;
use DZR\Application\Model\Album as EntityAlbum;

class Album extends Controller
{

    /**
     * @var Datasource
     */
    protected $datasource;

    public function getInfoById($id)
    {

        $entitySong = new EntityAlbum($this->datasource);

        if($entitySong->loadById($id)) {
            return $entitySong;
        }
        else {
            return false;
        }
    }
}
