<doctype html>
    <html>
    <head>

    </head>
    <body>


    <div id="dz-root"></div>
    <div id="player"></div>
    <script src="http://e-cdn-files.deezer.com/js/min/dz.js"></script>


    <script>
        /*
        DZ.init({
            appId: '242662',
            channelUrl: 'http://127.0.0.1/__divers/dzr/source/Application/www/index.php/channel',
            player: {
                container: 'player',
                width: 300,
                height: 300,
                format: 'square',
                onload: function () {
                }
            }
        });
        */

        DZ.init({
            appId  : '242662',
            channelUrl : 'http://127.0.0.1/__divers/dzr/source/Application/www/index.php/channel',
            player : {
                container : 'player',
                cover : true,
                playlist : true,
                width : 650,
                height : 300,
                onload : function() {

                }
            }
        });

    </script>


    <script>
        // Then, request the user to log in
        DZ.login(function (response) {
            if (response.authResponse) {
                console.log('Welcome!  Fetching your information.... ');
                DZ.api('/user/me', function (response) {
                    console.log('Good to see you, ' + response.name + '.');
                });
            } else {
                console.log('User cancelled login or did not fully authorize.');
            }
        }, {perms: 'basic_access,email'});
    </script>


    </body>
    </html>
