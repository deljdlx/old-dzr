<?php

namespace DZR\Application\Controller;

use DZR\Application\Model\PlayList as EntityPlaylist;
use DZR\Application\Model\Song;
use DZR\Controller;
use DZR\Datasource;


class Playlist extends Controller
{

    /**
     * @var Datasource
     */
    protected $datasource;

    public function addSongToPlaylist($playlistId, $songId)
    {

        $playlist = new EntityPlaylist($this->datasource);
        $playlist->loadById($playlistId);

        if($playlist->isLoaded()) {
            $song = new Song($this->datasource);
            $song->loadById($songId);

            if($song->isLoaded()) {
                $playlist->addSong($song);
                return $playlist;
            }

        }

        return null;
    }

}
