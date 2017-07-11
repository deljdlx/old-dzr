<?php

namespace DZR\Application\Controller;

use DZR\Controller;
use DZR\Datasource;
use DZR\Application\Model\Artist as EntityArtist;

class Artist extends Controller
{

    /**
     * @var Datasource
     */
    protected $datasource;

    public function getInfoById($id)
    {

        $artist = new EntityArtist($this->datasource);

        if($artist->loadById($id)) {
            return $artist;
        }
        else {
            return false;
        }
    }

    public function getAlbums($id) {
        $artist = new EntityArtist($this->datasource);



        if($artist->loadById($id)) {
            return $artist->getAlbums();
        }
        else {
            return false;
        }
    }
}
