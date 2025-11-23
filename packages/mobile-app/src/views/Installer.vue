<template>
  <!--  <router-view v-if="1===1"/>-->
  <Header   @headeropenMenu="this.homeOpenMenu()"  :isHome="0"/>
  <SideMenu :openMenu="this.openMenu" @headercloseMenu="this.headerCloseMenu()" :group_ref="0" />
  <div v-if="this.$i18n.locale==='fa'">
    <div v-if="!this.iswebapp">

      <transition>
       <div v-if="this.mobile_type===''" >
         <div style="width:20% !important;height: 50px" ></div>
         <p style="margin-top:20px;text-align: center">نصب اپلیکیشن <b>{{this.appname}}</b></p>
         <img v-if="this.appdirectory==='27'" src="../assets/images/installer.jpg" style="width: 100%;margin-top: 30px">
         <div v-if="this.appdirectory==='27'" style="width:20% !important;height: 50px" ></div>
         <div v-else style="width:20% !important;height: 150px" ></div>
         <div style="background: white;border-radius: 15px" class="polaroid">
           <p style="margin:20px 20px 30px 0;text-align: right">نوع گوشی خود را انتخاب کنید</p>
           <div class="row" style="width: 100%;">
             <div style="width:5%">&nbsp;</div>
             <div @click="this.mobile_type='ios'" style="width:43%;;text-align: center;padding: 10px;border-radius: 10px;color: white;background: #b2b2b2;cursor: pointer" :class="{activeI:this.mobile_type==='ios',deactiveI:this.mobile_type==='android'}">گوشی آیفون</div>
             <div style="width:4%">&nbsp;</div>
             <div @click="this.mobile_type='android'" style="width:43%;text-align: center;padding: 10px;border-radius: 10px;color: white;background: #b2b2b2;;cursor: pointer" :class="{activeI:this.mobile_type==='android',deactiveI:this.mobile_type==='ios'}">گوشی اندروید</div>
             <div style="width:5%">&nbsp;</div>
           </div>
         </div>

       </div>
      </transition>
      <div v-if="this.mobile_type!==''" >
        <div style="width:20% !important;height: 70px" ></div>
      <div style="background: white;border-radius: 15px" >
        <div class="row" style="width: 100%;">
          <div style="width:5%">&nbsp;</div>
          <div @click="this.mobile_type='ios'" style="width:43%;;text-align: center;padding: 10px;border-radius: 10px;color: white;background: #b2b2b2;" :class="{activeI:this.mobile_type==='ios',deactiveI:this.mobile_type==='android'}">گوشی آیفون</div>
          <div style="width:4%">&nbsp;</div>
          <div @click="this.mobile_type='android'" style="width:43%;text-align: center;padding: 10px;border-radius: 10px;color: white;background: #b2b2b2;" :class="{activeI:this.mobile_type==='android',deactiveI:this.mobile_type==='ios'}">گوشی اندروید</div>
          <div style="width:5%">&nbsp;</div>
        </div>
      </div>
      </div>

      <transition>
          <div v-if="mobile_type==='android'">
            <div v-if="this.android_link!=='undefined' && this.android_link!==''" style="width: 100%;text-align: center">
              <div style="margin: 5%;background-color: #b4ffce;padding: 2%;border-radius: 15px">
                <p style="margin: 4% 0 0 0;text-align: right"><span style="top: 6px;position: relative;margin-left: 5px"><img style="width:20px " src="../assets/images/android.png"></span> نسخه اندروید: </p>
                <p style="margin: 4% 0 0 0;text-align: right">با انتخاب گزینه زیر فایل برنامه را دانلود و سپس آن را نصب کنید</p>
                <a :href="this.android_link" class="insbtn" type="button" style="padding-top:12px;margin: 25px 4% 10px 4%;text-align: center;background-color:#656565">
                  دانلود اپلیکیشن اندروید
                </a>
              </div>
            </div>
            <div style="width: 100%;text-align: center">
              <div style="margin: 5%;background-color: #ffffb4;padding: 2%;border-radius: 15px">
                <p style="margin: 4% 0 0 0;text-align: right"><span style="top: 5px;position: relative;margin-left: 5px"><img style="width:20px " src="../assets/images/web.png"></span> نسخه وب اپلیکیشن: </p>
                <p style="margin: 4% 0 0 0;text-align: right">با انتخاب گزینه زیر اپلیکیشن را نصب کنید</p>
                <div style="margin-top: 5%;background-color: #f0f2ff;padding: 1px 5px 20px 5px;border-radius: 15px;">
                  <p style="margin: 4% 0 4% 0;text-align: right">1- حتما لینک را با مرورگر (کروم <span style="top: 5px;position: relative;"><img style="height: 20px;" src="../assets/images/chrome.png"></span>)  باز کنید</p>
                  <p style="margin: 4% 0 0 0;text-align: right">2- در صورت مشاهده پیغام خطا در نصب ، مجددا بر روی گزینه نصب بزنید</p>
                  <p style="margin: 4% 0 0 0;text-align: right">3- کمی منتظر بمانید تا پیغام اتمام نصب نمایش داده شود</p>
                  <p style="margin: 4% 0 0 0;text-align: right">4- الان آیکن اپلیکیشن به صفحه اصلی گوشی شما اضافه شده ، این صفحه رو ببندید و بر روی آیکن اپلیکیشن بزنید</p>
                </div>
                <button @click="this.myinstall()"  class="insbtn" type="button" style="margin: 25px 4% 10px 4%;text-align: center;background-color:#656565">
                  نصب وب اپلیکیشن
                </button>
              </div>
            </div>
          </div>
      </transition>
      <transition>
          <div v-if="mobile_type==='ios'">
            <p style="margin: 4% 4% 1% 0;text-align: right;font-weight: bold">* حتما از مرورگر (safari <span style="top: 5px;position: relative;"><img style="height: 20px;" src="../assets/images/safari.png"></span>)  استفاده کنید</p>
            <p style="color: #5d5d5d;font-size: 12px;margin: 1% 5% 4% 0;text-align: right">مرورگر پیش فرض اینستاگرام قابلیت نصب ندارد</p>
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
      </transition>

    </div>
  </div>
  <div v-else>
    <div v-if="!this.iswebapp && (this.device==='iPhone' || this.device==='iPad' || this.device==='iPod')">
      <div style="width: 100%">
        <div style="text-align: center">
          <img style="width:50% !important;margin-top:30px " :src="this.baseurl+'/images/apps/'+this.logo">
        </div>

        <p style="margin-top:20px;text-align: center">Web version of {{this.appname_en}} application </p>
        <div style="margin: 5%;background-color: #b4ffce;padding: 2%;border-radius: 15px">
          <p style="margin: 4% 0 0 0">1- Select the <span style="top: 5px;position: relative;"><img style="width:25px " src="../assets/images/add1.png"></span> <font-awesome-icon icon="fa-solid fa-ellipsis-vertical" /> option at the bottom of the page</p>
          <p style="margin: 4% 0 0 0">2- Select the Add to Home screen <img style="top: 5px;position: relative;width:20px " src="../assets/images/add2.png"> option</p>
          <p style="margin: 4% 0 0 0">3- Select the <span style="color: dodgerblue;font-weight: bold">Add</span> option at the top of the page. </p>
          <p style="margin: 4% 0 0 0">4- The {{ this.appname_en }} app has been added to your phone's home screen.</p>
          <p style="margin: 4% 0 4% 0">* Use the Safari <span style="top: 5px;position: relative;"><img style="height: 20px;" src="../assets/images/safari.png"></span> browser</p>
        </div>
      </div>
    </div>
    <div v-else-if="!this.iswebapp && this.device==='Android'">
      <div style="width: 100%;">
        <div style="text-align: center">
          <img style="width:50% !important;margin-top:30px;" :src="this.baseurl+'/images/apps/'+this.logo">
        </div>
        <p style="margin-top:20px;text-align: center">Web version of {{this.appname_en}} application</p>
        <div style="margin: 5%;background-color: #b4ffce;padding: 2%;border-radius: 15px">
          <p style="margin: 4% 0 0 0">1- Open the <span style="top: 5px;position: relative;"><vue-feather type="more-vertical" size="22" ></vue-feather></span> <font-awesome-icon icon="fa-solid fa-ellipsis-vertical" /> menu</p>
          <p style="margin: 4% 0 0 0">2- Select Add to Home screen or Install app option.</p>
          <p style="margin: 4% 0 0 0">3- The {{ this.appname_en }} app has been added to your phone's home screen.</p>
          <p style="margin: 4% 0 4% 0">* Use the Chrome <span style="top: 5px;position: relative;"><img style="height: 20px;" src="../assets/images/chrome.png"></span> browser</p>
        </div>
      </div>
    </div>
    <div v-else>
      <div style="width: 100%">
        <div style="text-align: center;margin-top:30px">
          <img style="width:50% !important;" :src="this.baseurl+'/images/apps/'+this.logo">
        </div>
        <p style="margin-top:20px;">Web version of {{this.appname_en}} application </p>
        <div style="margin: 5%;background-color: #b4ffce;padding: 2%;border-radius: 15px">
          <p style="margin: 4% 0 0 0">1- Select the <span style="top: 5px;position: relative;"><img style="width:25px " src="../assets/images/add1.png"></span> <font-awesome-icon icon="fa-solid fa-ellipsis-vertical" /> option at the bottom of the page</p>
          <p style="margin: 4% 0 0 0">2- Select the Add to Home screen <img style="top: 5px;position: relative;width:20px " src="../assets/images/add2.png"> option</p>
          <p style="margin: 4% 0 0 0">3- Select the <span style="color: dodgerblue;font-weight: bold">Add</span> option at the top of the page. </p>
          <p style="margin: 4% 0 0 0">4- The {{ this.appname_en }} app has been added to your phone's home screen.</p>
          <p style="margin: 4% 0 4% 0">* Use the Safari <span style="top: 5px;position: relative;"><img style="height: 20px;" src="../assets/images/safari.png"></span> browser</p>
        </div>
      </div>
    </div>
  </div>

  <hr style="margin: 0 30px 25px 30px"/>
  <button v-if="this.mobile_type===''" @click="this.goToPage('/')"  class="insbtn" type="button" style="text-align: center;position: absolute;bottom: 30px;">
    {{ $t('Installer.installLater') }}
  </button>
  <button v-else @click="this.goToPage('/')"  class="insbtn" type="button" style="text-align: center;">
    {{ $t('Installer.installLater') }}
  </button>
</template>
<script>
import Header from '../components/Header.vue'
import SideMenu from '../components/SideMenu.vue'
import {useToast} from "vue-toastification";
export default {

  mounted() {
    if(this.$route.query.try==="1"){
      this.mobile_type='android'
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
      deferredPrompt: null,
      mobile_type:""
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
  background-color: #FAFAFA;
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
.activeI{
  background: dodgerblue !important;
}
.deactiveI{
  background: #b2b2b2 !important;
}
.v-enter-active,
.v-leave-active {
  transition: opacity 0.5s ease;
}

.v-enter-from,
.v-leave-to {
  opacity: 0;
}
div.polaroid {
  margin: 0 15px 0 15px;
  padding: 10px 10px 20px 10px;
  border: 1px solid #BFBFBF;
  background-color: white;
  box-shadow: 10px 10px 5px #cecece;
}
</style>