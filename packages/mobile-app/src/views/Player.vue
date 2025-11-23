<template>
  <Artplayer @get-instance="getInstance" :option="option" :style="style" />
</template>

<script>
import Artplayer from "../components/Artplayer.vue";

export default {
  data() {
    return {
      option: {
        url: "https://artplayer.org/assets/sample/video.mp4",
        title: this.appname_en,
        poster: 'https://pwa.vipmind-app.ir/img/okorder.7dec3ea8.png',
        volume: 0.5,
        isLive: false,
        muted: false,
        autoplay: false,
        pip: false,
        autoSize: true,
        autoMini: true,
        screenshot: false,
        setting: true,
        loop: true,
        flip: false ,
        playbackRate: true,
        aspectRatio: true,
        fullscreen: true,
        fullscreenWeb: true,
        subtitleOffset: false,
        miniProgressBar: true,
        mutex: true,
        backdrop: true,
        playsInline: true,
        autoPlayback: true,
        airplay: true,
        theme: this.basecolor,
        lang: navigator.language.toLowerCase(),
        whitelist: ['*'],
        moreVideoAttr: {
          crossOrigin: 'anonymous',
        },
        settings: [

        ],
        // contextmenu: [
        //   {
        //     html: 'Custom menu',
        //     click: function (contextmenu) {
        //       console.info('You clicked on the custom menu');
        //       contextmenu.show = false;
        //     },
        //   },
        // ],
        // controls: [
        //   {
        //     position: 'right',
        //     html: 'Control',
        //     tooltip: 'Control Tooltip',
        //     click: function () {
        //       console.log('You clicked on the custom control');
        //     },
        //   },
        // ],

      },
      style: {
        width: "100%",
        height: "400px",
        margin: "0 auto 0",
      },
    };
  },
  components: {
    Artplayer,
  },
  methods: {
    getInstance(art) {
      console.log(art);
    },
  },
};
</script>