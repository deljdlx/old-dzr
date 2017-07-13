<?php

namespace DZR\Application\Model;


use DZR\Entity;

class Playlist extends Entity
{

    const FAVORITE_PLAYLIST_SLUG = 'FAVORITE';

    /**
     * @var Song[]
     */
    private $songs = null;


    /**
     * @param $dataSource
     * @param $userId
     * @return Playlist[]
     */
    public static function getManyByUserId($dataSource, $userId)
    {
        $results = $dataSource->execute(
            "SELECT
                *
            FROM
                " . static::getTableName() . " playlist
            WHERE playlist.user_id=:userId",
            array(
                ':userId' => $userId
            )
        );

        $playlists = array();
        foreach ($results as $values) {
            $playlist = new static($dataSource);
            $playlist->setValues($values);
            $playlists[] = $playlist;
        }

        return $playlists;
    }


    /**
     * @param $slug
     * @param $userId
     * @return $this|bool
     */
    public function loadBySlugAndUserId($slug, $userId)
    {
        $this->songs = array();

        $query = "
            SELECT
              song.id,
              song.title,
              song.duration,
              song.data,
              song.artist_id
            FROM
                " . $this->getTableName() . " playlist
            JOIN " . Playlist_Song::getTableName() . " relation
                ON relation.playlist_id=playlist.id
            LEFT JOIN " . Song::getTableName() . " song
                ON relation.song_id=song.id
            WHERE playlist.user_id=:userId AND slug=:slug";

        $results = $this->dataSource->execute(
            $query,
            array(
                ':userId' => $userId,
                ':slug' => $slug
            )
        );


        if (!empty($results)) {
            foreach ($results as $values) {
                if ($values['id']) {
                    $song = new Song($this->dataSource);
                    $song->setValues($values);
                    $this->songs[$song->getId()] = $song;
                }

            }
            $this->isLoaded(true);
            return $this;
        }
        else {
            return false;
        }


    }


    /**
     * @param User $user
     * @return $this
     */
    public function setUser(User $user)
    {
        $this->user = $user;
        $this->setValue('user_id', $user->getId());
        return $this;
    }


    /**
     * @return Song[]|null
     */
    public function getSongs()
    {
        if ($this->songs === null) {
            $this->loadSongs();
        }
        return $this->songs;
    }


    /**
     * @return $this
     */
    public function loadSongs()
    {
        $this->songs = array();

        $query =
            "SELECT
                  song.id,
                  song.title,
                  song.duration,
                  song.data
                FROM
                    " . $this->getTableName() . " playlist
                JOIN " . Playlist_Song::getTableName() . " relation
                    ON relation.playlist_id=:playlistId
                JOIN " . Song::getTableName() . " song
                    ON relation.song_id=song.id
                ";

        $results = $this->dataSource->execute($query, array(
            ':playlistId' => $this->getId()
        ));

        if (!empty($results)) {
            foreach ($results as $values) {
                $song = new Song($this->dataSource);
                $song->setValues($values);
                $this->songs[$song->getId()] = $song;
            }
        }

        return $this;
    }


    /**
     * @param Song $song
     * @return $this
     */
    public function addSong(Song $song)
    {
        $relation = new Playlist_Song($this->dataSource);
        $relation->setPlaylist($this);
        $relation->setSong($song);
        $relation->store();
        return $this;
    }


    /**
     * @param Song $song
     * @return $this
     */
    public function removeSong(Song $song)
    {

        if (array_key_exists($song->getId(), $this->getSongs())) {
            unset($this->songs[$song->getId()]);
            $relation = new Playlist_Song($this->dataSource);
            $relation->loadByPlaylistAndSongId($this->getId(), $song->getId());
            $relation->delete();
        }
        return $this;
    }


    /**
     * @return array
     */
    public function jsonSerialize()
    {
        $data = parent::jsonSerialize();
        $data['songs'] = $this->getSongs();
        return $data;
    }


    public static function getTableName()
    {
        return 'playlist';
    }

    public static function getIdFieldName()
    {
        return 'id';
    }


}