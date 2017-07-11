<?php

namespace DZR\Application\Model;


use DZR\Entity;

class Song extends Entity
{

    /**
     * @var Artist
     */
    private $artist;

    /**
     * @var Album[]
     */
    private $albums;


    public function getAlbums()
    {
        if ($this->albums === null) {
            $this->albums = array();
            $query = "
            SELECT
                album.id,
                album.title,
                album.data
            FROM " . Album_Song::getTableName() . " relation
            JOIN " . Album::getTableName() . " album
                ON album.id=relation.album_id
            WHERE
                relation.song_id=:song_id
        ";

            $results = $this->execute($query, array('song_id' => $this->getId()));

            foreach ($results as $data) {
                $album = new Album($this->getDatasource());
                $album->setValues($data);
                $this->albums[] = $album;
            }
        }


        return $this->albums;


    }


    public function setArtist(Artist $artist)
    {
        $this->artist = $artist;
        $this->setValue('artist_id', $artist->getId());
        return $this;
    }

    public function getArtist()
    {
        if ($this->artist === null) {
            $this->artist = new Artist($this->getDatasource());
            $this->artist->loadById($this->getValue('artist_id'));
        }
        return $this->artist;
    }

    public function search($search)
    {
        $query = "
            SELECT * FROM " . static::getTableName() . " WHERE title LIKE :search
        ";

        $results = $this->execute($query, array(':search' => '%'.$search.'%'));
        $songs = array();

        if(!empty($results)) {
            foreach ($results as $values) {
                $song = new Song($this->getDatasource());
                $song->setValues($values);
                $songs[] = $song;
            }

            return $songs;
        }
        else {
            return array();
        }

    }


    public function exists()
    {
        $query = "SELECT " . $this->getIdFieldName() . " FROM " . $this->getTableName() . " WHERE title=:title";
        $results = $this->execute($query, array(':title' => $this->getValue('title')));

        if (!empty($results)) {


            foreach ($results as $values) {
                $song = new Song($this->getDatasource());
                $song->loadById($values['id']);

                if ($song->getValue('artist_id') == $this->getValue('artist_id')) {
                    $this->setValues($song->getValues());
                    return true;
                }
            }

        } else {
            return false;
        }
    }

    public function jsonSerialize()
    {
        $dataAlbum = array();

        foreach ($this->getAlbums() as $album) {
            $albumData=$album->jsonSerialize();
            unset($albumData['songs']);
            $dataAlbum[] = $albumData;
        }


        $data = parent::jsonSerialize();
        $data['artist'] = $this->getArtist()->jsonSerialize();
        $data['albums'] = $dataAlbum;
        return $data;
    }


    public static function getTableName()
    {
        return 'song';
    }

    public static function getIdFieldName()
    {
        return 'id';
    }


}