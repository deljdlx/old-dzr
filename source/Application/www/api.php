<?php

require(__DIR__ . '/../bootstrap.php');


$application->route('`/user/(.+?)/info(?:$|\?)`', function ($userId) {
    $controller = new \DZR\Application\Controller\User();
    $controller->inject('datasource', $this->get('datasource'));
    $user = $controller->getInfoById($userId);


    if ($user->isLoaded()) {
        $this->sendJSONResponse($user);
    } else {
        $this->notFound();
        $this->sendJSONResponse(array(
            'message' => 'No user with id "' . $userId . '"'
        ));
    }
});

$application->route('`/user/(.*?)/playlist/(.+?)(?:$|\?)`', function ($userId, $playlistSlug) {

    $controller = new \DZR\Application\Controller\User();
    $controller->inject('datasource', $this->get('datasource'));

    $playlist = $controller->getPlaylist($userId, $playlistSlug);


    if ($playlist) {

        $this->sendJSONResponse($playlist);
    } else {
        $this->sendJSONResponse(array(
            'message' => 'No playlist "' . $playlistSlug . '" for user "' . $userId . '"'
        ), \DZR\Response::NOT_FOUND);
    }
});


$application->route('`/user/(.*?)/favorites(?:$|\?)`', function ($userId) {

    $controller = new \DZR\Application\Controller\User();
    $controller->inject('datasource', $this->get('datasource'));

    $playlist = $controller->getPlaylist($userId, 'FAVORITE');


    if ($playlist) {

        $this->sendJSONResponse($playlist);
    } else {
        $this->sendJSONResponse(array(
            'message' => 'No favorites playlist for user "' . $userId . '"'
        ), \DZR\Response::NOT_FOUND);
    }
});





$application->route('`/playlist/(.+?)/add-song(?:$|\?)`', function ($playlistId) {

    $songId=$_POST['songId'];

    $controller = new \DZR\Application\Controller\Playlist();
    $controller->inject('datasource', $this->get('datasource'));

    $playlist = $controller->addSongToPlaylist($playlistId, $songId);

    if ($playlist) {
        $this->sendJSONResponse($playlist);
    } else {
        $this->notFound();
        $this->sendJSONResponse(array(
            'message' => 'Failed to add song (id  ' . $songId . ') to play-list (id ' . $playlistId . ')'
        ));
    }
}, array('POST'));


$application->route('`/playlist/(.+?)/remove-song/(.*?)(?:$|\?)`', function ($playlistId, $songId) {


    $controller = new \DZR\Application\Controller\Playlist();
    $controller->inject('datasource', $this->get('datasource'));

    $playlist = $controller->removeSongFromPlaylist($playlistId, $songId);

    if ($playlist) {
        $this->sendJSONResponse($playlist);
    } else {
        $this->notFound();
        $this->sendJSONResponse(array(
            'message' => 'Failed to remove song (id  ' . $songId . ') to play-list (id ' . $playlistId . ')'
        ));
    }
}, array('DELETE'));




//=======================================================
//=======================================================


$application->route('`/song/(.*?)/info(?:$|\?)`', function ($songId) {
    $controller = new \DZR\Application\Controller\Song();
    $controller->inject('datasource', $this->get('datasource'));
    $song = $controller->getInfoById($songId);

    if ($song) {
        $this->sendJSONResponse($song);
    } else {
        $this->sendJSONResponse(array(
            'message' => 'No song with id "' . $songId . '"'
        ));
    }
});


$application->route('`/song/search\?q=(.*)`', function ($search) {



    $controller = new \DZR\Application\Controller\Song();
    $controller->inject('datasource', $this->get('datasource'));
    $songs = $controller->search($search);

    if ($songs) {
        $this->sendJSONResponse($songs);
    } else {
        $this->sendJSONResponse(array(
            'message' => 'No song for search "' . $search . '"'
        ));
    }
});



//=======================================================
//=======================================================


$application->route('`/album/(.*?)/info(?:$|\?)`', function ($songId) {
    $controller = new \DZR\Application\Controller\Album();
    $controller->inject('datasource', $this->get('datasource'));
    $album = $controller->getInfoById($songId);

    if ($album) {
        $this->sendJSONResponse($album);
    } else {
        $this->sendJSONResponse(array(
            'message' => 'No song with id "' . $songId . '"'
        ));
    }
});


//=======================================================
//=======================================================


$application->route('`/artist/(.*?)/info(?:$|\?)`', function ($artisteId) {
    $controller = new \DZR\Application\Controller\Artist();
    $controller->inject('datasource', $this->get('datasource'));
    $artist = $controller->getInfoById($artisteId);

    if ($artist) {
        $this->sendJSONResponse($artist);
    } else {
        $this->sendJSONResponse(array(
            'message' => 'No artist with id "' . $artisteId . '"'
        ));
    }
});

$application->route('`/artist/(.*?)/albums(?:$|\?)`', function ($artisteId) {
    $controller = new \DZR\Application\Controller\Artist();
    $controller->inject('datasource', $this->get('datasource'));
    $albums = $controller->getAlbums($artisteId);

    if ($albums) {
        $this->sendJSONResponse($albums);
    } else {
        $this->sendJSONResponse(array(
            'message' => 'No artist with id "' . $artisteId . '"'
        ));
    }
});

$application->route('`/artist/search\?q=(.*)`', function ($searchArtist) {
    $controller = new \DZR\Application\Controller\Artist();
    $controller->inject('datasource', $this->get('datasource'));
    $songs = $controller->searchSongsByArtist($searchArtist);

    if ($songs) {
        $this->sendJSONResponse($songs);
    } else {
        $this->sendJSONResponse(array(
            'message' => 'No song founded for artist "' . $searchArtist . '"'
        ));
    }
});









$application->route('`(?:www/(?:$|\?))|(?:api\.php(?:$|\?))`', function () {

    $this->sendJSONResponse(array(
        'message' => 'Welcome to the DZR API',
        'api' => array(
            'user' => array(
                '[api.php?]/user/{userId}/info' => array(
                    'description' => 'HTTP GET. Get user info by ID',
                    'exemple' => 'api.php/user/041e69294f0093ed9b5f0fc3950030425964afaec10276.573/info'
                ),
                '[api.php?]/user/{userId}/favorite' => array(
                    'description' => 'HTTP GET. Get user favorite songs play-list',
                    'exemple' => 'api.php/user/041e69294f0093ed9b5f0fc3950030425964afaec10276.573/favorites'
                )
            ),
            'song' => array(
                '[api.php?]/song/{songId}/info' => array(
                    'description' => 'HTTP GET. Get song informations by ID',
                    'exemple' => 'api.php/song/041e69294f0093ed9b5f0fc3950030425964daafcd1677.670/info'
                ),
                '[api.php?]/song/search?q={search}' => array(
                    'description' => 'HTTP GET. Search song',
                    'exemple' => 'api.php/song/search?q=hello'
                ),
            ),
            'album' => array(
                '[api.php?]/album/{albumId}/info' => array(
                    'description' => 'HTTP GET. Get album informations by ID',
                    'exemple' => 'api.php/album/041e69294f0093ed9b5f0fc3950030425964daaae26b79.538/info'
                ),
                '[api.php?]/song/search?q={search}' => array(
                    'description' => 'HTTP GET. Search song',
                    'exemple' => 'api.php/song/search?q=hello'
                ),
            ),
            'playlist' => array(
                '[api.php?]/playlist/{playlistId}/add-song' => array(
                    'description' => 'HTTP POST. Add song to a playlist',
                    'parameters'=>array(
                        'songId'=>"ID of the song to add"
                    ),
                    'exemple' => 'api.php/http://127.0.0.1/__divers/dzr/source/Application/www/api.php/playlist/041e69294f0093ed9b5f0fc3950030425964afaec10276.573/add-song'
                ),
                '[api.php?]/song/search?q={search}' => array(
                    'description' => 'HTTP GET. Search song',
                    'exemple' => 'api.php/song/search?q=hello'
                ),
            ),






        )
    ));
});


$application->route('`.*`', function () {
    $this->sendJSONResponse(array(
        'message' => 'No route available for URI "' . $this->request->getURI() . '"',
    ), \DZR\Response::NOT_FOUND);

});


$request = new \DZR\Request();
try {
    $application->run($request);
} catch (Exception $exception) {
    $application->sendJSONResponse(array(
        'message' => $exception->getMessage(),
    ), \DZR\Response::INTERNAL_SERVER_ERROR);
}
