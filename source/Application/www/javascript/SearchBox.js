function SearchBox(playlist, configuration) {
    this.playlist = playlist;
    this.searchURL = configuration.searchURL;
    this.searchByArtistURL = configuration.searchByArtistURL;
    this.searching = false;

    this.songs = [];
}

SearchBox.prototype.render = function (container) {

    this.container = container;
    this.element = document.createElement('div');

    this.element.className = 'searchBox';


    this.input = document.createElement('input');
    this.input.setAttribute('placeholder', 'Recherche');

    this.input.onkeyup = function () {

        if (this.input.value.length > 3) {
            this.search(this.input.value);
        }
    }.bind(this);

    this.element.appendChild(this.input);

    this.list = document.createElement('div');
    this.list.className = 'list';
    this.element.appendChild(this.list);

    this.container.appendChild(this.element);
};


SearchBox.prototype.search = function (value) {
    if (!this.searching) {

        this.searching = true;
        this.list.innerHTML = '';

        var playlist = this.playlist;


        this.ajax({
            method: 'GET',
            url: this.searchURL + value,
            success: function (response) {
                var list = JSON.parse(response);

                for (var i = 0; i < list.length; i++) {
                    var song = new Song(list[i]);
                    song.attachToPlayList(playlist);
                    song.onClick = function () {
                        playlist.play(this);
                        //playlist.addSong(this);
                    }
                    song.render(this.list);
                }
                this.searching = false;
            }.bind(this)
        })

        this.ajax({
            method: 'GET',
            url: this.searchByArtistURL + value,
            success: function (response) {
                var list = JSON.parse(response);

                for (var i = 0; i < list.length; i++) {
                    var song = new Song(list[i]);
                    song.attachToPlayList(playlist);
                    song.onClick = function () {
                        playlist.play(this);
                        //playlist.addSong(this);
                    }
                    song.render(this.list);
                }
                this.searching = false;
            }.bind(this)
        })

    }
}


SearchBox.prototype.ajax = function (options) {

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
    xhr.send();
}