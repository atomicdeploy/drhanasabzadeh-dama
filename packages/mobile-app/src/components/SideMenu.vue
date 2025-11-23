<template>
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
  <div

      @click="this.closeMenu()"
      v-if="this.homeOpenMenu"
      style="width: 540px !important;
    background: rgba(128,128,128,0.5);z-index: 1000;
    position: fixed;height: 100%;"
      :class="{ltr_lang:$t('config.dir')==='ltr',rtl_lang:$t('config.dir')==='rtl'}"
  >
  </div>
  <div
      v-if="this.homeOpenMenu"
      style="!important;top:0;border-bottom-left-radius: 15px;
       border-top-left-radius: 15px;
       width: 18rem !important;z-index: 1031;position: fixed;
       display: table-cell;height: 100%;overflow: hidden;"
      :class="{ltr_lang:$t('config.dir')==='ltr',rtl_lang:$t('config.dir')==='rtl'}">

    <!--    <va-sidebar v-model="enabled" textColor="dark" style="width: 250px;background: white;" >-->
    <va-sidebar color="white" v-model="this.homeOpenMenu" width="18rem" textColor="dark" style="border-top-left-radius: 15px;border-bottom-left-radius: 15px;">
      <va-sidebar-item @click="this.closeMenu()">
        <va-sidebar-item-content style="padding-right: 1px">
          <img :src="this.baseurl+'/images/apps/'+this.logo" style="width:55px; ">

          <va-sidebar-item-title >
            <span style="font-weight:bold;font-size: 14px;color:black;padding-right:10px;">{{ this.appname }}</span>
          </va-sidebar-item-title>
<!--          <font-awesome-icon v-if="this.isMobile()" @click="this.closeMenu" icon="fa-solid fa-circle-xmark" size="lg"  :style="{ color: '#8d8d8f',paddingLeft:'5px',paddingRight:'5px' }"/>-->
          <!--            <i class="fa-solid fa-circle-xmark"></i>-->

        </va-sidebar-item-content>
        <hr/>
      </va-sidebar-item>
      <va-sidebar-item v-if="this.group_ref===0"  @click="this.closeMenu()">
        <router-link to="/">
          <va-sidebar-item-content>
            <va-avatar color="#F5664A" size="small" style="font-size: 0.5rem ">
              <span style="width: 20px;height: 20px"><font-awesome-icon icon="fa-solid fa-house" size="large" :style="{color:'white'}"/></span>
            </va-avatar>

            <va-sidebar-item-title >
              <span style="color:#4c4c4c;margin:0 3% 0 15px">{{$t('SideMenu.home')}}</span>
            </va-sidebar-item-title>

            <font-awesome-icon :icon="this.arrow_icon" size="lg"  :style="{ color: '#8d8d8f',paddingLeft:'10px' }"/>
          </va-sidebar-item-content>
        </router-link>
      </va-sidebar-item>
      <va-sidebar-item v-if="this.group_ref===0"  @click="this.closeMenu()">
        <div @click="this.goToPath('/profile')">
          <va-sidebar-item-content>
            <va-avatar color="#86d5de" size="small" style="font-size: 0.5rem ">
              <span style="width: 20px;height: 20px"><font-awesome-icon icon="fa-solid fa-user" size="large" :style="{color:'white'}"/></span>
            </va-avatar>

            <va-sidebar-item-title >
              <span style="color:#4c4c4c;margin:0 3% 0 15px">{{$t('SideMenu.profile')}}</span>
            </va-sidebar-item-title>
            <font-awesome-icon :icon="this.arrow_icon" size="lg"  :style="{ color: '#8d8d8f',paddingLeft:'10px' }"/>
          </va-sidebar-item-content>
        </div>
      </va-sidebar-item>
      <va-sidebar-item v-if="this.group_ref===0 && this.p2==='1'"  @click="this.closeMenu()">
        <router-link to="/courses">
          <va-sidebar-item-content>
            <va-avatar color="#4D8CDE" size="small" style="font-size: 0.5rem ">
              <span style="width: 20px;height: 20px"><font-awesome-icon icon="fa-solid fa-display" size="large" :style="{color:'white'}"/></span>
            </va-avatar>
            <va-sidebar-item-title >
              <span style="color:#4c4c4c;margin:0 3% 0 15px">{{$t('SideMenu.courses')}}</span>
            </va-sidebar-item-title>
            <font-awesome-icon :icon="this.arrow_icon" size="lg"  :style="{ color: '#8d8d8f',paddingLeft:'10px' }"/>
          </va-sidebar-item-content>
        </router-link>
      </va-sidebar-item>
      <va-sidebar-item v-if="this.group_ref===0 && this.p6==='1'"  @click="this.closeMenu()">
        <router-link to="/live">
          <va-sidebar-item-content>
            <va-avatar color="#CE7C7CFF" size="small" style="font-size: 0.5rem ">
              <span style="width: 20px;height: 20px"><font-awesome-icon icon="fa-solid fa-wifi" size="large" :style="{color:'white'}"/></span>
            </va-avatar>
            <va-sidebar-item-title >
              <span style="color:#4c4c4c;margin:0 3% 0 15px">{{$t('SideMenu.live')}}</span>
            </va-sidebar-item-title>
            <font-awesome-icon :icon="this.arrow_icon" size="lg"  :style="{ color: '#8d8d8f',paddingLeft:'10px' }"/>
          </va-sidebar-item-content>
        </router-link>
      </va-sidebar-item>
      <va-sidebar-item v-if="this.group_ref===0 && this.p10==='1'"  @click="this.closeMenu()">
        <router-link to="/subscription">
          <va-sidebar-item-content>
            <va-avatar color="#32C971" size="small" style="font-size: 0.5rem ">
              <span style="width: 20px;height: 20px"><font-awesome-icon icon="fa-regular fa-circle-check" size="large" :style="{color:'white'}"/></span>
            </va-avatar>
            <va-sidebar-item-title >
              <span style="color:#4c4c4c;margin:0 3% 0 15px">{{$t('SideMenu.subscription')}}</span>
            </va-sidebar-item-title>
            <font-awesome-icon :icon="this.arrow_icon" size="lg"  :style="{ color: '#8d8d8f',paddingLeft:'10px' }"/>
          </va-sidebar-item-content>
        </router-link>
      </va-sidebar-item>
      <va-sidebar-item v-if="this.group_ref===0 && this.p8==='1'"  @click="this.closeMenu()">
        <router-link to="/channel">
          <va-sidebar-item-content>
           <va-avatar color="#FCBE11" size="small" style="font-size: 0.5rem ">
              <span style="width: 20px;height: 20px"><font-awesome-icon icon="fa-solid fa-volume-low" size="large" :style="{color:'white'}"/></span>
            </va-avatar>

            <va-sidebar-item-title >
              <span style="color:#4c4c4c;margin:0 3% 0 15px">{{$t('SideMenu.educational')}}</span>
            </va-sidebar-item-title>
            <font-awesome-icon :icon="this.arrow_icon" size="lg"  :style="{ color: '#8d8d8f',paddingLeft:'10px' }"/>
          </va-sidebar-item-content>
        </router-link>
      </va-sidebar-item>
      <va-sidebar-item v-if="this.group_ref===0 && this.p3==='1'"  @click="this.closeMenu()">
        <router-link to="/shop/home">
          <va-sidebar-item-content>
            <va-avatar color="#FF4D4DC3" size="small" style="font-size: 0.5rem ">
              <span style="width: 20px;height: 20px"><font-awesome-icon icon="fa-solid fa-shop" size="large" :style="{color:'white'}"/></span>
            </va-avatar>

            <va-sidebar-item-title >
              <span style="color:#4c4c4c;margin:0 3% 0 15px">{{$t('SideMenu.shop')}}</span>
            </va-sidebar-item-title>
            <font-awesome-icon :icon="this.arrow_icon" size="lg"  :style="{ color: '#8d8d8f',paddingLeft:'10px' }"/>
          </va-sidebar-item-content>
        </router-link>
      </va-sidebar-item>
      <va-sidebar-item v-if="this.group_ref===0"  @click="this.inviteFriend()">
        <va-sidebar-item-content>
          <va-avatar color="#a5e293" size="small" style="font-size: 0.5rem ">
            <span style="width: 20px;height: 20px"><font-awesome-icon icon="fa-solid fa-user-plus" size="large" :style="{color:'white'}"/></span>
          </va-avatar>

          <va-sidebar-item-title >
            <span style="color:#4c4c4c;margin:0 3% 0 15px">{{$t('SideMenu.invite')}}</span>
          </va-sidebar-item-title>
          <font-awesome-icon :icon="this.arrow_icon" size="lg"  :style="{ color: '#8d8d8f',paddingLeft:'10px' }"/>
        </va-sidebar-item-content>

      </va-sidebar-item>
      <va-sidebar-item v-if="this.group_ref===0"  @click="this.closeMenu()">
        <router-link to="/wallet">
          <va-sidebar-item-content>
            <va-avatar color="#A78DE9" size="small" style="font-size: 0.5rem ">
              <span style="width: 20px;height: 20px"><font-awesome-icon icon="fa-solid fa-wallet" size="large" :style="{color:'white'}"/></span>
            </va-avatar>
            <va-sidebar-item-title >
              <span style="color:#4c4c4c;margin:0 3% 0 15px">{{$t('SideMenu.wallet')}}</span>
            </va-sidebar-item-title>
            <font-awesome-icon :icon="this.arrow_icon"  size="lg"  :style="{ color: '#8d8d8f',paddingLeft:'10px' }"/>
          </va-sidebar-item-content>
        </router-link>
      </va-sidebar-item>
      <va-sidebar-item v-if="this.group_ref===0 && this.p12==='1'"  @click="this.closeMenu()">
        <router-link to="/teachers">
          <va-sidebar-item-content>
            <va-avatar color="#fc76a5" size="small" style="font-size: 0.5rem ">
              <span style="width: 20px;height: 20px"><font-awesome-icon icon="fa-solid fa-chalkboard-user" size="large" :style="{color:'white'}"/></span>
            </va-avatar>
            <va-sidebar-item-title >
              <span style="color:#4c4c4c;margin:0 3% 0 15px">{{$t('SideMenu.teachers')}}</span>
            </va-sidebar-item-title>
            <font-awesome-icon :icon="this.arrow_icon"  size="lg"  :style="{ color: '#8d8d8f',paddingLeft:'10px' }"/>
          </va-sidebar-item-content>
        </router-link>
      </va-sidebar-item>
      <va-sidebar-item v-if="this.group_ref===0 && this.p11==='1'"  @click="this.closeMenu()">
        <router-link to="/counseling">
          <va-sidebar-item-content>
            <va-avatar color="#DF79B4" size="small" style="font-size: 0.5rem ">
              <span style="width: 20px;height: 20px"><font-awesome-icon icon="fa-solid fa-user-group" size="large" :style="{color:'white'}"/></span>
            </va-avatar>
            <va-sidebar-item-title >
              <span style="color:#4c4c4c;margin:0 3% 0 15px">{{$t('SideMenu.consultation')}}</span>
            </va-sidebar-item-title>
            <font-awesome-icon :icon="this.arrow_icon" size="lg"  :style="{ color: '#8d8d8f',paddingLeft:'10px' }"/>
          </va-sidebar-item-content>
        </router-link>
      </va-sidebar-item>
      <va-sidebar-item v-if="this.group_ref===0"  @click="this.closeMenu()">
        <div @click="this.goToPath('/support')">
          <va-sidebar-item-content>
            <va-avatar color="#eabc7c" size="small" style="font-size: 0.5rem ">
              <span style="width: 20px;height: 20px"><font-awesome-icon icon="fa-solid fa-headset" size="large" :style="{color:'white'}"/></span>
            </va-avatar>
            <va-sidebar-item-title >
              <span style="color:#4c4c4c;margin:0 3% 0 15px">{{$t('SideMenu.support')}}</span>
            </va-sidebar-item-title>
            <font-awesome-icon :icon="this.arrow_icon" size="lg"  :style="{ color: '#8d8d8f',paddingLeft:'10px' }"/>
          </va-sidebar-item-content>
        </div>
      </va-sidebar-item>
      <va-sidebar-item v-if="this.group_ref===0"  @click="this.closeMenu()">
        <router-link to="/terms">
          <va-sidebar-item-content>
            <va-avatar color="#a1f597" size="small" style="font-size: 0.5rem ">
              <span style="width: 20px;height: 20px;"><font-awesome-icon icon="fa-solid fa-gavel" size="large" :style="{color:'white'}"/></span>
            </va-avatar>
            <va-sidebar-item-title >
              <span style="color:#4c4c4c;margin:0 3% 0 15px">{{$t('SideMenu.rules')}}</span>
            </va-sidebar-item-title>
            <font-awesome-icon :icon="this.arrow_icon" size="lg"  :style="{ color: '#8d8d8f',paddingLeft:'10px' }"/>
          </va-sidebar-item-content>
        </router-link>
      </va-sidebar-item>
      <va-sidebar-item v-if="this.group_ref===0"  @click="this.closeMenu()">
        <router-link to="/contact">
          <va-sidebar-item-content>
            <va-avatar color="#B29878" size="small" style="font-size: 0.5rem ">
              <span style="width: 20px;height: 20px;padding-right: 2px"><font-awesome-icon icon="fa-solid fa-paper-plane" size="large" :style="{color:'white'}"/></span>
            </va-avatar>
            <va-sidebar-item-title >
              <span style="color:#4c4c4c;margin:0 3% 0 15px">{{$t('SideMenu.contact')}}</span>
            </va-sidebar-item-title>
            <font-awesome-icon :icon="this.arrow_icon" size="lg"  :style="{ color: '#8d8d8f',paddingLeft:'10px' }"/>
          </va-sidebar-item-content>
        </router-link>
      </va-sidebar-item>
      <va-sidebar-item v-if="this.group_ref===0 && this.p9==='1'"  @click="this.openLangs()">
          <va-sidebar-item-content>
            <va-avatar color="#7a7af5" size="small" style="font-size: 0.5rem ">
              <span style="width: 20px;height: 20px;padding-right: 2px"><font-awesome-icon icon="fa-solid fa-earth-americas" size="large" :style="{color:'white'}"/></span>
            </va-avatar>
            <va-sidebar-item-title >
              <span style="color:#4c4c4c;margin:0 3% 0 15px">{{$t('SideMenu.changeLanguage')}}</span>
            </va-sidebar-item-title>
            <font-awesome-icon :icon="this.arrow_icon" size="lg"  :style="{ color: '#8d8d8f',paddingLeft:'10px' }"/>
          </va-sidebar-item-content>
      </va-sidebar-item>
      <va-sidebar-item v-if="this.group_ref===0"  @click="this.closeMenu()" style="cursor:pointer">
        <va-sidebar-item-content @click="this.logout()">
         <va-avatar color="#B4BBC5" size="small" style="font-size: 0.5rem ">
            <span style="width: 20px;height: 20px"><font-awesome-icon icon="fa-solid fa-power-off" size="large" :style="{color:'white'}"/></span>
          </va-avatar>
          <va-sidebar-item-title >
            <span style="color:#4c4c4c;margin:0 6% 0 15px">{{$t('SideMenu.signOut')}}</span>
          </va-sidebar-item-title>
        </va-sidebar-item-content>
      </va-sidebar-item>
      <hr v-if="this.$t('config.lang')==='fa'" style="color: #adabab;width: 80%;margin: 5px 10% 15px 10%;"/>
      <p v-if="this.$t('config.lang')==='fa'" style="width: 100%;text-align: center;margin-bottom: 20px;color: #6a6a6a;font-size: 12px">{{$t('SideMenu.development')}}: <span style="color: #5d8bff">dama-app.ir</span></p>
    </va-sidebar>

  </div>

  <div id="myLangModal" class="modal" style="position: absolute !important;max-width: 540px">

    <!-- Modal content -->
    <div  class="modal-content" style="max-width: 540px;border-top-left-radius: 20px;border-top-right-radius: 20px;padding-bottom: 10px">

      <div class="row" style="margin-bottom: 10px">
        <p style="width: 82%;padding:20px 20px 0 20px">{{$t('SideMenu.changeLanguage')}}</p>
        <div style="width:14%; margin: 0 4% 0 0" :class="{rtl_lang:$t('config.dir')==='ltr',ltr_lang:$t('config.dir')==='rtl'}">
          <va-avatar style="margin: 10px 10px 0 10px;cursor: pointer" size="small"  @click="this.close()"   color="red"><span style="font-size: 35px;margin-top: 5px">&times;</span></va-avatar>
        </div>
      </div>
      <hr/>
      <div v-if="this.geted===1" style="min-height: 200px">
        <Loading/>
      </div>

      <div v-else v-for="(item, i) in this.data" :key="item.id" @click="this.changeLang(item.id,item.nick)" class="mycard" style="border-radius: 30px;margin: 10px 3% 10px 3%;">

        <div  >

          <div class="row" style="padding: 20px 0 15px 0; " :class="{active_lang:item.id===this.lang_ref,deactive_lang:item.id!==item.lang_ref}">
            <div>
              <img style="width:45px; margin: 0 20px 0 20px;" :src="this.baseurl+'/images/languages/'+item.nick+'.png'">
            </div>
            <div style="padding: 15px 15px 0 15px"><span>{{ item.name }}</span></div>
          </div>

        </div>

      </div>

    </div>

  </div>
</template>
<script>
import Loading from "./Loading.vue";
import { library } from '@fortawesome/fontawesome-svg-core'
import {
  faHouse, faAngleLeft,faAngleRight, faAngleDown, faCircleXmark, faDisplay,
  faPowerOff, faVolumeLow, faWallet,faUserGroup,faUser,faUserPlus,faGavel,faHeadset,faPaperPlane,faWifi,faEarthAmericas,faChalkboardUser
} from '@fortawesome/free-solid-svg-icons'
import { faCircleCheck
} from '@fortawesome/free-regular-svg-icons'


import { faChromecast } from '@fortawesome/free-brands-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
library.add(faHouse,faAngleLeft,faAngleRight,faAngleDown,faCircleXmark, faDisplay,faWifi,faChalkboardUser,
    faPowerOff,faCircleCheck,faVolumeLow,faWallet,faUserGroup,faUser,faUserPlus,faGavel,faHeadset,faPaperPlane,faEarthAmericas)
import 'gitart-vue-dialog/dist/style.css'
import { GDialog } from 'gitart-vue-dialog'
import {mapWritableState} from 'pinia';
import {usePermStroe} from '@/stores/permStore';
import {useTempStroe} from '@/stores/tempStore';
export default {
  name: "SideMenu",
  props: ['group_ref','openMenu'],
  components:{FontAwesomeIcon,GDialog,Loading},
  data () {
    return {
      logo:"",
      arrow_icon:'fa-solid fa-angle-left',
      loginDialog:false,
      menuName:"",
      url : this.baseurl,
      title:this.$t('SideMenu.invite'),
      description:this.$t('SideMenu.inviteContent',{ appname: this.appname}),
      geted:0,
      data:[],

      p1:'1',
      p2:'1',
      p3:'1',
      p4:'1',
      p5:'1',
      p6:'1',
      p7:'1',
      p8:'1',
      p9:'1',
      p10:'1',
      p11:'1',
      p12:'1',
      p13:'1',

      // description: "اپلیکیشن "+this.appname+" را نصب و به ده ها دوره ی آموزشی دسترسی پیدا کنید"+"\n"+"در زمان ورود شماره همراه "+localStorage.getItem('mobile')+" را وارد کنید."+"\n"
    }
  },
  mounted() {
    this.logo=localStorage.getItem('logo')
    const myArray = this.$route.path.split("-");
    let word = myArray[0];
    if(this.$t('config.dir')==='ltr'){
      this.arrow_icon="fa-solid fa-angle-right"
    }
    else{
      this.arrow_icon="fa-solid fa-angle-left"
    }
    if(localStorage.getItem('mobile')!==null){
      this.description=this.$t('SideMenu.inviteContentWithMobile',{ appname: this.appname,mobile: localStorage.getItem('mobile')})
    }

    var poss_obj = JSON.parse(localStorage.getItem('poss'));
    if(poss_obj!=null){
      this.p1=poss_obj.p1
      this.p2=poss_obj.p2
      this.p3=poss_obj.p3
      this.p4=poss_obj.p4
      this.p5=poss_obj.p5
      this.p6=poss_obj.p6
      this.p7=poss_obj.p7
      this.p8=poss_obj.p8
      this.p9=poss_obj.p9
      this.p10=poss_obj.p10
      this.p11=poss_obj.p11
      this.p12=poss_obj.p12
      this.p13=poss_obj.p13
    }


    // console.log(storedObject.key);    // مقدار 'value'
    // console.log(storedObject.number); // مقدار 42
  },
  computed: {
    ...mapWritableState(usePermStroe, ["ui_header","ui_slider","ui_story","ui_order_item","ui_menu","ui_footer"]),
    ...mapWritableState(useTempStroe, ["show_story","isHome","homeOpenMenu"])
  },
  methods:{
    changeLang(id,nick){
      var modal = document.getElementById("myLangModal");
      modal.style.display = "none";
      this.$i18n.locale = nick;
      localStorage.setItem('lang',nick)
      location.reload();
    },
    close(){
      var modal = document.getElementById("myLangModal");
      modal.style.display = "none";
    },
    goToPath(path){
      if((path==='/profile' || path==='/support') && (localStorage.getItem('tk')==="" || localStorage.getItem('tk')===null)){
        this.loginDialog=true;
        return;
      }
      else{
        this.$router.push({ path: path });
      }
    },
    inviteFriend(){
      this.$emit("headercloseMenu");
      let self = this;
      var myurl=self.url.replace("panel.","")
      if (navigator.share){
        navigator.share({
          title: self.title,
          text: self.description,
          url: myurl
        })
      }

    },
    logout(){
      this.$swal({
        title: 'خروج از حساب',
        text: "شما از حساب کاربری خود خارج شدید",
        icon: 'success',
        confirmButtonText:this.$t('General.ok'),
        customClass: {
          confirmButton: 'btn btn-primary'
        },
        buttonsStyling: false
      });
      localStorage.setItem('tk', "");
      this.$router.push({ path: '/' })

    },
    isMobile() {
      if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
        return true
      } else {
        return false
      }
    },
    openLangs(){
      this.$emit("headercloseMenu");
      var modal = document.getElementById("myLangModal");
      modal.style.display = "block";

      this.geted=1;
      const mydata = {
        action:'languages',
      };
      this.$http(
          {
            method: "post",
            url: this.apiurl,
            timeout: 1000 * 12, // Wait for 12 seconds
            data: mydata,
            headers: {
              "Content-Type": "application/json",
              "Authorization": `Bearer ${localStorage.getItem('tk')}`
            },
          })
          .then((response) => {
            if(response.data.ok===1){
              if(response.data.data!==null){
                this.data=response.data.data;
              }
              this.geted=2;
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
     closeMenu(){
     this.homeOpenMenu=false
    },
    test(){
      console.log("asas")
    },
    checkMenuName(name){
      //
      // $.app.menu.open();
      // $.app.menu.hide();
      // return false;
      if( this.$route.path===name){
        return true;
      }
      else{
        return false;
      }
    },
    checkUl(name){
      const myArray = this.$route.path.split("-");
      let word = myArray[0];
      console.log(word);
      if( myArray[0]==="/"+name){
        return true;
      }
      else{
        return false;
      }
    },
    openMenu(){
      return true;
    }
  }
}
</script>
<style>
.swiper-pagination-bullet-active{
  background-color:white !important;
}
span{
  font-family: IRANYekan !important;
}
.expanded {
  background-color: white;
}
.sub {
  background-color: #d6d6d6;
}
a{
  color: #2d2d2d
}

.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
  -webkit-animation-name: fadeIn; /* Fade in the background */
  -webkit-animation-duration: 0.4s;
  animation-name: fadeIn;
  animation-duration: 0.4s
}
/* Modal Content */
.modal-content {
  position: fixed;
  bottom: 0;
  background-color: #fefefe;
  width: 100%;
  -webkit-animation-name: slideIn;
  -webkit-animation-duration: 0.4s;
  animation-name: slideIn;
  animation-duration: 0.4s
}
/* The Close Button */
.close {
  color: black;
  float: left;
  font-size: 28px;
  font-weight: bold;
}
.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}
.active_lang{
  background-color: #dedede !important;
}
.deactive_lang{
  background-color: unset;
}
.insbtn{
  width: 92%;
  text-align: center;
  margin:20px 3% 20px 3%;
  height: 45px;
  /*background-color:var(--va-basecolor);*/
  color:white;
  border-radius: 10px;
  border:unset;
  cursor: pointer;
}
.va-sidebar{
  background: white !important;
}
</style>