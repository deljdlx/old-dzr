<?php

namespace DZR\Application\Model;


use DZR\Entity;

class Artist extends Entity
{

    /**
     * @var Album[]
     */
    private $albums;

    /**
     * @var Song[]
     */
    private $songs;


    /**
     * @return Album[]|null
     */
    public function getAlbums()
    {
        if ($this->albums === null) {
            $this->albums = array();

            $query = "
                SELECT
                    album.id,
                    album.title,
                    album.data,
                    album.artist_id
                FROM " . Album::getTableName() . " album
                WHERE album.artist_id=:artiste_id";


            $results = $this->execute($query, array(':artiste_id' => $this->getId()));

            if (!empty($results)) {
                foreach ($results as $data) {
                    $album = new Album($this->getDatasource());
                    $album->setValues($data);
                    $this->albums[] = $album;
                }
            }
        }

        return $this->albums;
    }


    /**
     * @return Song[]|null
     */
    public function getSongs()
    {
        if ($this->songs === null) {
            $this->songs = array();
            $query = "
                SELECT
                    song.id,
                    song.title,
                    song.duration,
                    song.artist_id,
                    song.data
                FROM " . Song::getTableName() . " song
                WHERE song.artist_id=:artist_id
            ";

            $results = $this->execute($query, array('artist_id' => $this->getId()));
            if(!empty($results)) {
                foreach ($results as $data) {
                    $song = new Song($this->getDatasource());
                    $song->setValues($data);
                    $this->songs[] = $song;
                }
            }
        }
        return $this->songs;
    }


    /**
     * @param $search
     * @return Artist[]|bool
     */
    public function search($search)
    {
        $query = "
            SELECT * FROM " . static::getTableName() . " artist
            WHERE name LIKE :search
        ";

        $results = $this->execute($query, array(':search' => '%' . $search . '%'));

        if (!empty($results)) {
            $artists = array();
            foreach ($results as $values) {
                $artist = new Artist($this->getDatasource());
                $artist->setValues($values);
                $artists[] = $artist;
            }
            return $artists;
        } else {
            return false;
        }
    }



    public function exists()
    {
        $query = "SELECT " . $this->getIdFieldName() . " FROM " . $this->getTableName() . " WHERE name=:name";
        $results = $this->execute($query, array(':name' => $this->getValue('name')));

        if (!empty($results)) {
            foreach ($results as $values) {
                $artist = new Artist($this->getDatasource());
                $artist->loadById($values['id']);
                if ($artist->getValue('name') == $this->getValue('name')) {
                    $this->setValues($artist->getValues());
                    return true;
                }
            }

        } else {
            return false;
        }
    }


    public static function getTableName()
    {
        return 'artist';
    }

    public static function getIdFieldName()
    {
        return 'id';
    }


}