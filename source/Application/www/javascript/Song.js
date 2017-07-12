function Song(descriptor) {
    this.playlist = null;
    this.nextSong = null;

    this.descriptor = descriptor;

    this.dzrSongDescriptor = JSON.parse(descriptor.data);
    this.dzrArtistDescriptor = JSON.parse(descriptor.artist.data);

    this.onClick = function () {
    };

}


Song.prototype.getId = function () {
    return this.descriptor.id;
};


Song.prototype.attachToPlayList = function (playlist) {
    this.playlist = playlist;
};

Song.prototype.removeFromPlaylist = function () {
    this.playlist.removeSong(this);
};


Song.prototype.getDzrID = function () {
    return this.dzrSongDescriptor.id;
};

Song.prototype.delete = function () {
    this.container.removeChild(this.element);
};

Song.prototype.render = function (container) {


    this.container = container;

    this.element = document.createElement('div')
    this.element.className = 'song';


    this.trigger = document.createElement('button');



    if(this.descriptor.albums.length) {
        var album=this.descriptor.albums[0];
        var data=JSON.parse(album.data);
        var picture=data.cover_small;
    }
    else {
        var picture=this.dzrArtistDescriptor.picture;
    }



    this.trigger.innerHTML =
        '<img src="' + picture + '"/>' +
        '<div class="titme">' + this.descriptor.title + '</div><div class="artist">' + this.descriptor.artist.name + '</div>';

    this.trigger.onclick = function () {
        this.onClick(this)
    }.bind(this);

    this.element.appendChild(this.trigger);

    this.deleteTrigger = document.createElement('button');
    this.deleteTrigger.className = 'delete';
    this.deleteTrigger.innerHTML = '<i class="fa fa-trash" aria-hidden="true"></i>'
    this.deleteTrigger.onclick = function () {
        this.removeFromPlaylist();
    }.bind(this);
    this.element.appendChild(this.deleteTrigger);


    this.addTrigger = document.createElement('button');
    this.addTrigger.className = 'add';
    this.addTrigger.innerHTML = '<i class="fa fa-check" aria-hidden="true"></i>';

    this.addTrigger.onclick = function () {
        this.delete();
        this.playlist.addSong(this);
    }.bind(this);

    this.element.appendChild(this.addTrigger);


    this.container.appendChild(this.element)
};


Song.prototype.focus=function() {
    this.element.className='song active';
};

Song.prototype.blur=function() {
    this.element.className='song';
};




Song.prototype.setNextSong = function (song) {
    this.nextSong = song;
};

Song.prototype.getNextSong = function () {
    return this.nextSong;
};