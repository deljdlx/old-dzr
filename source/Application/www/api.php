<?php

require(__DIR__ . '/../bootstrap.php');


/*
$user=new \DZR\Application\Model\User($datasource);
$user->loadById(1);
$user->loadPlaylists();

foreach ($user->getPlayLists() as $playlist) {
    echo '<pre id="' . __FILE__ . '-' . __LINE__ . '" style="border: solid 1px rgb(255,0,0); background-color:rgb(255,255,255)">';
    echo '<div style="background-color:rgba(100,100,100,1); color: rgba(255,255,255,1)">' . __FILE__ . '@' . __LINE__ . '</div>';
    print_r($playlist->jsonSerialize());
    echo '</pre>';
}
*/

/*
$playlist=new \DZR\Application\Model\Playlist($datasource);
$playlist->loadById(1);

$songs=$playlist->getSongs();
$playlist->removeSong($songs[2]);
*/


//die('EXIT '.__FILE__.'@'.__LINE__);

//$playlist->addSong($song);


/*
$song=new \DZR\Application\Model\Song($datasource);
$song->setValue('name', 'Exit Music for a film');
$song->setValue('duration',  120);
$song->store();
*/

/*
$song=new \DZR\Application\Model\Song($datasource);
$song->loadById(2);

$playlist=new \DZR\Application\Model\Playlist($datasource);
$playlist->loadById(1);
$playlist->addSong($song);
*/

/*
$user=new \DZR\Application\Model\User($datasource);
$user->loadById(1);
$playlist->setUser($user);
$playlist->store();
die('EXIT '.__FILE__.'@'.__LINE__);
*/


/*
$user=new \DZR\Application\Model\User($datasource);
$user->setValue('email', 'ju.delsescaux@gmail.com');
$user->store();
*/


/*
$album=new \DZR\Application\Model\Album($datasource);
$album->loadById('041e69294f0093ed9b5f0fc3950030425964c07499e2b3.448');
$songs=$album->getSongs();
echo '<pre id="' . __FILE__ . '-' . __LINE__ . '" style="border: solid 1px rgb(255,0,0); background-color:rgb(255,255,255)">';
echo '<div style="background-color:rgba(100,100,100,1); color: rgba(255,255,255,1)">' . __FILE__ . '@' . __LINE__ . '</div>';
print_r($songs);
echo '</pre>';
die('EXIT '.__FILE__.'@'.__LINE__);
*/


/*
$song=new \DZR\Application\Model\Song($datasource);
$song->loadById('041e69294f0093ed9b5f0fc3950030425964c185c94bb2.391');

echo '<pre id="' . __FILE__ . '-' . __LINE__ . '" style="border: solid 1px rgb(255,0,0); background-color:rgb(255,255,255)">';
echo '<div style="background-color:rgba(100,100,100,1); color: rgba(255,255,255,1)">' . __FILE__ . '@' . __LINE__ . '</div>';
print_r($song->getAlbums());
echo '</pre>';
die('EXIT '.__FILE__.'@'.__LINE__);

*/

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





$application->route('`/playlist/(.+?)/add-song/(.+?)(?:$|\?)`', function ($playlistId, $songId) {
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
}, array('POST', 'GET'));


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
            )

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
