<?php

namespace DZR\Application\Model;


use DZR\Entity;

class Playlist_Song extends Entity
{

    /**
     * @var Playlist
     */
    private $playlist;

    /**
     * @var Song
     */
    private $song;


    /**
     * @param $playlistId
     * @param $songId
     * @return $this
     */
    public function loadByPlaylistAndSongId($playlistId, $songId)
    {
        $query = "
            SELECT * FROM " . $this->getTableName() . "
            WHERE
                playlist_id=:playlistId
                AND song_id=:songId
        ";

        $values = $this->dataSource->execute($query, array(
            ':playlistId' => $playlistId,
            ':songId' => $songId
        ));
        $this->values = reset($values);
        return $this;
    }


    /**
     * @param Playlist $playlist
     * @return $this
     */
    public function setPlaylist(Playlist $playlist)
    {
        $this->playlist = $playlist;
        $this->setValue('playlist_id', $playlist->getId());
        return $this;
    }

    /**
     * @param Song $song
     * @return $this
     */
    public function setSong(Song $song)
    {
        $this->song = $song;
        $this->setValue('song_id', $song->getId());
        return $this;
    }

    public static function getTableName()
    {
        return 'playlist_song';
    }

    public static function getIdFieldName()
    {
        return 'id';
    }


}