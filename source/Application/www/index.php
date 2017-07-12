<doctype html>
    <html>
    <head>
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
        <div style="clear:both; font-family: sans-serif; font-weight:bold; color: #666; border-top:solid 1px #666; margin-top:16px; padding-top: 16px; text-align: right; font-style:italic; text-transform: uppercase">
            My Deezer en dix heures
        </div>
    </div>












    <script src="http://e-cdn-files.deezer.com/js/min/dz.js"></script>
    <script src="javascript/Configuration.js"></script>
    <script src="javascript/Player.js"></script>
    <script src="javascript/Playlist.js"></script>
    <script src="javascript/Song.js"></script>

    <script src="javascript/SearchBox.js"></script>





    <script>

        var player=new Player();
        player.initialize(configuration, function() {
            var playlist=new Playlist(player);
            playlist.initialize(configuration.playlist);
            playlist.render(document.getElementById('playlist'))

            var searchBox=new SearchBox(playlist, configuration);
            searchBox.render(document.getElementById('search'));

            player.setPlaylist(playlist);
        });




    </script>



    </body>
    </html>
