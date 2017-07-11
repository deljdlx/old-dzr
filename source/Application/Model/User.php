<?php

namespace DZR\Application\Model;


use DZR\Entity;

class User extends Entity
{

    /**
     * @var Playlist[]
     */
    private $playlists=null;


    /**
     * @param $slug
     * @return Playlist
     */
    public function getPlayListBySlug($slug)
    {

        $playlist = new Playlist($this->dataSource);
        $playlist->loadBySlugAndUserId($slug, $this->getValue('id'));

        return $playlist;
    }

    /**
     * @return Playlist[]|null
     */
    public function getPlayLists() {
        if($this->playlists === null) {
            $this->loadPlaylists();
        }
        return $this->playlists;

    }


    /**
     * @return $this
     */
    public function loadPlaylists() {
        $this->playlists=Playlist::getManyByUserId($this->dataSource, $this->getId());
        return $this;
    }


    public static function getTableName()
    {
        return 'user';
    }

    public static function getIdFieldName()
    {
        return 'id';
    }


}