<template>
  <router-view v-if="1===1"/>
  <div v-else-if="!this.iswebapp && (this.device==='iPhone' || this.device==='iPad' || this.device==='iPod')">
    <div style="width: 100%;text-align: center">
      <img style="width:70% !important;margin-top:20px;" src="./assets/logo.png">
      <p style="margin-top:20px;">نسخه وب اپلیکیشن {{this.appname}}</p>
      <div style="margin: 5%;background-color: #b4ffce;padding: 2%;border-radius: 15px">
        <p style="margin: 4% 0 4% 0;text-align: right">* از مرورگر safari <span style="top: 5px;position: relative;"><img style="height: 20px;" src="./assets/images/safari.png"></span> استفاده کنید</p>
        <p style="margin: 4% 0 0 0;text-align: right">1- در پایین صفحه گزینه <span style="top: 5px;position: relative;"><img style="width:25px " src="./assets/images/add1.png"></span> <font-awesome-icon icon="fa-solid fa-ellipsis-vertical" /> را انتخاب کنید</p>
        <p style="margin: 4% 0 0 0;text-align: right">2- گزینه Add to Home screen  <img style="top: 5px;position: relative;width:20px " src="./assets/images/add2.png"> را انتخاب کنید.</p>
        <p style="margin: 4% 0 0 0;text-align: right">3- در بالای صفحه گزینه ی <span style="color: dodgerblue;font-weight: bold">Add</span> را انتخاب کنید. </p>
        <p style="margin: 4% 0 0 0;text-align: right">4- اپلیکیشن {{this.appname}} به صفحه اصلی گوشی شما اضافه شده است.</p>
      </div>
    </div>
  </div>
  <div v-else-if="!this.iswebapp && this.device==='Android'">
    <div style="width: 100%;text-align: center">
      <img style="height: 100px;margin-top:20px;" src="./assets/logo.png">
      <p style="margin-top:20px;">نسخه وب اپلیکیشن {{this.appname}}</p>
      <div style="margin: 5%;background-color: #b4ffce;padding: 2%;border-radius: 15px">
        <p style="margin: 4% 0 4% 0;text-align: right">* از مرورگر کروم <span style="top: 5px;position: relative;"><img style="height: 20px;" src="./assets/images/chrome.png"></span> استفاده کنید</p>
        <p style="margin: 4% 0 0 0;text-align: right">1- منو <span style="top: 5px;position: relative;"><vue-feather type="more-vertical" size="22" ></vue-feather></span> <font-awesome-icon icon="fa-solid fa-ellipsis-vertical" /> را باز کنید</p>
        <p style="margin: 4% 0 0 0;text-align: right">2- گزینه Add to Home screen یا Install app یا (افزودن به صفحه اصلی) را انتخاب کنید.</p>
        <p style="margin: 4% 0 0 0;text-align: right">3- اپلیکیشن {{this.appname}} به صفحه اصلی گوشی شما اضافه شده است.</p>
      </div>
    </div>
  </div>
  <div v-else-if="!this.iswebapp && this.device!=='Windows'">
    <div style="width: 100%;text-align: center">
      <img style="width:70% !important;margin-top:20px;" src="./assets/logo.png">
      <p style="margin-top:20px;">نسخه وب اپلیکیشن {{this.appname}}</p>
      <div style="margin: 5%;background-color: #b4ffce;padding: 2%;border-radius: 15px">
        <p style="margin: 4% 0 4% 0;text-align: right">* از مرورگر safari <span style="top: 5px;position: relative;"><img style="height: 20px;" src="./assets/images/safari.png"></span> استفاده کنید</p>
        <p style="margin: 4% 0 0 0;text-align: right">1- در پایین صفحه گزینه <span style="top: 5px;position: relative;"><img style="width:25px " src="./assets/images/add1.png"></span> <font-awesome-icon icon="fa-solid fa-ellipsis-vertical" /> را انتخاب کنید</p>
        <p style="margin: 4% 0 0 0;text-align: right">2- گزینه Add to Home screen  <img style="top: 5px;position: relative;width:20px " src="./assets/images/add2.png"> را انتخاب کنید.</p>
        <p style="margin: 4% 0 0 0;text-align: right">3- در بالای صفحه گزینه ی <span style="color: dodgerblue;font-weight: bold">Add</span> را انتخاب کنید. </p>
        <p style="margin: 4% 0 0 0;text-align: right">4- اپلیکیشن {{this.appname}} به صفحه اصلی گوشی شما اضافه شده است.</p>
      </div>
    </div>
  </div>

  <router-view v-else/>
</template>
<script>
export default {
  mounted() {
    if(localStorage.getItem('lang')===null){
      this.$i18n.locale='fa'
    }
    else{
      this.$i18n.locale = localStorage.getItem('lang');
    }

  this.isInStandaloneMode();
  this.getDevice();
  // this.getBrowser();
    if(this.$t('config.dir')==='rtl'){
      const body = document.body;
      body.style.direction = "rtl";
    }
    ////
    // window.addEventListener('beforeinstallprompt', this.handleBeforeInstallPrompt);

    // this.showInstallPrompt();
 },
  beforeDestroy() {
    window.removeEventListener('beforeinstallprompt', this.handleBeforeInstallPrompt);
  },
  data(){
    return{
      iswebapp:false,
      device:"",
      browser:""
    }
  },
  methods:{
    handleBeforeInstallPrompt(event) {
      // جلوگیری از نمایش پیش‌فرض بارگیری مرورگر
      event.preventDefault();
      // ذخیره رویداد نصب برای استفاده بعدی
      this.installPromptEvent = event;
      // نمایش پیام به کاربر یا هر اقدام دیگر مورد نظرتان
      this.showInstallPrompt();
    },

    showInstallPrompt() {
      // نمایش پیام به کاربر و درخواست نصب
      this.installPromptEvent.prompt();
      // دریافت پاسخ از کاربر
      this.installPromptEvent.userChoice.then((choiceResult) => {
        if (choiceResult.outcome === 'accepted') {
          console.log('کاربر پیشنهاد نصب را قبول کرد');
        } else {
          console.log('کاربر پیشنهاد نصب را رد کرد');
        }
        // حذف رویداد نصب بعد از استفاده
        this.installPromptEvent = null;
      });
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

@import './assets/font.css';
@import url('./assets/fontgoogleapis.css');
@import url('./assets/googlematerial.css');
/*@import url('./assets/dark.css');*/
@import url('./assets/light.css');


#app{
  min-height: 100vh;
  height: 100%;
}
input{
  background: unset;
}
body{
  max-width: 540px !important;
  margin: 0 auto !important;
  font-family: 'IRANYekan',serif !important;
}
td{
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

  /*text-align: center;*/

  position: fixed;
  text-align: center;
  /*color: white;*/
  width: 100% !important;
  max-width: 540px !important;
  right: unset !important;
  left: unset !important;
  z-index: 100;
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
/*.Vue-Toastification__toast-body{*/
/*  direction: rtl;*/
/*}*/
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
.g-dialog-content{
  border-radius: 15px !important;
}

/* beauty scroll */
::-webkit-scrollbar {
  width: 20px;
}

::-webkit-scrollbar-track {
  background-color: transparent;
}

::-webkit-scrollbar-thumb {
  background-color: #d6dee1;
  border-radius: 20px;
  border: 6px solid transparent;
  background-clip: content-box;
}

::-webkit-scrollbar-thumb:hover {
  background-color: #a8bbbf;
}
.rtl_lang{
  direction: rtl;
  text-align: right;
}
.ltr_lang{
  direction: ltr;
  text-align: left;
}
.row {
  display: flex;
  flex-wrap: wrap;
}
.myradio{
  width: 20px;
  height: 20px;
}
.justify-center {
  justify-content: center;
}

</style>

