<template>
  <SideMenu v-if="this.show_story===false" :openMenu="this.openMenu" @headercloseMenu="this.headerCloseMenu()" :group_ref="0" />
  <div v-if="this.show_story" style="height: 1000px;background-color: black;width: 100%" >
    <div style="width: 55px;
    height: 28px;
    margin-top: 10px;
    direction: ltr;
    background-color: hwb(0deg 100% 0% / 50%) !important;
    position: absolute;
    left: 21px;
    top: 15px;
    text-align: center;
    border-radius: 25px;" @click="this.endStory()">
      <p style="color: black;padding: 5px" @click="this.endStory()">{{$t('Home.close')}} </p>
    </div>
    <Stories :stories="stories_obj"
             :currentIndex="currentSlider"
             :style={height:this.height,width:this.width,backgroundColor:this.bk,direction:this.dir}
             @allStoriesEnd="show_story = false"
             interval="15000"
    >
    </Stories>
  </div>
  <Header1 v-if="this.show_story===false" @headeropenMenu="this.homeOpenMenu()" />
  <Loading v-if="this.geted===1 && this.show_story===false"/>

  <div v-if="this.geted===2 && this.show_story===false" class="container" style="direction: ltr;margin: 10px 0 5px 0">
    <div class="row" >
      <div v-for="str in stories_obj" :key="str.id" :class="{ circle_seen: this.seeStory.includes(str.id),circle:!this.seeStory.includes(str.id) }"  @click="this.beginStory(str.numslide,str.id)">
        <va-avatar v-if="str.cover_pic!==''" size="65px" :src="str.cover_pic" />
        <va-avatar v-else-if="str.type==='image'" size="65px" :src="str.url" />
        <va-avatar v-else size="65px" :src="this.baseurl+'/video.png'" />
      </div>
    </div>
  </div>

  <div v-if="this.geted===2 && this.show_story===false" class="center" style="width: 100%;" >
    <div class="row" style="text-align: center">
      <swiper
          :autoHeight="true"
          style="width: 100%;padding:15px 2% 15px 2%;"
          :modules="modules"
          :slides-per-view="1"
          :space-between="50"
          navigation
          :autoplay="{delay: 4000}"
          :pagination="{ clickable: true}"
          @swiper="onSwiper"
          @slideChange="this.onSlideChange()">
        <swiper-slide
            v-for="slider in this.sliders"
            :key="slider.id">
          <img @click="this.sliderLink(slider.link)" style="width: 100%;border-radius:10px;"  :src="this.baseurl+'/images/sliders/'+slider.pic"  alt="Third slide">
        </swiper-slide>
      </swiper>
    </div>
  </div>
  <div v-if="iswebapp===false && this.geted===2">
    <div class="box_install row justify-center" @click="this.installer();" style="background: white;align-items: center;justify-content: center;" >
      <img class="rounded " style="height: 40px;" src="../assets/images/install-app.png" alt="donuts" >
      <span style="color: black;font-size: 13px;font-weight: bold;margin: 0 10px 0 10px"> {{$t('Home.installApp')}} </span>
    </div>
  </div>
  <div v-if="this.geted===2 && this.show_story===false" class="row" style="width: 100%">
    <div class="box1" @click="this.goToPage(this.menus.menu1_link,this.menus.menu1_name,this.menus.menu1_type,this.menus.menu1_ref)" style="background: white;display: flex;flex-direction: column;align-items: center;" >
      <img class="d-block rounded me-1 imgbox" :src="this.baseurl+'/images/appearance/'+this.menus.menu1_pic" alt="donuts" >
      <p style="color: black;font-size: 13px;font-weight: bold">{{ this.menus.menu1_name }}</p>
    </div>
    <div class="box2" @click="this.goToPage(this.menus.menu2_link,this.menus.menu2_name,this.menus.menu2_type,this.menus.menu2_ref)" style="background: white;display: flex;flex-direction: column;align-items: center;" >
      <img class="d-block rounded me-1 imgbox" :src="this.baseurl+'/images/appearance/'+this.menus.menu2_pic" alt="donuts">
      <p style="color: black;font-size: 13px;font-weight: bold">{{ this.menus.menu2_name }}</p>
    </div>
    <div class="box3" @click="this.goToPage(this.menus.menu3_link,this.menus.menu3_name,this.menus.menu3_type,this.menus.menu3_ref)" style="background: white;display: flex;flex-direction: column;align-items: center;" >
      <img class="d-block rounded me-1 imgbox" :src="this.baseurl+'/images/appearance/'+this.menus.menu3_pic" alt="donuts" >
      <p style="color: black;font-size: 13px;font-weight: bold">{{ this.menus.menu3_name }}</p>
    </div>
  </div>



  <div v-if="this.geted===2 && this.show_story===false && this.menus.menu_type==='1'" class="row" style="width: 100%">
    <div class="box1" @click="this.goToPage(this.menus.menu4_link,this.menus.menu4_name,this.menus.menu4_type,this.menus.menu4_ref)" style="background: white;display: flex;flex-direction: column;align-items: center;" >
      <img class="d-block rounded me-1 imgbox" :src="this.baseurl+'/images/appearance/'+this.menus.menu4_pic" alt="donuts" >
      <p style="color: black;font-size: 13px;font-weight: bold">{{ this.menus.menu4_name }}</p>
    </div>
    <div class="box5" @click="this.goToPage(this.menus.menu5_link,this.menus.menu5_name,this.menus.menu5_type,this.menus.menu5_ref)" style="background: white;display: flex;flex-direction: column;align-items: center;" >
      <img class="d-block rounded me-1 imgbox" :src="this.baseurl+'/images/appearance/'+this.menus.menu5_pic" alt="donuts" >
      <p style="color: black;font-size: 13px;font-weight: bold">{{ this.menus.menu5_name }}</p>
    </div>
  </div>
  <div v-if="this.geted===2 && this.show_story===false && (this.menus.menu_type==='2' || this.menus.menu_type==='3')" class="row" style="width: 100%">
    <div class="box1 " @click="this.goToPage(this.menus.menu4_link,this.menus.menu4_name,this.menus.menu4_type,this.menus.menu4_ref)" style="background: white;display: flex;flex-direction: column;align-items: center;" >
      <img class="d-block rounded me-1 imgbox" :src="this.baseurl+'/images/appearance/'+this.menus.menu4_pic" alt="donuts" >
      <p style="color: black;font-size: 13px;font-weight: bold">{{ this.menus.menu4_name }}</p>
    </div>
    <div class="box2" @click="this.goToPage(this.menus.menu5_link,this.menus.menu5_name,this.menus.menu5_type,this.menus.menu5_ref)" style="background: white;display: flex;flex-direction: column;align-items: center;" >
      <img class="d-block rounded me-1 imgbox" :src="this.baseurl+'/images/appearance/'+this.menus.menu5_pic" alt="donuts" >
      <p style="color: black;font-size: 13px;font-weight: bold">{{ this.menus.menu5_name }}</p>
    </div>
    <div class="box3" @click="this.goToPage(this.menus.menu6_link,this.menus.menu6_name,this.menus.menu6_type,this.menus.menu6_ref)" style="background: white;display: flex;flex-direction: column;align-items: center;" >
      <img class="d-block rounded me-1 imgbox" :src="this.baseurl+'/images/appearance/'+this.menus.menu6_pic" alt="donuts" >
      <p style="color: black;font-size: 13px;font-weight: bold">{{ this.menus.menu6_name }}</p>
    </div>
  </div>

  <div  v-if="this.geted===2 && this.show_story===false && this.menus.menu_type==='3'" class="row" style="width: 100%;margin-top: 5px">
    <div class="box6" @click="this.goToPage(this.menus.menu7_link,this.menus.menu7_name,this.menus.menu7_type,this.menus.menu7_ref)" :style="{ background: this.basecolor }" >
      <div class="row justify-center" >
        <img class="d-block rounded me-1 imgbox7" :src="this.baseurl+'/images/appearance/'+this.menus.menu7_pic" alt="donuts" >
        <span style="color: white;font-weight:bold;font-size: 15px;display: flex; align-items: center;;padding: 0 8px 0 0 !important;">{{ this.menus.menu7_name }}</span>
      </div>
    </div>
  </div>
  <div v-if="this.geted===2 && this.show_story===false && this.last_views.length>0"  style=" text-align: right;display: block;padding:25px 20px 15px 20px">
    <p style="font-size: 15px" :class="{ltr_lang:$t('config.dir')==='ltr',rtl_lang:$t('config.dir')==='rtl'}">{{ $t("Home.studyingCourses") }}</p>
  </div>
  <div v-if="this.geted===2 && this.show_story===false && this.last_views.length>0" class="container">
    <div class="scrollrow" style="height: 195px">
      <div  v-for="last_view in this.last_views" :key="last_view.id"  @click="this.goToMeet(last_view.id)" class="cardhome-last mycard row" style="height: 160px">
        <img :src="this.baseurl+'/images/course/'+last_view.pic" style="height: 150px;border-radius: 10px">
        <div>
          <p style="font-size: 15px;padding: 10px 12px 10px 12px;font-weight: bold" class="cardhome-text">{{last_view.name}}</p>
          <p style="font-size: 11px;padding: 10px 12px 0 12px " class="cardhome-text">{{last_view.teacher_name}}</p>
          <div class="row" style="margin:20px 10px 0 12px;min-width: 160px ">
            <div :style="{width:last_view.percent+'%',backgroundColor:this.basecolor,borderRadius:last_view.percent===100?'15px':'0 15px 15px 0'}" style="height: 6px;top: 10px;"></div>
            <div :style="{width:100-last_view.percent+'%'}" style=" height: 6px;background-color: #c2c2c2;top: 10px;border-radius: 15px 0 0 15px"></div>
          </div>
          <div style="font-family: arial;padding: 15px 12px 0 12px">{{last_view.percent}}% مشاهده شده</div>
        </div>

      </div>

    </div>
  </div>


  <div v-if="this.geted===2 && this.show_story===false && this.popular.length>0"  style=" text-align: right;display: block;padding:25px 20px 15px 20px">
    <p style="font-size: 15px" :class="{ltr_lang:$t('config.dir')==='ltr',rtl_lang:$t('config.dir')==='rtl'}">{{ $t("Home.popularCourses") }}</p>
  </div>
  <div v-if="this.geted===2 && this.show_story===false && this.popular.length>0" class="container">
    <div class="scrollrow coursebox">
      <div class="cardhome mycard" style="height: 270px" v-for="pop in this.popular" :key="pop.ID"  @click="this.goToMeet(pop.ID)">
        <img :src="this.baseurl+'/images/course/'+pop.Pic" style="height: 150px;border-radius: 10px">
        <p style="font-size: 11px;height: 23px;padding: 2px 2px 0 2px" class="cardhome-text">{{pop.Name}}</p>
        <div class="row" style="margin-top: 10px;padding-right: 0">
          <div style="width: 60%">
            <div class="row">
              <font-awesome-icon icon="fa-regular fa-user" style="font-size: 0.75rem;padding-left: 4px"/>
              <span style="font-size: 10px;color: #3e3e3e">{{pop.Teacher}}</span>
            </div>
          </div>
          <div style="width: 40%;direction: ltr">
            <Rating :size="'0.6rem'" :rate="5"/>
          </div>

        </div>
        <div class="row" style="width: 100%;height: 1px;background-color: #a2a2a2;padding:0;margin: 10px 0 10px 0"></div>
        <div class="row" style="padding-right: 0">
          <div style="width: 38%">
            <font-awesome-icon icon="fa-regular fa-eye" style="font-size: 0.75rem;padding-left: 4px;color:#515151" />
            <span style="font-size: 12px;color: #3e3e3e">{{pop.Participants}}</span>
          </div>
          <div style="padding: 0;margin: 0;width: 62%">
            <p v-if="pop.PriceOffInt===0" style="width: 100%;padding: 0;margin: 2px 0 0 2px">
            <p style="font-size: 12px;color:var(--va-greencolor);text-align: left;font-weight: bold;display: block;margin-left: 1%">{{pop.Price}}</p>
            </p>
            <p v-else style="padding: 0;margin: 2px 0 0 2px">
            <p style="font-size: 12px;color:#5d5d5d;text-align: left;display: block;margin-left: 1px"><strike>{{pop.PriceOff}}</strike></p>
            <p style="font-size: 12px;color:var(--va-greencolor);text-align: left;font-weight: bold; display: block;margin-left: 1px">{{pop.Price}}</p>
            </p>
          </div>
        </div>
      </div>

    </div>
  </div>


  <div v-if="this.geted===2 && this.show_story===false && this.data.length>0" class="row" style="display: block;padding:25px 20px 15px 20px;">
    <p style="font-size: 15px" :class="{ltr_lang:$t('config.dir')==='ltr',rtl_lang:$t('config.dir')==='rtl'}">{{ $t("Home.latestCourses") }}</p>
  </div>
  <div v-if="this.geted===2 && this.show_story===false" class="container">
    <div class="scrollrow coursebox" :class="{ltr_lang:$t('config.dir')==='ltr',rtl_lang:$t('config.dir')==='rtl'}">
      <div class="cardhome mycard" style="height: 270px" v-for="course in data" :key="course.ID"  @click="this.goToMeet(course.ID)">
        <img :src="this.baseurl+'/images/course/'+course.Pic" style="height: 150px;border-radius: 10px">
        <p style="font-size: 11px;height: 23px;padding: 2px 2px 0 2px" class="cardhome-text">{{course.Name}}</p>
        <div class="row" style="margin-top: 10px;padding-right: 0">
          <div style="width: 60%">
            <div class="row">
              <font-awesome-icon icon="fa-regular fa-user" style="font-size: 0.75rem;padding-left: 4px"/>
              <span style="font-size: 10px;color: #3e3e3e">{{course.Teacher}}</span>
            </div>
          </div>
          <div style="width: 40%;direction: ltr">
            <Rating :size="'0.6rem'" :rate="5"/>
          </div>

        </div>
        <div class="row" style="width: 100%;height: 1px;background-color: #a2a2a2;padding:0;margin: 10px 0 10px 0"></div>
        <div class="row" style="padding-right: 0">
          <div style="width: 38%">
            <font-awesome-icon icon="fa-regular fa-eye" style="font-size: 0.75rem;padding-left: 4px;color:#515151" />
            <span style="font-size: 12px;color: #3e3e3e">{{course.Participants}}</span>
          </div>
          <div style="padding: 0;margin: 0;width: 62%">
            <div v-if="course.PriceOffInt===0" style="width: 100%;padding: 0;margin: 2px 0 0 2px">
            <p style="font-size: 12px;color:var(--va-greencolor);text-align: left;font-weight: bold;display: block;margin-left: 1%">{{course.Price}}</p>
            </div>
            <div v-else style="padding: 0;margin: 2px 0 0 2px">
              <p style="font-size: 12px;color:#5d5d5d;text-align: left;display: block;margin-left: 1px"><strike>{{course.PriceOff}}</strike></p>
              <p style="font-size: 12px;color:var(--va-greencolor);text-align: left;font-weight: bold; display: block;margin-left: 1px">{{course.Price}}</p>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>

  <div v-if="this.geted===2 && this.show_story===false && this.channels.length>0" class="row" style="display: block;padding:25px 20px 15px 20px;">
    <p class="darktitle" style="font-size: 15px" :class="{ltr_lang:$t('config.dir')==='ltr',rtl_lang:$t('config.dir')==='rtl'}">{{ $t("Home.popularChannels") }}</p>
  </div>
  <div v-if="this.geted===2 && this.show_story===false && this.channels.length>0" class="container">
    <div class="scrollrow" style="height: 195px">
      <div  v-for="channel in this.channels" :key="channel.id"  @click="this.goToChannel(channel.id)" class="cardhome-channel mycard row" style="height: 130px">
        <img :src="this.baseurl+'/images/channel/'+channel.pic" style="height: 120px;border-radius: 10px">
        <div>
          <p style="font-size: 15px;padding: 10px 12px 10px 12px;font-weight: bold" class="cardhome-text">{{channel.name}}</p>
          <p style="font-size: 11px;padding: 10px 12px 0 12px;line-height: 16px " class="cardhome-text">{{channel.description}}</p>
        </div>
      </div>
    </div>
  </div>

  <Footer v-if="this.show_story===false" :selected_num="3" />

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
      <div @click="this.$router.push({ path: '/mobile' });" style="width: 50%;text-align: center;background: var(--va-basecolor);padding: 10px 0 10px 0;color:white" class="modallogin"> {{$t('General.loginApplicationBtn')}}</div>
      <div @click="this.loginDialog=false" style="width: 50%;text-align: center;background: #dddddd;padding: 10px 0 10px 0" class="modalcancel">{{$t('General.loginApplicationCancel')}}</div>
    </div>
  </GDialog>
</template>

<script>
import { library } from '@fortawesome/fontawesome-svg-core'
import Loading from '../components/Loading.vue'
import Header1 from '../components/Header1.vue'
import Footer from '../components/Footer.vue'
import SubHeader from '../components/SubHeader.vue'
import SideMenu from '../components/SideMenu.vue'
import Rating from '../components/Rating.vue'
import { faBars,faBookOpenReader,faTv,faUserGroup,faWifi,faQuestion,faHandPointUp,faSignal,faBookOpen,faCircleCheck,faShop,faStore} from '@fortawesome/free-solid-svg-icons'
import { faBell,faComments,faUser,faEye } from '@fortawesome/free-regular-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

import {Autoplay, Navigation, Pagination, Scrollbar, A11y } from 'swiper';
import { Swiper, SwiperSlide } from 'swiper/vue';
import 'swiper/css';
import 'swiper/css/pagination';
import 'swiper/css/scrollbar';
import 'swiper/css/autoplay';
import { useToast } from "vue-toastification";
library.add(faBars,faBell,faBookOpenReader,faTv,faUserGroup,faComments,faUser,faEye,faWifi,faQuestion,faHandPointUp,faSignal,faBookOpen,faCircleCheck,faShop,faStore)
import { Stories } from "vue-insta-stories";
import 'gitart-vue-dialog/dist/style.css'
import { GDialog } from 'gitart-vue-dialog'
import {mapWritableState} from 'pinia';
import {usePermStroe} from '@/stores/permStore';
import {useTempStroe} from '@/stores/tempStore';
export default {
  name: "Home",
  computed: {
    ...mapWritableState(usePermStroe, ["ui_slider","ui_story","ui_order_item","ui_theme","ui_footer"]),
    ...mapWritableState(useTempStroe, ["show_story"])
  },
  setup() {
    return {
      modules: [Autoplay,Navigation, Pagination, Scrollbar, A11y ],
    };
  },
  components: {
    Loading,SideMenu,Header1,SubHeader,Footer,FontAwesomeIcon,Swiper, SwiperSlide,Rating,Stories,GDialog
  },
  mounted() {
    localStorage.setItem("CourseRefGl","")
    localStorage.setItem("typeGl","")
    this.isInStandaloneMode();
    this.getDevice();
    if(this.$route.query.l!==undefined){
      localStorage.setItem('lang',this.$route.query.l)
      document.location.href='/';
    }
    this.homeData();
    window.scrollTo(0,0);
    // this.windowHeight = window.innerWidth;
    var storedNames = JSON.parse(localStorage.getItem("seen_story"));
    if(storedNames!==null){
      storedNames.forEach((item, i) => {
        if(!this.seeStory.includes(item)){
          this.seeStory.push(item)
        }
      });
    }
    localStorage.setItem('course_ref', '0');
  },
  updated() {

  },
  methods:{
    installer(){
      if(this.device!=='iPhone' && this.device!=='iPod' && this.device!=='iPad'){
        // this.$router.push({ path: '/installer'});
        window.location.href='/'+this.appdirectory+'/installer';
        // document.location.href='/'+this.appdirectory+'/installer';
      }
      else{
        this.$router.push({ path: '/installerIos'});
      }
    },
    getDevice(){
      var device = "Unknown";
      const ua = {
        "Generic Linux": /Linux/i,
        "Android": /Android/i,
        "BlackBerry": /BlackBerry/i,
        "Bluebird": /EF500/i,
        "Chrome OS": /CrOS/i,
        "Datalogic": /DL-AXIS/i,
        "Honeywell": /CT50/i,
        "iPad": /iPad/i,
        "iPhone": /iPhone/i,
        "iPod": /iPod/i,
        "macOS": /Macintosh/i,
        "Windows": /IEMobile|Windows/i,
        "Zebra": /TC70|TC55/i,
      }
      Object.keys(ua).map(v => navigator.userAgent.match(ua[v]) && (device = v));
      this.device=device;
      return device;
    },
    isInStandaloneMode(){
      if((window.matchMedia('(display-mode: standalone)').matches) || (window.navigator.standalone) || document.referrer.includes('android-app://')){
        this.iswebapp=true;
        return true;
      }
      else{
        this.iswebapp=false;
        return false;
      }
    },
    inviteFriend(){
      this.$emit("headercloseMenu");
      let self = this;
      if (navigator.share){
        navigator.share({
          title: self.title,
          text: self.description,
        })
      }
    },
    beginStory(id,ref){
      this.currentSlider=id;
      this.show_story=true;

      if(!this.seeStory.includes(ref)){
        this.seeStory.push(ref)
        localStorage.setItem("seen_story", JSON.stringify(this.seeStory));
      }

    },
    endStory(){
      this.show_story=false;
    },
    sliderLink(slink){
      console.log(slink);
      if(slink===null || slink===''){
        return;
      }
      else{
        var link=slink.split('_');
        if(link[0]==="inapp"){
          if(link[1]==="course"){
            var CourseRef=link[2];
            this.$router.push({ path: '/meets/'+CourseRef });
          }
          else if(link[1]==="channel"){
            this.$router.push({ path: '/channels' });
          }
          else if(link[1]==="contact"){
            this.$router.push({ path: '/contact' });
          }
          else if(link[1]==="profile"){
            this.$router.push({ path: '/profile' });
          }
          else if(link[1]==="subscriber"){
            this.$router.push({ path: '/subscriber' });
          }
          else if(link[1]==="wallet"){
            this.$router.push({ path: '/wallet' });
          }
          else if(link[1]==="messeges"){
            this.$router.push({ path: '/messeges' });
          }
          else if(link[1]==="mycourse"){
            this.$router.push({ path: '/mycourse' });
          }
          else if(link[1]==="shop"){
            this.$router.push({ path: '/shop/home' });
          }
          else if(link[1]==="live"){
            var Ref=link[2];
            this.$router.push({ path: '/live/'+Ref });
          }
          else if(link[1]==="invite"){
            this.inviteFriend()
          }
          else{
            this.$router.push({ path: link[1] });
          }
        }
        else{
          window.open(slink,"_self");
        }
      }

    },
    goToMeet(id){
      this.$router.push({ path: '/meets/'+id });
    },
    goToPage(page,pagename,type,ref){
      console.log(ref.toString());
      localStorage.setItem('pagename',pagename)
      if(type==='external'){
        // window.location.href = page;
        this.$router.push({ path: '/wv' ,query:{ l: page } });
      }
      else{
        if(page==='commingsoon'){
          this.myToast("این بخش به زودی فعال خواهد شد");
          return
        }
        else if(page==='invite'){
          let self = this;
          var myurl=self.baseurl.replace("panel.","")
          if (navigator.share){
            navigator.share({
              title: self.$t('SideMenu.invite'),
              text: self.$t('SideMenu.inviteContent',{ appname: self.appname}),
              url: myurl
            })
          }
          return
        }

        else if(page==='live'){
          if(ref!=='0'){
            this.$router.push({ path: '/live/'+ref });
          }
          else{
            this.$router.push({ path: '/live' });
          }
        }
        else if(page==='courses'){
          if(ref===0 || ref==='0'){
            this.$router.push({ path: '/courses' ,query:{ pageref: '1' } });
          }
          else{
            this.$router.push({ path: '/meets/'+ref });
          }
        }
        else if(page==='video'){
          this.$router.push({ path: '/courses' ,query:{ pageref: '2' } });
        }
        else if(page==='podcast'){
          this.$router.push({ path: '/courses' ,query:{ pageref: '3' } });
        }
        else if(page==='book'){
          this.$router.push({ path: '/courses' ,query:{ pageref: '4' } });
        }
        else if(page==='other'){
          this.$router.push({ path: '/courses' ,query:{ pageref: '5' } });
        }
        else if(page==='other2'){
          this.$router.push({ path: '/courses' ,query:{ pageref: '6' } });
        }
        else if(page==='shop'){
          this.$router.push({ path: '/shop/home'  });
        }
        else if(page==='exams'){
          if(localStorage.getItem('tk')==="" || localStorage.getItem('tk')===null){
            this.loginDialog=true;
            return;
          }
          else if(ref!=='0'){
            this.$router.push({ path: '/exam/'+ref });
          }
          else{
            this.$router.push({ path: '/exams' });
          }
        }
        else {
          this.$router.push({path: '/'+page});
        }
      }


    },
    myToast(alert){
      useToast().warning(alert, {
        timeout: 2000,
        position:'top-center',
        rtl: this.$t('config.dir')==='rtl'?true:false
      });
    },
    homeData(){
      // if(localStorage.getItem('tk')===null){
      //   if(this.try===0){
      //     clearTimeout(this.timeOut);
      //     this.timeOut = setTimeout(()=>{
      //       this.homeData();
      //       this.try=1;
      //     }, 100)
      //
      //   }
      //   else{
      //     this.$router.push({ path: '/mobile' });
      //   }
      //   return;
      // }
      this.geted=1;
      const mydata = {
        action:'homeData',
        pusheWeb:localStorage.getItem('pusheWeb'),
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
              localStorage.setItem('logo', response.data.logo);
              localStorage.setItem('android_link', response.data.android_link);
              this.sliders=response.data.sliders;
              this.ui_theme=response.data.menus.ui_theme;
              if(response.data.data!==null){
                this.data=response.data.data;
              }
              if(response.data.popular!==null){
                this.popular=response.data.popular;
              }
               if(response.data.last_views!==null){
                this.last_views=response.data.last_views;
              }
              if(response.data.channels!==null && response.data.channels!==undefined){
                this.channels=response.data.channels;
              }
               if(response.data.possibilities!==null){
                 localStorage.setItem('poss', JSON.stringify(response.data.possibilities));
              }
              if(response.data.stories!==null){
                response.data.stories.forEach(object => {
                  console.log(object.type)
                  if(object.type==='video'){
                    this.stories_obj.push({url: object.pic, type: "video",numslide:object.numslide,cover_pic:object.cover_pic,id:object.id})
                  }
                  else{
                    this.stories_obj.push({url: object.pic, type: "image",numslide:object.numslide,cover_pic:object.cover_pic,id:object.id})
                  }
                });
              }

              localStorage.setItem('credit', response.data.credit);
              localStorage.setItem('gem', response.data.gem);
              localStorage.setItem('name', response.data.name);
              if(response.data.profilepic!=null){
                localStorage.setItem('profilepic', response.data.profilepic);
              }
              this.menus=response.data.menus

              this.geted=2;
              if(response.data.cToken===1){
                localStorage.setItem('tk', "");
              }
            }
            // else if(response.data.ok===3){
            //   localStorage.setItem('tk', "");
            //   this.$router.push({ path: '/mobile' })
            // }
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
            if(error.response.status===401){
              // localStorage.setItem('token', "");
              this.$router.push({ path: '/login' })
            }
            else {

              if (error.code === 'ECONNABORTED') {
                this.errTitle = this.$t('General.receivingError');
                this.errMsg = this.$t('General.tryAgain');
                // timed out
              } else {
                this.errTitle = this.$t('General.error');
                this.errMsg = error.message;
              }
            }
          });

    },
    slider_click(v){
      console.log(v)
    },
    homeOpenMenu(){
      this.openMenu=true;
      console.log("homeOpenMenu");
    },
    headerCloseMenu(){
      this.openMenu=false;
      console.log("homeCloseMenu");
    },

    onSwiper(){
    },
    onSlideChange(){
    },
  },

  data(){
    return{
      install_dialog:false,
      iswebapp:false,
      loginDialog:false,
      geted:0,
      rating:3,
      openMenu:false,
      formatter : new Intl.NumberFormat('en', {
        maximumFractionDigits:0,
      }),
      sliders:[],
      data:[],
      popular:[],
      last_views:[],
      channels:[],
      sliderlink:"",
      name:'',
      try:0,
      timeOut:null,
      stories_obj:[],
      currentSlider:0,
      height:'700px',
      width:"100%",
      bk:"#000000",
      dir:"ltr",
      title:"دعوت دوستان",
      description:"سلام \n" +
          "خوبی  \n" +
          "من اپلیکیشن "+this.appname+" رو نصب کردم\n" +
          "\n" +
          this.baseurl+" \n" +
          "\n" +
          "موقع ورود شماره منو "+localStorage.getItem('mobile')+" به عنوان معرف بزنی ۵۰ هزار تومان شارژ میگیری"
      ,
      seeStory:[],
      menus:{},
      device:""
    }
  }
};

</script>
<style>

.box_install{
  text-align: center;
  height: 4.5rem;
  width: 93%;
  margin-right: 3.5%;
  margin-left: 3.5%;
  margin-bottom: 10px;
  border-radius: 10px;
  background-size: cover;
  cursor: pointer;
}.box1{
  text-align: center;
  height: 6.5rem;
  width: 31%;
  margin-right: 1.5%;
  margin-left: 1.5%;
  margin-bottom: 10px;
  border-radius: 10px;
  background-size: cover;
  cursor: pointer;
}.box2{
   text-align: center;
   height: 6.5rem;
   width: 31%;
   margin-right: 1.5%;
   margin-left: 1.5%;
   margin-bottom: 5px;
   border-radius: 10px;
   background-size: cover;
   cursor: pointer;
 }.box3{
    text-align: center;
    height: 6.5rem;
    width: 31%;
    margin-left: 1.5%;
    margin-right: 1.5%;
    margin-bottom: 5px;
    border-radius: 10px;
    background-size: cover;
    cursor: pointer;
  }
.box4{
  text-align: center;
  height: 6.5rem;
  width: 32%;
  margin-right: 2%;
  border-radius: 10px;
  background-size: cover;
  cursor: pointer;
}
.box5{
  text-align: center;
  width: 64.5%;
  height: 6.5rem;
  margin-right: 1.5%;
  margin-left: 1.5%;
  border-radius: 10px;
  background-size: cover;
  cursor: pointer;
}
.awesome{
  margin: 15px 0 15px 0;
  font-size: 2.5rem;
}

.scrollrow{
  padding:0 2% 0 2%;
  align-items: stretch;
  display: flex;
  flex-direction: row;
  flex-wrap: nowrap;
  overflow-x: auto;
  overflow-y: hidden;
  /*-ms-overflow-style: none;  !* IE and Edge *!*/
  /*scrollbar-width: none;  !* Firefox *!*/
}
.coursebox{
  height: 305px;
}
.row{
  padding:0 2% 0 2%;
  align-items: stretch;
  display: flex;
  flex-direction: row;
  flex-wrap: nowrap;
  overflow-x: auto;
  overflow-y: hidden;
  -ms-overflow-style: none;  /* IE and Edge */
  scrollbar-width: none;  /* Firefox */
}
.row::-webkit-scrollbar {
  display: none;
}
.cardhome {
  /*float: left;*/
  max-width: 49%;
  margin-left: 2%;
  padding: 0.3rem;
  margin-bottom: 2rem;
  border: 0;
  flex-grow: 0;
  flex-shrink: 0;
}
.cardhome-last {
  /*float: left;*/
  min-width: 70%;
  margin-left: 2%;
  padding: 0.3rem;
  margin-bottom: 2rem;
  border: 0;
  flex-grow: 0;
  flex-shrink: 0;
}
.cardhome > img {
  margin-bottom: .01rem;
  width: 100%;
}

.cardhome-text {
  font-size: 85%;
}



div.scrollmenu {
  overflow: auto;
  white-space: nowrap;
  -ms-overflow-style: none;  /* IE and Edge */
  scrollbar-width: none;  /* Firefox */
}
.scrollmenu::-webkit-scrollbar {
  display: none;
}

div.scrollmenu a:hover {
  background-color: #777;
}
.circle {
  padding: 2.9px;
  margin: 0 6px 0 6px;
  background-color:#fff;
  border:2px solid #DE1041;
  height:75px;
  border-radius:50%;
  -moz-border-radius:50%;
  -webkit-border-radius:50%;
  width:75px;
}
.circle_seen {
  padding: 2.9px;
  margin: 0 6px 0 6px;
  background-color:#fff;
  border:2px solid #b8b8b8;
  height:75px;
  border-radius:50%;
  -moz-border-radius:50%;
  -webkit-border-radius:50%;
  width:75px;
}
.imgbox{
  width: 55px;
  margin: 13px 0 10px 0;
}
.imgbox7{
  height: 45px;
  margin: 4px 0 0 0;

}
.box6{
  text-align: center;
  width: 96%;
  background-size: cover;
  cursor: pointer;
  height: 55px;
  border-radius: 30px;
  margin: 10px 2% 10px 2%;
}
</style>