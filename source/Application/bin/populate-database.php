<?php

require(__DIR__ . '/../bootstrap.php');

$urls = array(
    'https://api.deezer.com/search?q=dire%20strait',
    'https://api.deezer.com/search?q=hans%20zimmer',
    'https://api.deezer.com/search?q=oldelaf',
    'https://api.deezer.com/search?q=renaud',
    'https://api.deezer.com/search?q=chopin',
    'https://api.deezer.com/search?q=brassens',
    'https://api.deezer.com/search?q=movie',
    'https://api.deezer.com/search?q=artist:%22ska%20p%22',
    'https://api.deezer.com/search?q=am',
    'https://api.deezer.com/search?q=em',
    'https://api.deezer.com/search?q=artist:%22telephone%22',
    'https://api.deezer.com/search?q=artist:%22bowie%22',
    'https://api.deezer.com/search?q=artist:%22cyndi%20lauper%22',
);


function handleList($json, $datasource)
{
    foreach ($json->data as $descriptor) {


        $artist = new \DZR\Application\Model\Artist($datasource);
        $artist->setValue('name', $descriptor->artist->name);

        if (!$artist->exists()) {
            $artist->setValue('data', json_encode($descriptor->artist));
            $artist->store();
        }

        $album = new \DZR\Application\Model\Album($datasource);
        $album->setValue('title', $descriptor->album->title);
        $album->setArtist($artist);
        if (!$album->exists()) {
            echo "INSERT ALBUM \t".$album->getValue('title'), "\n";
            $album->setValue('data', json_encode($descriptor->album));
            $album->store();
        }



        $song = new \DZR\Application\Model\Song($datasource);
        $song->setValue('title', $descriptor->title);
        $song->setArtist($artist);

        if (!$song->exists()) {
            unset($descriptor->album);
            unset($descriptor->artist);
            $song->setValue('duration', $descriptor->duration);
            $song->setValue('data', json_encode($descriptor));
            $song->store();
            echo "\tINSERT\t".$song->getValue('title'), "\n";
        }
        else {
            echo "SKIP\t".$song->getValue('title'), "\n";
        }

        $albumSong=new \DZR\Application\Model\Album_Song($datasource);
        $albumSong->setAlbum($album);
        $albumSong->setSong($song);
        if(!$albumSong->exists()) {
            echo "ASSOC\t".$song->getValue('title')."\t".$album->getValue('title'), "\n";
            $albumSong->store();
        }
        else {
            echo "SKIP ASSOC";
        }

    }

}


foreach ($urls as $url) {
    $next = true;

    while ($next) {
        $buffer = file_get_contents($url);
        $json = json_decode($buffer);

        handleList($json, $datasource);
        if (!isset($json->next)) {
            $next = false;
        } else {
            $url = $json->next;
        }
    }


}

