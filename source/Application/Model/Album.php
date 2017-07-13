<?php

namespace DZR\Application\Model;


use DZR\Entity;

class Album extends Entity
{


    /**
     * @var Artist
     */
    private $artist;

    /**
     * @var Song[]
     */
    private $songs;

    /**
     * @param Artist $artist
     * @return $this
     */
    public function setArtist(Artist $artist)
    {
        $this->artist = $artist;
        $this->setValue('artist_id', $artist->getId());
        return $this;
    }

    /**
     * @return Artist
     */
    public function getArtist()
    {
        if ($this->artist === null) {
            $this->artist = new Artist($this->getDatasource());
            $this->artist->loadById($this->getValue('artist_id'));
        }
        return $this->artist;
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
                FROM " . Album_Song::getTableName() . " relation
                    JOIN " . Song::getTableName() . " song
                    ON song.id=relation.song_id
                WHERE relation.album_id=:album_id
                ORDER BY rank
            ";

            $results = $this->execute($query, array('album_id' => $this->getId()));
            if (!empty($results)) {
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
     * @return bool
     */
    public function exists()
    {
        $query = "SELECT " . $this->getIdFieldName() . " FROM " . $this->getTableName() . " WHERE title=:title";
        $results = $this->execute($query, array(':title' => $this->getValue('title')));


        if (!empty($results)) {
            foreach ($results as $values) {
                $album = new Album($this->getDatasource());
                $album->loadById($values['id']);
                if ($album->getValue('artist_id') == $this->getValue('artist_id')) {
                    $this->setValues($album->getValues());
                    return true;
                }
            }

        }
        return false;
    }


    /**
     * @return array
     */
    public function jsonSerialize()
    {
        $data = parent::jsonSerialize();
        $data['songs'] = array();

        foreach ($this->getSongs() as $song) {
            $data['songs'][] = $song->getValues();
        }

        return $data;

    }


    public static function getTableName()
    {
        return 'album';
    }

    public static function getIdFieldName()
    {
        return 'id';
    }


}