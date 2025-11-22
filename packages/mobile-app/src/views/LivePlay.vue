<template>
  <Header  @headeropenMenu="this.homeOpenMenu()" :isHome="0"/>
  <SideMenu :openMenu="this.openMenu" @headercloseMenu="this.headerCloseMenu()" :group_ref="0"/>


  <Loading v-if="this.geted===1" />
  <div  v-if="this.geted===2"  >
    <p v-if="this.buyed===0" style="width: 100%;margin-top: 50px;text-align: center">ابتدا باید لایو را خریداری کنید</p>
<!--    <iframe v-else :src="this.link"  :height="this.winH" width="100%" title="description"></iframe>-->
    <iframe v-else :src="this.link" width="100%" :height="this.winH" frameborder="0" allowFullScreen="true" allow="autoplay;fullscreen;speaker;microphone;camera;display-capture"></iframe>
  </div>

</template>

<script>
import { library } from '@fortawesome/fontawesome-svg-core'
import Loading from '../components/Loading.vue'
import Header from '../components/Header.vue'
import Footer from '../components/Footer.vue'
import SubHeader from '../components/SubHeader.vue'
import SideMenu from '../components/SideMenu.vue'
import { faBars,faBookOpenReader,faTv,faUserGroup,faCaretDown,faChartColumn,faLock,faPlus,faCircleUser,faAngleDown,faBookmark as faBookmarked,faRotateLeft,faRotateRight,faGaugeSimpleHigh,faCar,faDisplay} from '@fortawesome/free-solid-svg-icons'
import { faBell,faComments,faCircleCheck,faUser,faEye,faClock,faBookmark,faCirclePlay,faCirclePause } from '@fortawesome/free-regular-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

import {useToast} from "vue-toastification";
library.add(faBars,faBell,faBookOpenReader,faTv,faUserGroup,faComments,faCircleCheck,faUser,faEye,faCaretDown,faClock,faChartColumn,faLock,faPlus,faCircleUser,faAngleDown,faBookmark,faBookmarked,faRotateLeft,faRotateRight,faCirclePlay,faCirclePause,faGaugeSimpleHigh,faCar,faDisplay)
export default {
  name: "LivePlay",
  components: {
    Loading,SideMenu,Header,SubHeader,Footer,FontAwesomeIcon,
  },
  mounted() {
    this.winH = window.innerHeight
    this.isInStandaloneMode();
    this.getRow();
    // window.scrollTo(0,0);
    window.scrollTo({
      top: 0,
      left: 0,
      behavior: 'smooth'
    });
    // window.addEventListener('contextmenu', function (e) {
    //   e.preventDefault();
    // }, false);
  },
  methods:{
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
    getFileName(){
      this.filename= document.getElementById("file-upload").value;
    },
    close(){
      var modal = document.getElementById("myModal");
      modal.style.display = "none";
    },
    open(){
      var modal = document.getElementById("myModal");
      modal.style.display = "block";
    },
    viewLive(){
      if(this.link===''){
        this.myToast("تا شروع لایو منتظر بمانید",2);
      }
      else{
        window.open(this.link,"_self");
      }
    },
    myToast(alert,type){
      if(type===1){
        useToast().success(alert, {
          timeout: 2000,
          position:'top-center',
          rtl: this.$t('config.dir')==='rtl'?true:false
        });
      }
      else if(type===2){
        useToast().warning(alert, {
          timeout: 2000,
          position:'top-center',
          rtl: this.$t('config.dir')==='rtl'?true:false
        });
      }
      else if(type===3){
        useToast().error(alert, {
          timeout: 2000,
          position:'top-center',
          rtl: this.$t('config.dir')==='rtl'?true:false
        });
      }

    },
    getRow(){
      this.geted=1;
      const mydata = {
        action:'livePlay',
        LiveRef:this.$route.params.id,
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
              this.liveName=response.data.liveName;
              this.started_date=response.data.started_date;
              this.started_time=response.data.started_time;
              this.status=response.data.status;
              this.Duration=response.data.Duration;
              this.buyed=response.data.buyed;
              this.link=response.data.link;
              this.geted=2;
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
    homeOpenMenu(){
      this.openMenu=true;
      console.log("homeOpenMenu");
    },
    headerCloseMenu(){
      this.openMenu=false;
      console.log("homeCloseMenu");
    },
  },
  data(){
    return{
      geted:0,
      openMenu:false,
      formatter : new Intl.NumberFormat('en', {
        maximumFractionDigits:0,
      }),
      liveName:"",
      started_date:"",
      started_time:"",
      status:0,
      buyed:0,
      Duration:"",
      iswebapp:false,
      link:"",
      winH:0,

    }
  }
};

</script>
<style>
#outer {
  width: 100%;
  height: 300px;
  -moz-border-radius-topleft: 20px;
  -moz-border-radius-topright: 20px;
  overflow: hidden;
  position: relative;
}

.buybtn{
  width: 92%;
  text-align: center;
  margin:3%;
  height: 45px;
  background-color: var(--va-greencolor);
  color:white;
  border-radius: 10px;
  border:unset;
  cursor: pointer;
}
.va-collapse__header__text{
  padding-right: 3%;
  font-size: 14px;
}

.spinner {
  width: 75px;
  height: 75px;
  display: inline-block;
  border-width: 4px;
  border-color: rgba(255, 255, 255, 0.15);
  border-top-color: #fff;
  animation: spin 1s infinite linear;
  border-radius: 100%;
  border-style: solid;
}
@keyframes spin {
  100% {
    transform: rotate(360deg);
  }
}
.buyallbtn{
  width: 100%;
  text-align: center;
  margin:4% 8% 0 8%;
  height: 45px;
  background-color: var(--va-seccolor);
  color:white;
  border-radius: 10px;
  border:unset
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
/* Add Animation */
@-webkit-keyframes slideIn {
  from {bottom: -300px; opacity: 0}
  to {bottom: 0; opacity: 1}
}

@keyframes slideIn {
  from {bottom: -300px; opacity: 0}
  to {bottom: 0; opacity: 1}
}

@-webkit-keyframes fadeIn {
  from {opacity: 0}
  to {opacity: 1}
}

@keyframes fadeIn {
  from {opacity: 0}
  to {opacity: 1}
}
.name{
  width: 100%;height: 35px;
  text-align: right;
  direction: rtl;
  outline: none !important;
  border-bottom:1px solid #8a8a8a;
  border-top-width:0px;
  border-right-width:0px;
  border-left-width:0px;
  padding-left: 10px;
}
.comment{
  width: 100%;height: 35px;
  text-align: right;
  direction: rtl;
  outline: none !important;
  border:1px solid #8a8a8a;
  border-radius: 10px;
  padding-left: 10px;
}
.comment_btn{
  width: 100%;
  text-align: center;
  margin:3%;
  height: 45px;
  background-color: var(--va-greencolor);
  color:white;
  border-radius: 10px;
  border:unset;
  cursor: pointer;
}
.active_speed{
  color: var(--va-basecolor);
  font-weight: bold;
  font-size: 20px;
}
input[type="file"] {
  display: none;
}
.overlay {
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  position: fixed;
  background: rgba(119, 119, 119, 0.6);
}

.overlay__inner {
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  position: absolute;
}
.overlay__content {
  left: 50%;
  position: absolute;
  top: 50%;
  transform: translate(-50%, -50%);
}
</style>