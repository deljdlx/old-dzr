<?php

require(__DIR__.'/../bootstrap.php');





$application->route('`/channel`', function () {
    $cache_expire = 60*60*24*365;
    header("Pragma: public");
    header("Cache-Control: maxage=".$cache_expire);
    header('Expires: ' . gmdate('D, d M Y H:i:s', time()+$cache_expire) . ' GMT');
    echo '<script src="http://e-cdn-files.deezer.com/js/min/dz.js"></script>';
});


$application->route('`.*`', function () {
    $this->notFound();
    $this->sendJSONResponse(array(
        'message'=>'No route available for URI "'.$this->request->getURI().'"'
    ));
});






$request = new \DZR\Request();
$application->run($request);