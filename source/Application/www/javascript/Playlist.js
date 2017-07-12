function Playlist(player) {
    this.player = player;

    this.getSongsURL = null;
    this.addSongURL = null;
    this.removeSongURL = null;

    this.container = null;
    this.element = null;

    this.songs = {};

    this.currentSong = null;
}

Playlist.prototype.play = function (song) {

    if (this.currentSong) {
        this.currentSong.blur();
    }

    this.currentSong = song;
    song.focus();
    this.player.play(song);
};

Playlist.prototype.initialize = function (configuration) {
    this.getSongsURL = configuration.getSongsURL;
    this.addSongURL = configuration.addSongURL;
    this.removeSongURL = configuration.removeSongURL;
};


Playlist.prototype.render = function (container) {
    this.container = container;
    this.element = document.createElement('div');
    this.element.className = 'playlist';
    this.container.appendChild(this.element);

    this.load();
};


Playlist.prototype.playNextSong = function () {

    if (this.currentSong) {


        this.currentSong.blur();

        if (song = this.currentSong.getNextSong()) {
            this.play(song);
        }
    }
};

Playlist.prototype.load = function () {

    this.ajax({
        "method": 'GET',
        "url": this.getSongsURL,
        "success": function (response) {

            var list = JSON.parse(response);

            var lastSong = null;

            for (var songId in list.songs) {

                var song = new Song(list.songs[songId]);
                song.attachToPlayList(this);
                song.onClick = function () {
                    song.playlist.play(this)
                };

                this.songs[song.getId()] = song;
                song.render(this.element);

                if (lastSong) {
                    lastSong.setNextSong(song);
                }

                lastSong = song;
            }
            this.player.playMany(this.songs)

        }.bind(this)
    })
};


Playlist.prototype.removeSong = function (song) {

    this.ajax({
        method: 'DELETE',
        url: this.removeSongURL + '/' + song.getId(),
        data: 'songId=' + song.descriptor.id,
        success: function (response) {

        }
    });

    delete(this.songs[song.getId()]);
    song.delete();

};


Playlist.prototype.addSong = function (song) {

    this.ajax({
        method: 'POST',
        url: this.addSongURL,
        data: 'songId=' + song.descriptor.id,
        success: function (response) {
        }
    });

    this.songs[song.getId()] = song;


    for(var id in this.songs) {
        var lastSong=this.songs[id];
    }

    if(lastSong) {
        lastSong.setNextSong(song);
    }




    song.attachToPlayList(this);
    song.render(this.element);
    song.onClick = function () {
        song.playlist.play(this)
    };

};


Playlist.prototype.ajax = function (options) {

    var xhr = new XMLHttpRequest();
    xhr.open(options.method, options.url);
    xhr.onload = function () {
        if (xhr.status === 200) {
            options.success(xhr.responseText);
        }
        else {
            options.fail(xhr.responseText);
        }
    };


    if (options.method == 'POST') {
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    }

    if (typeof(options.data) !== 'undefined') {
        xhr.send(encodeURI(options.data));
    }
    else {
        xhr.send();
    }

};