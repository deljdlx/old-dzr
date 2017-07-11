<?php

namespace DZR\Application\Model;


use DZR\Entity;

class Album_Song extends Entity
{

    private $album;
    private $song;


    public function exists()
    {
        $query = "SELECT " . $this->getIdFieldName() . " FROM " . $this->getTableName() . " WHERE song_id=:song_id and album_id=:album_id";
        $results = $this->execute($query, array(
            ':album_id' => $this->getValue('album_id'),
            ':song_id' => $this->getValue('song_id')
        ));

        if (!empty($results)) {
            return true;
        } else {
            return false;
        }
    }

    public function setAlbum(Album $album)
    {
        $this->album = $album;
        $this->setValue('album_id', $album->getId());
        return $this;
    }

    public function setSong(Song $song)
    {
        $this->song = $song;
        $this->setValue('song_id', $song->getId());
        return $this;
    }

    public static function getTableName()
    {
        return 'album_song';
    }

    public static function getIdFieldName()
    {
        return 'id';
    }


}