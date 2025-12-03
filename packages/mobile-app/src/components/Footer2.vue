<template>
  <div class="footer">
    <GDialog v-model="this.loginDialog" max-width="500" >
      <div class="wrapper" style="">
        <div class="content">
          <div style="width: 100%;text-align: center">
            <img style="width:85px " src="../assets/images/needlogin.png">
          </div>
          <div style="width: 100%;text-align: center;font-size: 18px;font-weight: bold;padding: 10px">{{$t('General.loginApplication')}}</div>

          <p style="width: 100%;text-align: center;font-size: 14px;padding: 10px 0 10px 0">
           {{$t('General.loginApplicationDesc')}}
          </p>
        </div>
      </div>
      <div class="row" style="padding: unset;margin-top: 15px ">
        <div @click="this.$router.push({ path: '/mobile' });" style="width: 50%;text-align: center;background: var(--va-basecolor);padding: 10px 0 10px 0" class="modallogin"> {{$t('General.loginApplicationBtn')}}</div>
        <div @click="this.loginDialog=false" style="width: 50%;text-align: center;background: #dddddd;padding: 10px 0 10px 0" class="modalcancel">{{$t('General.loginApplicationCancel')}}</div>
      </div>
    </GDialog>
    <RingBottomNavigation
        :border-color="this.basecolor"
        :title-color="this.basecolor"
        style="position: absolute !important;background: white"
        :foreground-color="this.basecolor"
        :badge-color="this.basecolor"
        background-color='#FFFFFF'
        :icon-color="this.basecolor"
        replaceRoute="true"
        :options="options" v-model="this.selected_num" @click="this.footerAction(this.selected_num)">
      <template @click="this.footerAction(this.selected_num)" #icon="{ props }" style="margin-bottom: 20px">
        <font-awesome-icon   :icon="props.icon" size="15px"  :style="{ color: props.iconColor }"/>
      </template>
      <template #title="{ props }">
        <p>{{ props.title }}</p>
      </template>
    </RingBottomNavigation>
  </div>







</template>
<script>
import { library } from '@fortawesome/fontawesome-svg-core'
import {faHouse ,faFolderPlus,faVolumeLow,faHeart,faHeadset,faPlay} from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { CurvedBottomNavigation,RingBottomNavigation } from "bottom-navigation-vue";
import "bottom-navigation-vue/dist/style.css";
library.add(faHouse,faFolderPlus,faVolumeLow,faHeart,faHeadset,faPlay)
import { useToast } from 'vuestic-ui'
// main.js
import 'gitart-vue-dialog/dist/style.css'
import { GDialog } from 'gitart-vue-dialog'
import {mapWritableState} from 'pinia';
import {useTempStroe} from '@/stores/tempStore';
export default {
name: "Footer2.vue",
  components: {
   FontAwesomeIcon,CurvedBottomNavigation,RingBottomNavigation,useToast,GDialog
  },
  computed: {
    ...mapWritableState(useTempStroe, ["selected_num"])
  },
  methods: {
    goToPath(ii){
      if(ii===1){
        this.$router.push({ path: '/support' });
      }
      else if(ii===2){
        this.$router.push({ path: '/fav' })
      }
      else if(ii===3){
        // this.goToPath();
        this.$router.push({ path: '/' });
      }
      else if(ii===4){
        this.$router.push({ path: '/channel' })
      }
      else if(ii===5){
        this.$router.push({ path: '/mycourses' })
      }
      return true;
    },
    footerAction(ii) {
      if(ii===2 || ii===5){
        if(localStorage.getItem('tk')==="" || localStorage.getItem('tk')===null){
          this.loginDialog=true;
          this.selected_num=3;
          return;
        }
      }
      var self = this;
      setTimeout(function () { self.goToPath(ii) } , 300)
      // setTimeout(this.chch(ii), 950);
    },
  },
  data(){
    return{
      loginDialog:false,
      options: [
        {
          id: 1,
          icon: "fa-solid fa-headset",
          title:this.$t('Footer.support'),
        },
        {
          id: 2,
          icon: "fa-solid fa-heart",
          title:this.$t('Footer.favorites')
        },
        {
          id: 3,
          icon: "fa-solid fa-house",
          title: this.$t('Footer.home'),
        },
        {
          id: 4,
          icon: "fa-solid fa-volume-low",
          title: this.$t('Footer.educational')
        },
        {
          id: 5,
          icon: "fa-solid fa-folder-plus",
          title: this.$t('Footer.myCourses'),
        },
      ],
    }
  }
}
</script>
<style>
.unchecked{
  position: unset !important;
}
.checked > .btn-title{
  visibility: unset !important;
  top: 42px;
  color: #636363 !important;
  font-weight: bold !important;
  font-size: 10px;
}.unchecked > .btn-title{
  visibility: unset !important;
  top: 42px;
  font-size: 9px;
  font-weight: lighter !important;
  color: #a3a3a3 !important;
}
</style>