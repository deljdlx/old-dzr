<?php

namespace DZR\Application\Controller;

use DZR\Application\Model\PlayList;
use DZR\Controller;
use DZR\Datasource;
use DZR\Application\Model\User as EntityUser;

class User extends Controller
{

    /**
     * @var Datasource
     */
    protected $datasource;

    public function getInfoById($userId)
    {
        $entityUser = new EntityUser($this->datasource);
        $entityUser->loadById($userId);
        return $entityUser;
    }


    public function getPlaylist($userId, $playlistSlug = PlayList::FAVORITE_PLAYLIST_SLUG)
    {
        $entityUser = new EntityUser($this->datasource);
        $entityUser->loadById($userId);
        try {
            $playlist = $entityUser->getPlayListBySlug($playlistSlug);
            return $playlist;
        }
        catch (\UnexpectedValueException $exception) {
            return false;
        }
    }
}
