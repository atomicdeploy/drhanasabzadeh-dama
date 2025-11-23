<template>
  <!--  <router-view v-if="1===1"/>-->
  <Header   @headeropenMenu="this.homeOpenMenu()"  :isHome="0"/>
  <SideMenu :openMenu="this.openMenu" @headercloseMenu="this.headerCloseMenu()" :group_ref="0" />
  <div v-if="this.$i18n.locale==='fa'">
    <div v-if="!this.iswebapp">
      <div style="width:20% !important;height: 50px" ></div>
      <p style="margin-top:20px;text-align: center">نصب اپلیکیشن <b>{{this.appname}}</b> در گوشی آیفون</p>
      <div  style="width: 100%;text-align: center">
        <div style="margin: 5%;background-color: white;padding: 2%;border-radius: 15px">
          <p style="margin: 0 0 12px  0;text-align: right;font-weight: bold">1- در پایین صفحه گزینه <span style="top: 5px;position: relative;"><img style="width:25px " src="../assets/images/add1.png"></span> <font-awesome-icon icon="fa-solid fa-ellipsis-vertical" /> را انتخاب کنید</p>
          <img style="width:100% " src="../assets/images/install_ios1.jpg">
          <p style="margin: 35px 0 15px 0;direction: rtl;text-align: right;font-weight: bold">2- در پنجره باز شده صفحه را به بالا بکشید و یا گزینه Add to Home screen  <img style="top: 5px;position: relative;width:20px " src="../assets/images/add2.png"> را انتخاب کنید.</p>
          <img style="width:100% " src="../assets/images/install_ios2.jpg">
          <p style="margin: 30px 0 12px 0;text-align: right;font-weight: bold">3- گزینه Add to Home screen  <img style="top: 5px;position: relative;width:20px " src="../assets/images/add2.png"> را انتخاب کنید.</p>
          <img style="width:100% " src="../assets/images/install_ios3.jpg">
        </div>
      </div>

    </div>
  </div>


  <hr style="margin: 0 30px 25px 30px"/>
  <button @click="this.goToPage('/')"  class="insbtn" type="button" style="margin: 5px 4% 10% 4%;text-align: center;">
    بازگشت
  </button>
</template>
<script>
import Header from '../components/Header.vue'
import SideMenu from '../components/SideMenu.vue'
import {useToast} from "vue-toastification";
export default {

  mounted() {
    if(this.$route.query.try==="1"){
      useToast().warning("خطا در نصب، مجددا تلاش کنید", {
        timeout: 2000,
        position:'top-center'
      });
    }
    this.logo=localStorage.getItem('logo')
    this.android_link=localStorage.getItem('android_link')
    this.getDevice();
    // this.getBrowser();
  },

  data(){
    return{
      logo:"",
      iswebapp:false,
      openMenu:false,
      device:"",
      browser:"",
      android_link:"",
      deferredPrompt: null
    }
  },
  created() {
    window.addEventListener("beforeinstallprompt", (e) => {
      e.preventDefault();
      // Stash the event so it can be triggered later.
      this.deferredPrompt = e;
    });
  },
  components: {
    SideMenu,Header
  },
  methods:{
    async myinstall() {
      if(this.deferredPrompt!==null){
        this.deferredPrompt.prompt();
      }
      else{
        document.location.href='/'+this.appdirectory+'/installer?try=1';
      }
    },
    homeOpenMenu(){
      this.openMenu=true;
    },
    headerCloseMenu(){
      this.openMenu=false;
    },
    goToPage(page){
      var courseref=localStorage.getItem('course_ref')

      if(courseref!==null && courseref!=='0'){
        this.$router.push({ path: "/meets/"+courseref })
      }
      else{
        this.$router.push({ path: page })
      }

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
    getBrowser(){
      let userAgent = navigator.userAgent;
      if(userAgent.match(/chrome|chromium|crios/i)){
        this.browser = "chrome";
      }else if(userAgent.match(/firefox|fxios/i)){
        this.browser = "firefox";
      }  else if(userAgent.match(/safari/i)){
        this.browser = "safari";
      }else if(userAgent.match(/opr\//i)){
        this.browser = "opera";
      } else if(userAgent.match(/edg/i)){
        this.browser = "edge";
      }else{
        this.browser="No browser detection";
      }
    }
  }
}

</script>
<style>
@import '../assets/font.css';
@import url('../assets/fontgoogleapis.css');
@import url('../assets/googlematerial.css');
html{
  background-color: #c7c7c7 !important;
}
body{
  max-width: 540px !important;
  margin: 0 auto !important;
  /*background-color: #FAFAFA;*/
  /*background-color: #eef2f1 !important;*/
  /*direction: rtl;*/
  font-family: 'IRANYekan',serif !important;
}
div{
  font-family: 'IRANYekan',serif !important;
  max-width: 100%;
}
span{
  font-family: 'IRANYekan',serif !important;
  max-width: 100%;
}
p{
  font-family: 'IRANYekan',serif !important;
  max-width: 100%;
}
strike{
  font-family: 'IRANYekan',serif !important;
  max-width: 100%;
}
b{
  font-family: 'IRANYekan',serif !important;
  max-width: 100%;
}
li{
  font-family: 'IRANYekan',serif !important;
  max-width: 100%;
}h1{
   font-family: 'IRANYekan',serif !important;
   max-width: 100%;
 }h2{
    font-family: 'IRANYekan',serif !important;
    max-width: 100%;
  }h3{
     font-family: 'IRANYekan',serif !important;
     max-width: 100%;
   }h4{
      font-family: 'IRANYekan',serif !important;
      max-width: 100%;
    }h5{
       font-family: 'IRANYekan',serif !important;
       max-width: 100%;
     }h6{
        font-family: 'IRANYekan',serif !important;
        max-width: 100%;
      }strong{
         font-family: 'IRANYekan',serif !important;
         max-width: 100%;
       }label{
          font-family: 'IRANYekan',serif !important;
        }font{
           font-family: 'IRANYekan',serif !important;
         }a{
            font-family: 'IRANYekan',serif !important;
          }
.mybtn{
  width: 100%;
  text-align: center;
  margin:20px;
  height: 45px;
  background-color: var(--va-basecolor);
  color:white;
  border-radius: 10px;
  border:unset
}
.mybtn2{
  width: 92%;
  text-align: center;
  margin:20px;
  height: 45px;
  background-color: var(--va-basecolor);
  color:white;
  border-radius: 10px;
  border:unset;
  cursor:pointer;
}
.line{
  height: 5px;
  width:60%;
  margin:0 20% 20px 20%;
  text-align: center;
}
.header {
  /*height: 45px;*/
  /*position: absolute;*/
  /*left: 0;*/
  /*top: 0;*/
  /*width: 100%;*/
  /*max-width: 540px;*/
  background-color: white;
  /*text-align: center;*/

  position: fixed;
  text-align: center;
  /*color: white;*/
  width: 100% !important;
  max-width: 540px !important;
  right: unset !important;
  left: unset !important;
}
.footer {
  position: fixed;
  bottom: 0;
  /*width: 100%;*/
  /*max-width: 540px;*/
  color: white;
  /*text-align: center;*/
  /*height: 100px;*/
  width: 100% !important;
  max-width: 540px !important;
  right: unset !important;
  left: unset !important;
}
.btn {
  cursor: pointer;
  display: inline-block;
  font-weight: 400;
  line-height: 1;
  color: #6e6b7b;
  text-align: center;
  vertical-align: middle;
  cursor: pointer;
  -webkit-user-select: none;
  -moz-user-select: none;
  user-select: none;
  background-color: transparent;
  border: 1px solid transparent;
  border-top-color: transparent;
  border-right-color: transparent;
  border-bottom-color: transparent;
  border-left-color: transparent;
  padding: .786rem 1.5rem;
  font-size: 1rem;
  border-radius: .358rem;
  transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out,background 0s,border 0s;
}
.btn-primary {
  border-color: var(--va-basecolor) !important;
  background-color: var(--va-basecolor) !important;
  color: #fff !important;
}
.mycard {
  /* Add shadows to create the "card" effect */
  box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
  transition: 0.3s;
  border-radius: 10px;
  background-color: white;
}
.swal2-title{
  font-size: 20px;
  font-family: 'IRANYekan',serif !important;
}
/* On mouse-over, add a deeper shadow */
.mycard:hover {
  box-shadow: 0 8px 16px 0 rgba(0,0,0,0.3);
}
pre {
  white-space: pre-wrap;       /* Since CSS 2.1 */
  white-space: -moz-pre-wrap;  /* Mozilla, since 1999 */
  white-space: -pre-wrap;      /* Opera 4-6 */
  white-space: -o-pre-wrap;    /* Opera 7 */
  word-wrap: break-word;       /* Internet Explorer 5.5+ */
  font-family: 'IRANYekan',serif !important;
}
.Vue-Toastification__toast-body{
  direction: rtl;
}
.Vue-Toastification__toast--success{
  background-color: #34cc73 !important;
}
.va-avatar{
  margin-right: unset !important;
}
video::-internal-media-controls-download-button {
  display:none;
}

video::-webkit-media-controls-enclosure {
  overflow:hidden;
}

video::-webkit-media-controls-panel {
  width: calc(100% + 30px); /* Adjust as needed */
}
.insbtn{
  width: 92%;
  text-align: center;
  margin:3%;
  height: 45px;
  background-color: dodgerblue;
  color:white;
  border-radius: 10px;
  border:unset;
  cursor: pointer;
}
</style>