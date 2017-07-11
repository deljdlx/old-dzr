<?php

require(__DIR__.'/../../bootstrap.php');



//phpinfo();
//die('EXIT '.__FILE__.'@'.__LINE__);

$datasource=new \DZR\Datasource(new PDO("mysql:host=127.0.0.1.;dbname=dzr", 'root', ''));

$application = new \DZR\Application();
$application->register('datasource', $datasource);

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




$application->route('`/user/(.+?)/info(?:$|\?)`', function ($userId) {
    $controller = new \DZR\Application\Controller\User();
    $controller->inject('datasource', $this->get('datasource'));
    $user=$controller->getInfoById($userId);


    if($user->isLoaded()) {
        $this->sendJSONResponse($user);
    }
    else {
        $this->notFound();
        $this->sendJSONResponse(array(
            'message'=>'No user with id "'.$userId.'"'
        ));
    }
});

$application->route('`/user/(.*?)/playlist/favorite(?:$|\?)`', function ($userId) {
    $controller = new \DZR\Application\Controller\User();
    $controller->inject('datasource', $this->get('datasource'));

    $playlist=$controller->getFavoritePlaylist($userId);

    if($playlist->isLoaded()) {
        $this->sendJSONResponse($playlist);
    }
    else {
        $this->notFound();
        $this->sendJSONResponse(array(
            'message'=>'No favorite playlist for user  with ID "'.$userId.'"'
        ));
    }
});


$application->route('`/playlist/(.+?)/add-song/(.+?)(?:$|\?)`', function ($playlistId, $songId) {
    $controller = new \DZR\Application\Controller\Playlist();
    $controller->inject('datasource', $this->get('datasource'));

    $playlist=$controller->addSongToPlaylist($playlistId, $songId);

    if($playlist) {
        $this->sendJSONResponse($playlist);
    }
    else {
        $this->notFound();
        $this->sendJSONResponse(array(
            'message'=>'Failed to add song (id  '.$songId.') to play-list (id '.$playlistId.')'
        ));
    }
}, 'POST');




//=======================================================
//=======================================================




$application->route('`/song/(.*?)/info(?:$|\?)`', function ($songId) {
    $controller = new \DZR\Application\Controller\Song();
    $controller->inject('datasource', $this->get('datasource'));
    $song=$controller->getInfoById($songId);


    if($song->isLoaded()) {
        $this->sendJSONResponse($song);
    }
    else {
        $this->sendJSONResponse(array(
            'message'=>'No song with id "'.$songId.'"'
        ));
    }

});

$application->route('`(?:www/)|(?:index\.php)(?:$|\?)`', function () {
    $this->sendJSONResponse(array(
        'message'=>'Welcome to the DZR API',
        'api'=>array(
            'user'=>array(
                '[index.php?]/user/{userId}/info'=>array(
                    'description'=>'HTTP GET. Get user info by ID',
                    'exemple'=>'index.php/user/1/info'
                ),
                '[index.php?]/user/{userId}/favorite'=>array(
                    'description'=>'HTTP GET. Get user favorite songs play-list',
                    'exemple'=>'index.php/user/1/favorite'
                )
            ),
            'song'=>array(
                '[index.php?]/song/{songId}/info'=>array(
                    'description'=>'HTTP GET. Get song informations by ID',
                    'exemple'=>'index.php/song/1/info'
                )
            )
        )
    ));
});


$application->route('`.*`', function () {
    $this->notFound();
    $this->sendJSONResponse(array(
        'message'=>'No route available for URI "'.$this->request->getURI().'"'
    ));
});



$request = new \DZR\Request();
$application->run($request);