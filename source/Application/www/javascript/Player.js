function Player() {
    this.playlist = null;
}

Player.prototype.setPlaylist = function (playlist) {
    this.playlist = playlist;
};


Player.prototype.play = function (song) {
    DZ.player.playTracks([song.getDzrID()]);
};

Player.prototype.playMany = function (songs) {
    var idList = [];
    for (var i = 0; i < songs.length; i++) {
        idList.push(songs[i].getDzrID());
    }
    DZ.player.playTracks(idList);
};


Player.prototype.initialize = function (configuration, onLoad) {
    DZ.init({
        appId: configuration.applicationId,
        channelUrl: configuration.channelURL,
        player: {
            container: 'player',
            cover: true,
            playlist: true,
            width: 650,
            height: 300,
            onload: function () {
                onLoad(this);
            }.bind(this)
        }
    });


    DZ.Event.subscribe('track_end', function (evt_name) {
        this.playlist.playNextSong();
    }.bind(this));


};


Player.prototype.login = function () {
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
};