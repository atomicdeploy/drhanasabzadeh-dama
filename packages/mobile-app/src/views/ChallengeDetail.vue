<template>
  <Header  @headeropenMenu="this.homeOpenMenu()" :isHome="0"/>
 <SideMenu :openMenu="this.openMenu" @headercloseMenu="this.headerCloseMenu()" :group_ref="0"/>

  <div class="row">
    <p style="font-size: 15px;width: 50%;padding: 3% 3% 3% 0">جزئیات چالش</p>
    <p style="font-size: 13px;width: 50%;text-align: left;padding: 3% 3% 3% 2%">
      <font-awesome-icon icon="fa-solid fa-caret-down" style="font-size: 0.75rem;padding-left: 4px"/>
    </p>

  </div>
  <Loading v-if="this.geted===1" />

  <div  v-if="this.geted===2" style="margin: 3% 3% 0 3%">
    <div class="mycard" style="width:100%;margin: 5% 0 5% 0;padding: 0 0 3% 0;border-radius: 20px !important;">
      <div class="row"  style="padding: unset" oncontextmenu="return false;">
<!--        <img :src="this.baseurl+'/images/course/'+this.challengeCoverPic" style="width:100%;height: 200px;border-radius: 20px 15px 0 0 ">-->
        <img v-if="this.file_type==='pic'" :src="this.file_url" style="width:100%;height: 200px;border-radius: 20px 15px 0 0 ">
        <video v-else-if="this.file_type==='audio' && this.iswebapp===true" controlsList="nodownload"  controls oncontextmenu="return false;" style="border-top-right-radius: 20px;border-top-left-radius: 20px;width: 100%;height: 100px">
          <source :src="this.file_url"  type="video/mp4" />
        </video>
        <video v-else-if="this.iswebapp===true" controlsList="nodownload"  controls oncontextmenu="return false;" style="border-top-right-radius: 20px;border-top-left-radius: 20px;width: 100%">
          <source :src="this.file_url"  type="video/mp4" />
        </video>
       </div>
      <div class="row" style="padding: unset">
        <p style="font-size: 15px;padding: 4% 3% 5% 0;width: 88%">{{ this.challengeName }}</p>
      </div>
      <div style="width: 96%;height:1px;background-color: #d0d0d0;margin: 4% 2% 4% 2%"></div>


      <p style="width: 100%;padding: 3%;font-weight: bold;font-size: 15px">توضیحات چالش</p>
      <div v-if="this.is_short===1" v-html="this.challengeShortComment" style="width: 100%;padding: 3%;  line-height: 1.6;">

      </div>
      <div v-else  v-html="this.challengeComment" style="width: 100%;padding: 3%;  line-height: 1.6;">
      </div>
      <div v-if="this.is_short===1 && this.challengeComment!==this.challengeShortComment" @click="this.is_short=0" class="row" style="text-align: center;cursor:pointer">
        <span style="width: 50%;direction: ltr;text-align: left;color:#8a8a8a">بیشتر</span>
        <p style="margin-top: -1%">
          <va-icon style="width: 42%;direction: rtl;text-align: right;margin-bottom: 5%;color:#8a8a8a" class="material-icons">expand_more</va-icon>
        </p>
      </div>
      <div v-else-if="this.is_short===0 && this.challengeComment!==this.challengeShortComment"  @click="this.is_short=1" class="row" style="text-align: center;cursor:pointer">
        <span style="width: 50%;direction: ltr;text-align: left;color:#8a8a8a">کمتر</span>
        <p style="margin-top: -1%">
          <va-icon style="width: 42%;direction: rtl;text-align: right;margin-bottom: 5%;color: #8a8a8a" class="material-icons">expand_less</va-icon>
        </p>
      </div>
      <button @click="this.open()" class="buybtn" type="button" >
        <font-awesome-icon icon="fa-solid fa-caret-down" style="font-size: 0.75rem;padding-left: 4px"/>
        شرکت در چالش
      </button>
    </div>
  </div>

  <div  v-if="this.geted===2" class="mycard" style="width:94%;margin: 5% 3% 5% 3%;border-radius: 20px;padding-bottom: 1%">
    <div class="row">
      <p style="padding: 5% 3% 3% 3%;font-weight: bold;width: 80%">نظرات کاربران</p>

    </div>
    <p v-if="this.comments.length===0" style="width: 100%;text-align: center;margin: 10% 0 8% 0">هیچ نظری تا کنون ثبت نشده است</p>
    <div v-for="comment in comments" :key="comment.id" v-if="this.geted===2" class="mycard" style="width:94%;margin: 5% 3% 5% 3%;border-radius: 20px">
      <div class="row" style="padding: 2% 2% 0 2%">
        <div style="width: 45px;border-radius: 45px;height:45px">
          <font-awesome-icon v-if="comment.profilepic==='nopic'" icon="fa-solid fa-circle-user" style="width: 40px;height: 40px;font-size: 1.9rem"  :style="{ color: '#bebebe' }"/>
          <!--         <img v-if="comment.profilepic==='nopic'" style="width: 45px;height: 45px" class="img-contact" src="../assets/images/walletgood.png">-->
          <img v-else style="width: 40px;height: 40px" class="img-contact" :src="this.baseurl+'/images/profile/'+comment.profilepic">
        </div>
        <div style="width: 45%;margin: 12px 10px 0 0">{{comment.name}}</div>
      </div>

      <div v-if="comment.type==='pic'" style="text-align: center">
        <img :src="this.baseurl+'/images/comment/'+comment.file" style="max-height:200px;margin:2% 2% 1% 2%; border-radius:5px ">
      </div>
      <video v-else-if="comment.type==='audio'"  controlsList="nodownload"  controls oncontextmenu="return false;" style="border-top-right-radius: 20px;border-top-left-radius: 20px;width: 100%;height: 100px">
        <source :src="this.baseurl+'/images/comment/'+comment.file"  type="video/mp4" />
      </video>
      <video v-else-if="comment.type==='video'" controlsList="nodownload"  controls oncontextmenu="return false;" style="border-top-right-radius: 20px;border-top-left-radius: 20px;width: 100%">
        <source :src="this.baseurl+'/images/comment/'+comment.file"  type="video/mp4" />
      </video>
      <pre style="width: 100%;padding: 2% 3% 4% 3%;direction: rtl;line-height: 1.4;">{{comment.comment}}</pre>
      <div v-if="comment.job!=='' && comment.job!==null && comment.show_name===1" class="row" style="width: 100%;margin: 7px 5px 0 0">
        <va-badge :text="'حوزه فعالیت:'+comment.job" color="warning" text-color="white" style="margin-left: 5px;text-align: left;"/>
        <va-badge @click="this.openTel(comment.mobile)" :text="comment.mobile" color="warning" text-color="white" style="margin-left: 3px;text-align: left;"/>
      </div>
      <p style="width: 100%;text-align: left;direction: rtl;padding:1% 0 2% 4%;color:#a4a4a4;font-size: 13px;">{{comment.date}}</p>
    </div>
  </div>

  <div style="position: relative;width: 100%">
    <Footer :selected_num="3" />
  </div>

  <div id="myModal" class="modal" style="position: absolute !important;max-width: 540px">
    <!-- Modal content -->
    <div  class="modal-content" style="max-width: 540px;border-top-left-radius: 20px;border-top-right-radius: 20px;">
      <div class="row">
        <p style="width: 80%;padding:5% 5% 0 0">ارسال نظر و شرکت در چالش</p>
        <div style="width: 15%;margin:15px 0 5px 0;text-align: left">
          <va-avatar style="cursor: pointer" size="small"  @click="this.close()" class="mr-4" color="red"><span style="font-size: 35px;margin-top: 5px">&times;</span></va-avatar>
        </div>
      </div>
      <hr/>
      <div style="width:96%;margin: 15px 2% 1px 2%;padding:0 10px 10px 10px ;cursor: pointer;border-radius: 15px;">
        <div class="row" style="margin: 20px 0 20px 0">
          <input v-model="this.show_name" type="checkbox" class="va-checkbox__square" id="shname">
          <label for="shname" style="margin: 1px 5px 0 10px">نمایش اطلاعات تماس</label>
        </div>

        <div class="row" >
          <p style="width: 70%;padding: 10px 0 0 0">عکس، صدا یا ویدئو (دلخواه):</p>
          <label for="file-upload"  class="custom-file-upload" style="width: 30%;background-color: #6C9FD8;color: white;text-align: center;border-radius: 25px;padding: 8px 0 8px 0;cursor: pointer">
            انتخاب فایل
          </label>
          <input id="file-upload" type="file" @change="getFileName()"/>
        </div>
        <p style="font-size: 12px;color: #8d8c8c;margin: 10px 5px 0 0">حداکثر 10 مگابایت ، فرمت های مجاز: mp3,mp4,jpg,png</p>
        <pre v-if="this.filename!==''" style="direction: ltr;margin: 5px 0 0 0;color: #8d8c8c">{{this.filename}}</pre>



<!--        <p v-if="this.filename!==''" style="direction: ltr;margin: 10px;">{{this.filename}}</p>-->
        <div class="row" style="margin-bottom:2%;margin-top: 30px">
          <p style="width: 100%">نظر شما در مورد این چالش:</p>
        </div>
        <div class="row" style="margin-bottom: 5px">
          <textarea v-model="this.com_comment" type="tel" style="height:60px;width: 96%;padding: 10px" class="comment"></textarea>
        </div>
        <p v-if="this.geted_upload===1" style="font-size: 12px;margin-bottom: 1px">در حال آپلود فایل (چند دقیقه منتظر بمانید)</p>
        <va-progress-bar v-if="this.geted_upload===1" indeterminate color="var(--va-basecolor)"/>
        <button v-if="this.getedCom===1" class="comment_btn" type="button" style="margin:2% 0 0 0;text-align: center;">
          <div style="width: 100%;text-align: center">
            <va-progress-circle style="margin: 0 45% 0 45%" size="2.5rem" indeterminate color="white" thickness="0.25" />
          </div>
        </button>
        <button v-else @click="this.sendCommentChallenge()" class="comment_btn" type="button" style="margin: 2% 0 0 0;text-align: center;">
          ارسال نظر
        </button>
      </div>
    </div>

  </div>

</template>

<script>
import { library } from '@fortawesome/fontawesome-svg-core'
import Loading from '../components/Loading.vue'
import Header from '../components/Header.vue'
import Footer from '../components/Footer.vue'
import SubHeader from '../components/SubHeader.vue'
import SideMenu from '../components/SideMenu.vue'
import { faBars,faBookOpenReader,faTv,faUserGroup,faCaretDown,faChartColumn,faLock,faPlus,faCircleUser,faAngleDown,faBookmark as faBookmarked,faRotateLeft,faRotateRight,faGaugeSimpleHigh,faCar} from '@fortawesome/free-solid-svg-icons'
import { faBell,faComments,faCircleCheck,faUser,faEye,faClock,faBookmark,faCirclePlay,faCirclePause } from '@fortawesome/free-regular-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

import {useToast} from "vue-toastification";
library.add(faBars,faBell,faBookOpenReader,faTv,faUserGroup,faComments,faCircleCheck,faUser,faEye,faCaretDown,faClock,faChartColumn,faLock,faPlus,faCircleUser,faAngleDown,faBookmark,faBookmarked,faRotateLeft,faRotateRight,faCirclePlay,faCirclePause,faGaugeSimpleHigh,faCar)
export default {
  name: "Meets",
  components: {
    Loading,SideMenu,Header,SubHeader,Footer,FontAwesomeIcon,
  },
  mounted() {
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
    openTel(tel){
      document.location.href="tel:"+tel;
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
    moreComment(){

      this.getedMore=1;
      const mydata = {
        action:'moreComment',
        CourseRef:this.$route.params.id,
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
              this.getedMore=2;
              this.comments=response.data.comments;
            }
            else if(response.data.ok===3){
              localStorage.setItem('tk', "");
              this.$router.push({ path: '/mobile' })
            }
            else{
              if(response.data.ok===4){
                localStorage.setItem('tk', "");
              }
              this.getedMore=3;
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
            this.getedMore = 3;
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
    sendCommentChallenge(){
      if(localStorage.getItem('tk')==="" || localStorage.getItem('tk')===null){
        this.loginDialog=true;
        return
      }
      var err='';
      if(this.fname===''){
        err='نام خود را وارد کنید';
      }
      else if(this.lname===''){
        err='نام خانوادگی خود را وارد کنید';
      }
      else if(this.com_comment===''){
        err='نظر خود را وارد کنید';
      }
      if(err!==''){
        this.$swal({
          title: this.$t('General.error'),
          text: err,
          icon: 'error',
          confirmButtonText:this.$t('General.ok'),
          customClass: {
            confirmButton: 'btn btn-primary'
          },
          buttonsStyling: false
        });
        return;
      }
      this.getedCom=1;
      const file = document.querySelector('#file-upload');
      const mydata = {
        action:'sendCommentChallenge',
        ChallengeRef:this.$route.params.id,
        show_name:this.show_name===true?1:0,
        comment:this.com_comment,
        lang:this.$i18n.locale,
      };
      if(file.files.length!==0){
        this.geted_upload=1;
        mydata.file=file.files[0]
      }

      this.$http(
          {
            method: "post",
            url: this.apiurl,
            timeout: 1000 * 30, // Wait for 5 seconds
            data: mydata,
            headers: {
              'Content-Type': 'multipart/form-data',
              "Authorization": `Bearer ${localStorage.getItem('tk')}`
            },
          })
          .then((response) => {
            document.getElementById("file-upload").value='';
            this.filename='';

            if(response.data.ok===1){
              this.getedCom=2;
              this.geted_upload=0;
              this.close();
              this.com_comment="";
              this.$swal({
                title: 'نظر شما ارسال شد',
                text: "پس از تایید در همین قسمت نمایش داده خواهد شد.",
                icon: 'success',
                confirmButtonText:this.$t('General.ok'),
                customClass: {
                  confirmButton: 'btn btn-primary'
                },
                buttonsStyling: false
              });
            }
            else if(response.data.ok===3){
              localStorage.setItem('tk', "");
              this.$router.push({ path: '/mobile' })
            }
            else{
              if(response.data.ok===4){
                localStorage.setItem('tk', "");
              }
              this.getedCom=3;
              this.geted_upload=0;
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
            this.getedCom = 3;
            this.geted_upload=0;
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
    goToPage(page){
      this.$router.push({ path: page})
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
        action:'challengeDetail',
        ChallengeRef:this.$route.params.id,
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
              this.challengeName=response.data.challengeName;
              this.challengeShortComment=response.data.challengeShortComment;
              this.challengeComment=response.data.challengeComment;
              this.challengeCoverPic=response.data.challengeCoverPic;
              this.comments=response.data.comments;
              this.file_type=response.data.file_type;
              this.file_url=response.data.file_url;
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
      loginDialog:false,
      geted:0,
      getedCom:0,
      geted_upload:0,
      getedMore:0,
      openMenu:false,
      formatter : new Intl.NumberFormat('en', {
        maximumFractionDigits:0,
      }),
      data:[],
      challengeName:"",
      challengeShortComment:"",
      challengeComment:"",
      challengeCoverPic:"",
      comments:[],
      is_short:1,
      show_name:true,
      com_comment:"",
      filename:"",
      file_type:"",
      file_url:"",
      iswebapp:false,

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
.va-checkbox__square{
  height: 1.15rem !important;
  min-width: 1.15rem !important;
  width: 1.15rem !important;
}

</style>