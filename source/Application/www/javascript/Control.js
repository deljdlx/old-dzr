function Control(playlist)
{
    this.playlist=playlist;

}


Control.prototype.render=function(container) {
    this.container=container

    this.element=document.createElement('div');
    this.element.className='control';




    this.previousTrigger=document.createElement('i');
    this.previousTrigger.className='trigger fa fa-backward';
    this.previousTrigger.onclick=function() {
        this.playlist.backward();
    }.bind(this);
    this.element.appendChild(this.previousTrigger);


    this.playTrigger=document.createElement('i');
    this.playTrigger.className='trigger fa fa-play';
    this.playTrigger.onclick=function() {
        this.playlist.play();
    }.bind(this);
    this.element.appendChild(this.playTrigger);


    this.pauseTrigger=document.createElement('i');
    this.pauseTrigger.className='trigger fa fa-pause';
    this.pauseTrigger.onclick=function() {
        this.playlist.pause();
    }.bind(this);
    this.element.appendChild(this.pauseTrigger);


    this.nextTrigger=document.createElement('i');
    this.nextTrigger.className='trigger fa fa-forward';
    this.nextTrigger.onclick=function() {
        this.playlist.forward();
    }.bind(this);
    this.element.appendChild(this.nextTrigger);





    this.container.appendChild(this.element);

};