<template >
  <div style="background: white">
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
    z-index: 555;
    border-radius: 25px;" @click="this.endStory()">
        <p style="color: black;padding: 5px" @click="this.endStory()">بستن </p>
      </div>
      <Stories :stories="stories_obj"
               :currentIndex="currentSlider"
               :style={height:this.height,width:this.width,backgroundColor:this.bk,direction:this.dir}
               @allStoriesEnd="show_story = false"
               interval="15000"
      >
      </Stories>
    </div>
    <Header2 v-if="this.show_story===false" />
    <Loading v-if="this.geted===1 && this.show_story===false"/>

    <div v-if="this.geted===2 && this.show_story===false" class="center" style="width: 100%;" >
      <div class="row" style="text-align: center;margin-top: 5px">
        <swiper
            :autoHeight="true"
            style="padding:0 0 15px 0;"
            :modules="modules"
            :slides-per-view="1.2"
            :space-between="20"
            navigation
            :autoplay="{delay: 4000}"
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
    <div v-if="this.geted===2 && this.show_story===false" class="container" style="direction: rtl;margin: 0 0 5px 0">
      <div class="row" >
        <div v-for="str in stories_obj" :key="str.id" :class="{ circle2_seen: this.seeStory.includes(str.id),circle2:!this.seeStory.includes(str.id) }"  @click="this.beginStory(str.numslide,str.id)">
          <va-avatar v-if="str.cover_pic!==''" size="66px" :src="str.cover_pic" style="border-radius: 20px" />
          <va-avatar v-else-if="str.type==='image'" size="66px" :src="str.url" style="border-radius: 20px"/>
          <va-avatar v-else size="66px" :src="this.baseurl+'/video.png'" style="border-radius: 20px"/>
        </div>
      </div>
    </div>
    <div v-if="iswebapp===false && this.geted===2" style="margin-top: 20px">
      <div class="box_install row justify-center" @click="this.installer();" style="align-items: center;justify-content: center;" >
        <img class="rounded " style="height: 40px;" src="../assets/images/install-app.png" alt="donuts" >
        <span style="color: black;font-size: 13px;font-weight: bold;margin: 0 10px 0 10px"> نصب اپلیکیشن</span>
      </div>
    </div>
    <div v-if="this.geted===2 && this.show_story===false" class="row flex">
      <div class="box1-u2 "  @click="this.goToPage(this.menus.menu1_link,this.menus.menu1_name,this.menus.menu1_type,this.menus.menu1_ref)" >
        <div class="row justify-space-between">
          <img class="d-block rounded me-1 imgbox-u2" :src="this.baseurl+'/images/appearance/'+this.menus.menu1_pic" alt="{{ this.menus.menu1_name }}" >
          <div class="text-div">
            <p style="color: black;font-size: 13px ">{{ this.menus.menu1_name }}</p>
          </div>
          <div style="margin: 30px 0 0 0">
            <img style="width:15px " src="../assets/images/left-red.png">
          </div>
        </div>
      </div>
      <div class="box2-u2 " @click="this.goToPage(this.menus.menu2_link,this.menus.menu2_name,this.menus.menu2_type,this.menus.menu2_ref)"  >
       <div class="row justify-space-between">
         <img class="d-block rounded me-1 imgbox-u2" :src="this.baseurl+'/images/appearance/'+this.menus.menu2_pic" alt="donuts">
         <div class="text-div">
           <p style="color: black;font-size: 13px ">{{ this.menus.menu2_name }}</p>
         </div>
         <div style="margin: 30px 0 0 0">
           <img style="width:15px " src="../assets/images/left-blue.png">
         </div>
       </div>
      </div>
    </div>
    <div v-if="this.geted===2 && this.show_story===false" class="row flex">
      <div class="box3-u2 "  @click="this.goToPage(this.menus.menu3_link,this.menus.menu3_name,this.menus.menu3_type,this.menus.menu3_ref)" >
        <div class="row justify-space-between">
          <img class="d-block rounded me-1 imgbox-u2" :src="this.baseurl+'/images/appearance/'+this.menus.menu3_pic" alt="{{ this.menus.menu3_name }}" >
          <div class="text-div">
            <p style="color: black;font-size: 13px ">{{ this.menus.menu3_name }}</p>
          </div>
          <div style="margin: 30px 0 0 0">
            <img style="width:15px " src="../assets/images/left-yellow.png">
          </div>
        </div>
      </div>
      <div class="box4-u2 " @click="this.goToPage(this.menus.menu4_link,this.menus.menu4_name,this.menus.menu4_type,this.menus.menu4_ref)"  >
        <div class="row justify-space-between">
          <img class="d-block rounded me-1 imgbox-u2" :src="this.baseurl+'/images/appearance/'+this.menus.menu4_pic" alt="donuts">
          <div class="text-div">
            <p style="color: black;font-size: 13px ">{{ this.menus.menu4_name }}</p>
          </div>
          <div style="margin: 30px 0 0 0">
            <img style="width:15px " src="../assets/images/left-green.png">
          </div>
        </div>
      </div>
    </div>
    <div v-if="this.geted===2 && this.show_story===false && this.menus.menu_type==='1'" class="row flex">
      <div class="box5only-u2" @click="this.goToPage(this.menus.menu5_link,this.menus.menu5_name,this.menus.menu5_type,this.menus.menu5_ref)" >
        <div class="row justify-space-evenly">
          <img class="d-block rounded me-1 imgbox-u2" :src="this.baseurl+'/images/appearance/'+this.menus.menu5_pic" alt="{{ this.menus.menu5_name }}" >
          <div class="text-div">
            <p style="color: black;font-size: 13px ">{{ this.menus.menu5_name }}</p>
          </div>
          <div style="margin: 30px 0 0 0">
            <img style="width:15px " src="../assets/images/left-yellow.png">
          </div>
        </div>
      </div>
    </div>
    <div v-if="this.geted===2 && this.show_story===false && (this.menus.menu_type==='2' || this.menus.menu_type==='3')" class="row flex">
      <div class="box5-u2 "  @click="this.goToPage(this.menus.menu5_link,this.menus.menu5_name,this.menus.menu5_type,this.menus.menu5_ref)" >
        <div class="row justify-space-between">
          <img class="d-block rounded me-1 imgbox-u2" :src="this.baseurl+'/images/appearance/'+this.menus.menu5_pic" alt="{{ this.menus.menu5_name }}" >
          <div class="text-div">
            <p style="color: black;font-size: 13px ">{{ this.menus.menu5_name }}</p>
          </div>
          <div style="margin: 30px 0 0 0">
            <img style="width:15px " src="../assets/images/left-bluelight.png">
          </div>
        </div>
      </div>
      <div class="box6-u2 " @click="this.goToPage(this.menus.menu6_link,this.menus.menu6_name,this.menus.menu6_type,this.menus.menu6_ref)"  >
        <div class="row justify-space-between">
          <img class="d-block rounded me-1 imgbox-u2" :src="this.baseurl+'/images/appearance/'+this.menus.menu6_pic" alt="donuts">
          <div class="text-div">
            <p style="color: black;font-size: 13px ">{{ this.menus.menu6_name }}</p>
          </div>
          <div style="margin: 30px 0 0 0">
            <img style="width:15px " src="../assets/images/left-pink.png">
          </div>
        </div>
      </div>
    </div>

    <div v-if="this.geted===2 && this.show_story===false && this.menus.menu_type==='3'" class="row flex">
      <div class="box7only-u2 "  @click="this.goToPage(this.menus.menu7_link,this.menus.menu7_name,this.menus.menu7_type,this.menus.menu7_ref)" >
        <div class="row justify-space-evenly">
          <img class="d-block rounded me-1 imgbox-u2" :src="this.baseurl+'/images/appearance/'+this.menus.menu7_pic" alt="{{ this.menus.menu7_name }}" >
          <div class="text-div">
            <p style="color: black;font-size: 13px ">{{ this.menus.menu7_name }}</p>
          </div>
          <div style="margin: 30px 0 0 0">
            <img style="width:15px " src="../assets/images/left-red.png">
          </div>
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
  </div>

</template>

<script>
import { library } from '@fortawesome/fontawesome-svg-core'
import Loading from '../components/Loading.vue'
import Header2 from '../components/Header2.vue'
import Footer from '../components/Footer.vue'

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
  name: "Home2",
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
    Loading,SideMenu,Header2,Footer,FontAwesomeIcon,Swiper, SwiperSlide,Rating,Stories,GDialog
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
  background: #eaeaea;
  text-align: center;
  height: 75px;
  width: 94%;
  margin-right: 3%;
  margin-left: 3%;
  margin-bottom: 10px;
  border-radius: 15px;
  background-size: cover;
  cursor: pointer;
}.box1-u2{
  width: 48%;
  margin: 0 1% 0 1%;
  padding: 0 5px 0 5px;
  text-align: center;
  height: 75px;
  margin-bottom: 10px;
  border-radius: 16px;
  cursor: pointer;
  background: #FFE5E5;
}.box2-u2{
    width: 48%;
    margin: 0 1% 0 1%;
    padding: 0 5px 0 5px;
    text-align: center;
    height: 75px;
    margin-bottom: 10px;
    border-radius: 16px;
    cursor: pointer;
    background: #DFE5F7;
 }.box3-u2{
      width: 48%;
      margin: 0 1% 0 1%;
      padding: 0 5px 0 5px;
      text-align: center;
      height: 75px;
      margin-bottom: 10px;
      border-radius: 16px;
      cursor: pointer;
      background: #FDF6EA;
  }
.box4-u2{
  width: 48%;
  margin: 0 1% 0 1%;
  padding: 0 5px 0 5px;
  text-align: center;
  height: 75px;
  margin-bottom: 10px;
  border-radius: 16px;
  cursor: pointer;
  background: #D9FFEF;
}
.box5-u2{
  width: 48%;
  margin: 0 1% 0 1%;
  padding: 0 5px 0 5px;
  text-align: center;
  height: 75px;
  margin-bottom: 10px;
  border-radius: 16px;
  cursor: pointer;
  background: #E3F9FF;
}
.box6-u2{
  width: 48%;
  margin: 0 1% 0 1%;
  padding: 0 5px 0 5px;
  text-align: center;
  height: 75px;
  margin-bottom: 10px;
  border-radius: 16px;
  cursor: pointer;
  background: #FEEAF6;
}
.box5only-u2{
  width: 48%;
  margin: 0 1% 0 1%;
  padding: 0 5px 0 5px;
  text-align: center;
  height: 75px;
  margin-bottom: 10px;
  border-radius: 16px;
  cursor: pointer;
  background: #E3F9FF;
}
.box7only-u2{
  width: 48%;
  margin: 0 1% 0 1%;
  padding: 0 5px 0 5px;
  text-align: center;
  height: 75px;
  margin-bottom: 10px;
  border-radius: 16px;
  cursor: pointer;
  background: #E3F9FF;
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
.circle2 {
  padding: 1px;
  margin: 0 5px 0 5px;
  background-color:#fff;
  border:1px solid #DE1041;
  height:70px;
  border-radius:20px;
  -moz-border-radius:20px;
  -webkit-border-radius:20px;
  width:70px;
}
.circle2_seen {
  padding: 1px;
  margin: 0 5px 0 5px;
  background-color:#fff;
  border:1px solid #b8b8b8;
  height:70px;
  border-radius:20px;
  -moz-border-radius:20px;
  -webkit-border-radius:20px;
  width:70px;
}
.imgbox-u2{
  height: 45px;
  margin: 15px 0 0 0;
}
.text-div{
  display: flex;
  justify-content: center;
  align-items: center;
  height: 75px
}

</style>