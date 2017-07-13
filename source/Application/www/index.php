<doctype html>
    <html>
    <head>
        <title>My Deezer en Dix heures</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"/>
        <link rel="stylesheet" href="css/layout.css"/>
        <link rel="stylesheet" href="css/global.css"/>
    </head>
    <body>





    <div id="dz-root"></div>


    <div id="container">
        <div id="player"></div>
        <div>
            <div id="playlist"></div>
            <div id="search"></div>
        </div>
        <div style="clear:both;">
            <div id="control">

                <!--
                <i class="fa fa-backward" aria-hidden="true"></i> |
                <i class="fa fa-play" aria-hidden="true"></i> |
                <i class="fa fa-pause" aria-hidden="true"></i> |
                <i class="fa fa-forward" aria-hidden="true"></i>
                //-->

            </div>
            <!--
            <div style="">
                My Deezer en dix heures
            </div>
            //-->
        </div>
    </div>





    <script src="http://e-cdn-files.deezer.com/js/min/dz.js"></script>
    <script src="javascript/Configuration.js"></script>
    <script src="javascript/Player.js"></script>
    <script src="javascript/Playlist.js"></script>
    <script src="javascript/Song.js"></script>

    <script src="javascript/SearchBox.js"></script>
    <script src="javascript/Control.js"></script>





    <script>

        var player=new Player();
        player.initialize(configuration, function() {
            var playlist=new Playlist(player);
            playlist.initialize(configuration.playlist);
            playlist.render(document.getElementById('playlist'))

            var searchBox=new SearchBox(playlist, configuration);
            searchBox.render(document.getElementById('search'));

            var controlBar=new Control(playlist);
            controlBar.render(document.getElementById('control'));

            player.setPlaylist(playlist);
        });




    </script>



    </body>
    </html>
