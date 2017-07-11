<?php

namespace DZR\Application\Model;


use DZR\Entity;

class Artist extends Entity
{

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
                    album.data,
                    album.artist_id
                FROM " . Album::getTableName() . " album
                WHERE album.artist_id=:artiste_id";



            $results=$this->execute($query, array(':artiste_id'=>$this->getId()));

            if(!empty($results)) {
                foreach ($results as $data) {
                    $album=new Album($this->getDatasource());
                    $album->setValues($data);
                    $this->albums[]=$album;
                }
            }
        }

        return $this->albums;
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