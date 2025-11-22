<template>
  <Header  @headeropenMenu="this.homeOpenMenu()"  :isHome="0"/>
  <SideMenu :openMenu="this.openMenu" @headercloseMenu="this.headerCloseMenu()" :group_ref="0"/>
  <Loading v-if="this.geted===1" />
  <p v-if="this.geted===2" style="margin-top:0 !important;width: 100%;padding: 50px 0 10px 0;background-color: white;text-align: center">{{this.channelName}}</p>
<div id="your_div">
  <div v-for="post in data" :key="post.ID" v-if="this.geted===2" class="mycard" style="margin:0 3% 3% 3%;font-size:14px;padding:8px ;width: auto;">
     <img v-if="post.Pic!==''" :src="post.Pic"  v-html="post.Content" style="padding: 5px;width: 100%;"/>
    <Artplayer  v-if="post.Video!==''" @get-instance="getInstance"
      :option="{url: post.Video,
          title: this.appname_en,
          poster: '/assets/sample/poster.jpg',
          volume: 0.5,
          isLive: false,
          muted: false,
          autoplay: false,
          pip: false,
          autoSize: false,
          autoMini: false,
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
          backdrop: false,
          playsInline: true,
          autoPlayback: true,
          airplay: true,
          theme: this.basecolor,
          whitelist: ['*'],
          moreVideoAttr: {
          crossOrigin: 'anonymous',
          },
          settings: [
          ],
       }"
    :style="style" :info="false" style="border-radius: 10px !important;"/>

    <audio v-if="post.Voice!==''" preload="none" webkit-playsinline playsinline controlsList="nodownload"  controls oncontextmenu="return false;" style="border-top-right-radius: 20px;border-top-left-radius: 20px;width: 100%;height: 60px">
      <source :src="post.Voice"  type="audio/mpeg" />
    </audio>
    <div v-if="post.Content!==''" v-html="post.Content" style="padding: 5px;line-height: 1.6;font-size: 14px"></div>
    <p v-html="post.Date" style="text-align: left;padding: 5px;font-size: 12px;color:#909090;direction: ltr;"></p>
  </div>
</div>
  <Footer :selected_num="4"/>
</template>
<script>
import { library } from '@fortawesome/fontawesome-svg-core'
import Loading from '../components/Loading.vue'
import Header from '../components/Header.vue'
import Footer from '../components/Footer.vue'
import SubHeader from '../components/SubHeader.vue'
import SideMenu from '../components/SideMenu.vue'
import { faCaretDown} from '@fortawesome/free-solid-svg-icons'
import { } from '@fortawesome/free-regular-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import LoadingButton from '../components/LoadingButton.vue'
import { useToast } from "vue-toastification";
import Artplayer from "../components/Artplayer.vue";
import {mapWritableState} from 'pinia';
import {useTempStroe} from '@/stores/tempStore';
library.add(faCaretDown)
export default {

  name: "Invoice",
  computed: {
    ...mapWritableState(useTempStroe, ["selected_num"])
  },
  components: {
    Loading,SideMenu,Header,SubHeader,Footer,FontAwesomeIcon,LoadingButton,Artplayer
  },
  mounted() {
    this.selected_num=4
    this.getRow();


    // var objDiv = document.getElementById("your_div");
    // objDiv.scrollTop = objDiv.scrollHeight;
  },
  updated() {
    this.scrollToBottom();
  },
  methods:{
    homeOpenMenu(){
      this.openMenu=true;
      console.log("homeOpenMenu");
    },
    headerCloseMenu(){
      this.openMenu=false;
      console.log("homeCloseMenu");
    },
    getInstance(art) {
      console.log(art);
    },
    scrollToBottom(){
      // var objDiv = document.getElementById("your_div"+100000);
      // objDiv.scrollTop = objDiv.scrollHeight;
      // console.log(objDiv.scrollHeight)
      // console.log(window.innerHeight)
      window.scrollTo(0, 900000000);
    },
    goToPage(id){
      this.$router.push({ path: '/channelpost/'+id });
    },
    getRow(){
      this.geted=1;
      const mydata = {
        channel_ref:this.$route.params.id.toString(),
        action:'channelsPost',
        lang:this.$i18n.locale,
      };
      this.$http(
          {
            method: "post",
            url: this.apiurl,
            timeout: 1000 * 30, // Wait for 5 seconds
            data: mydata,
            headers: {
              "Content-Type": "application/json",
              "Authorization": `Bearer ${localStorage.getItem('tk')}`
            },
          })
          .then((response) => {
            if(response.data.ok===1){
              this.data=response.data.data;
              this.channelName=response.data.channelName;
              this.geted=2;
              // var objDiv = document.getElementById("your_div");
              // objDiv.scrollTop = objDiv.scrollHeight;
            }
            else if(response.data.ok===3){
              localStorage.setItem('tk', "");
              this.$router.push({ path: '/mobile' })
            }
            else{
              if(response.data.ok===4){
                localStorage.setItem('tk', "");
              }
              this.geted=3;
              this.$swal({
                title: this.$t('General.error'),
                text: response.data.msg,
                icon: 'error',
                confirmButtonText:this.$t('General.ok'),
                customClass: {
                  confirmButton: 'btn btn-primary'
                },
                buttonsStyling: false
              });
            }
          })
          .catch(error => {
            this.geted = 3;
            if (error.code === 'ECONNABORTED') {
              this.errTitle = this.$t('General.receivingError');
              this.errMsg = this.$t('General.tryAgain');
              // timed out
            } else {
              this.errTitle = this.$t('General.error');
              this.errMsg = error.message;
            }

          });
    },
  },
  data(){
    return{
      geted:0,
      openMenu:false,
      formatter : new Intl.NumberFormat('en', {
        maximumFractionDigits:0,
      }),
      data:[],
      channelName:"",

      option: {

        url: "",
        title: this.appname_en,
        poster: '/assets/sample/poster.jpg',
        volume: 0.5,
        isLive: false,
        muted: false,
        autoplay: true,
        pip: false,
        autoSize: false,
        autoMini: false,
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
        backdrop: false,
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
      },
      style: {
        width: "100%",
        height: "400px",
        margin: "0",
        borderRadius:"10px 10px 0 0 !important"
      },
    }
  }
};

</script>
<style>
.img-contact{
  width: 60px;
  object-fit: contain;
}
.p-contact{
  width: 70%;
  padding: 20px 5% 0 0;
}
</style>
