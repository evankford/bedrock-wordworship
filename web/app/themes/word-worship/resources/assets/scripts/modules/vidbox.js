import * as basicLightbox from 'basiclightbox'

function YouTubeGetID(url) {
  var ID = '';
  url = url.replace(/(>|<)/gi, '').split(/(vi\/|v=|\/v\/|youtu\.be\/|\/embed\/)/);
  if (url[2] !== undefined) {
    ID = url[2].split(/[^0-9a-z_\-]/i);
    ID = ID[0];
  }
  else {
    ID = url;
  }
  return ID;
}


function vimeoGetID() {

}

export default class VidBox {

  constructor(el) {
    this.el = el;
    this.target= this.el.querySelector('[data-vidbox-video]')
    this.type = this.checkForType();

    //Check if lightbox is appropriate here
    this.initLightbox();

    if (this.type == 'youtube') {
      this.createYoutube();
    } else if (this.type == 'vimeo') {
      this.createVimeo();
    }
    console.log(this);
  }

  createVimeo() {
    //Anything
  }


  checkForType() {
    var rawType = this.el.getAttribute('data-vidbox-type');
    if (rawType == 'URL') {
      var vidId = this.target.getAttribute('data-vidbox-video');
      var realId = '';
      if (vidId.indexOf('//yout') > 0 || vidId.indexOf('.yout') > 0) {
        realId = YouTubeGetID(vidId)
        rawType = 'youtube';
      } else if (vidId.indexOf('//vim') > 0 || vidId.indexOf('.vim') > 0) {
        realId = vimeoGetID(vidId)
        rawType = 'vimeo';
      }
    }
    if (realId) {
      this.vidId = realId;
      return rawType
    } else {
      return false;
    }
  }

  initLightbox() {
    if (this.type == 'youtube') {
      this.lightbox = basicLightbox.create('<div class="iframe-wrap"><iframe src="https://www.youtube.com/embed/' + this.vidId + '?autoplay=1&rel=0" allowfullscreen  playsinline muted frameborder="0" frameborder="0" ></iframe></div>');
      this.lightboxWatchers();
    } else if (this.type == 'vimeo') {
      this.lightbox = basicLightbox.create('<div class="iframe-wrap"><iframe src="https://www.youtube.com/embed/' + this.vidId + '?autoplay=1&rel=0" allowfullscreen playsinline muted  frameborder="0" frameborder="0" ></iframe></div>');
      this.lightboxWatchers();
    } else {
      this.lightbox = false;
    }
  }

  lightboxWatchers() {
    var self = this;
    var buttons = self.el.parentNode.parentNode.querySelectorAll('[data-lightbox-button]');
    console.log(buttons)
    buttons.forEach(button => {
      console.log(button);
      button.addEventListener('click', (e) => {
        e.preventDefault();
        self.lightbox.show()
      });
    })
  }

  createYoutube() {
    var self = this;
    var tag = document.createElement('script');
    tag.src = 'https://www.youtube.com/iframe_api';
    var firstScriptTag = document.getElementsByTagName('script')[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
    let playerWrap = this.el;
    let startTime = 0;
    if (self.el.getAttribute('data-start-time') > 0) {
      startTime = Math.max(0, self.el.getAttribute('data-start-time'));
    }
    const vars = {
      'rel': 0,
      'showinfo': 0,
      'modestBranding': 1,
      // 'loop': 1,
      'start': startTime,
      'playsinline': 1,
      'enablejsapi': 1,
      'disablekb': 1,
      'controls': 0,
      'autoplay': 1,
    }

    self.player = '';
    window.onYouTubeIframeAPIReady = function () {

      self.player = new window.YT.Player(self.target, {
        height: '600',
        width: '1200',
        videoId: self.vidId,
        playerVars: vars,
        events: {
          'onReady': onPlayerReady,
          'onStateChange': onPlayerStateChange,
        },
      });
    }

    var checkCount = 0;
    function checkIfPlaying() {

      var state = self.player.getPlayerState();

      // playerWrap.classList.add('use-vid');
      if (checkCount > 12 && state != 1) {
        playerWrap.classList.add('use-gif');
        if (window.innerWidth <= 800) {
          playerWrap.classList.add('use-gif');
          playerWrap.classList.add('small');
        }
        return false;
      }
      if (state == 5 || state == 3 || state == -1) {
        checkCount++;
        if (state == 5) {
          checkCount++
        }
        self.player.mute();

        if (startTime > 0) {
          self.player.seekTo(startTime)
        } else {

          self.player.playVideo();
        }
        setTimeout(checkIfPlaying, 200);
      }
      if (state == 1) {
        playerWrap.classList.add('use-vid');
        return true;
      }
      // if (state == -1)
      //     playerWrap.classList.add('use-gif');
      //   if (window.innerWidth <= 800) {
      //     playerWrap.classList.add('small');
      //   }
      //   return false;
    }

    function onPlayerReady(event) {

      event.target.mute();
      self.player.mute();

      self.player.playVideo();

      // if (startTime > 0) {
      //   self.player.seekTo(startTime)
      // }
      setTimeout(checkIfPlaying, 50)

    }

    function onPlayerStateChange(event) {
      if (event.data == window.YT.PlayerState.ENDED) {
        self.player.playVideo();
      }
    }
  }
}