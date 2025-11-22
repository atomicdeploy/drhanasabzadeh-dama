<template>
  <Header  @headeropenMenu="this.homeOpenMenu()" :isHome="0"/>
  <SideMenu :openMenu="this.openMenu" @headercloseMenu="this.headerCloseMenu()" :group_ref="0"/>
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
  <div v-if="this.getedLink===1" class="overlay">
    <div class="overlay__inner">
      <div class="overlay__content"><span class="spinner"></span></div>
    </div>
  </div>
  <div class="row">
    <p style="font-size: 15px;width: 50%;padding: 3% 3% 3% 0">{{ $t('Live.liveDetail')}}</p>
    <p style="font-size: 13px;width: 50%;text-align: left;padding: 3% 3% 3% 2%">
      <font-awesome-icon icon="fa-solid fa-caret-down" style="font-size: 0.75rem;padding-left: 4px"/>
    </p>

  </div>
  <Loading v-if="this.geted===1"  />

  <div  v-if="this.geted===2" style="margin: 3% 3% 0 3%">
    <div class="mycard" style="width:100%;margin: 5% 0 5% 0;padding: 0 0 3% 0;border-radius: 20px !important;">
      <div class="row"  style="padding: unset" oncontextmenu="return false;">
        <img v-if="this.getedLink!==2" :src="this.baseurl+'/images/live/'+this.liveCoverPic" style="width:100%;height: 200px;border-radius: 20px 15px 0 0 ">
        <video v-else-if="this.file_type==='audio'" autoplay  controlsList="nodownload"  controls oncontextmenu="return false;" style="border-top-right-radius: 20px;border-top-left-radius: 20px;width: 100%;height: 100px">
          <source :src="this.play_url"  type="video/mp4" />
        </video>
        <video v-else autoplay  controlsList="nodownload"  controls oncontextmenu="return false;" style="border-top-right-radius: 20px;border-top-left-radius: 20px;width: 100%">
          <source :src="this.play_url"  type="video/mp4" />
        </video>
       </div>
      <div class="row" style="padding: unset">
        <p style="font-size: 15px;padding: 4% 3% 5% 0;width: 88%">{{ this.liveName }}</p>
      </div>
      <div class="row"  style="padding: unset;margin-left: 2%">
        <font-awesome-icon icon="fa-regular fa-clock" style="font-size: 0.75rem;margin:0 2% 0 2%;color: #5d5d5d"/>
        <span style="font-size: 12px;color:#5d5d5d;width: 60%;margin-top: 1px">{{ this.Duration }}</span>
        <div style="width:30%;text-align: left">
          <va-badge v-if="this.status===0" :text="this.$t('Live.willHeld')" color="danger"  text-color="white" style=" padding-bottom: 2px;color: white"/>
          <va-badge v-else-if="this.status===1" :text="this.$t('Live.playing')" color="warning" text-color="white"  style="padding-bottom: 2px;color: white"/>
          <va-badge v-else-if="this.status===2" :text="this.$t('Live.held')" color="success" text-color="white"  style="padding-bottom: 2px;color: white"/>
        </div>
      </div>
      <div class="row" style="padding-right: 0;margin: 10px 0 0 0">
        <div style="width: 60%;margin-right: 2%">
          <span style="font-size: 12px;color: #5d5d5d">{{ $t('Live.start')}}: {{ this.started_time+" "+this.started_date }}</span>
        </div>
        <div v-if="this.PriceInt===0" style="width: 36%;padding: 0;margin: 1% 0 0 2%">
          <div class="row" style="font-size: 12px;color:var(--va-greencolor);text-align: left;display: block;margin-left: 1%">{{ $t('Live.free')}}</div>
        </div>
        <div v-else-if="this.PriceOffInt===0" style="width: 36%;padding: 0;margin: 1% 0 0 2%">
          <div class="row" style="font-size: 12px;color:var(--va-greencolor);text-align: left;display: block;margin-left: 1%;font-weight: bold">{{this.Price}}</div>
        </div>
        <div v-else style="width: 36%;padding: 0;margin: 1% 0 0 2%">
          <div class="row" style="font-size: 12px;color:#5d5d5d;text-align: left;display: block;margin-left: 1%"><strike>{{this.PriceOff}}</strike></div>
          <div class="row" style="font-size: 12px;color:var(--va-greencolor);text-align: left;display: block;margin-left: 1%;font-weight: bold">{{this.Price}}</div>
        </div>
      </div>
      <div style="width: 96%;height:1px;background-color: #d0d0d0;margin: 4% 2% 4% 2%"></div>
      <button  v-if="this.status===2 && this.buyed===1" @click="this.playVideo()" class="buybtn" type="button" >
        <span style="width: 20px;height: 20px">
          <font-awesome-icon icon="fa-solid fa-display" size="large" :style="{color:'white'}"/>
        {{ $t('LiveDetail.viewLive')}}
          </span>
      </button>
      <button v-else-if="this.buyed===0" @click="this.goToInvoice()" class="buybtn" type="button" >
        <span style="width: 20px;height: 20px">
          <font-awesome-icon icon="fa-solid fa-display" size="large" :style="{color:'white'}"/>
          {{ $t('LiveDetail.buyLive')}}
          </span>
      </button>
      <button v-else-if="this.status!==2 && this.buyed===1" @click="this.viewLive()" class="buybtn" type="button" >
        <span style="width: 20px;height: 20px">
          <font-awesome-icon icon="fa-solid fa-display" size="large" :style="{color:'white'}"/>
       {{ $t('LiveDetail.viewLive')}}
          </span>
      </button>
      <p style="width: 100%;padding: 3%;font-weight: bold;font-size: 15px">{{ $t('LiveDetail.liveDesc')}}</p>
      <div v-if="this.is_short===1" v-html="this.liveShortComment" style="width: 100%;padding: 3%;  line-height: 1.6;">

      </div>
      <div v-else  v-html="this.liveComment" style="width: 100%;padding: 3%;  line-height: 1.6;">
      </div>
      <div v-if="this.is_short===1 && this.liveComment!==this.liveShortComment" @click="this.is_short=0" class="row" style="text-align: center;cursor:pointer">
        <span style="width: 50%;direction: ltr;text-align: left;color:#8a8a8a">{{ $t('LiveDetail.more')}}</span>
        <p style="margin-top: -1%">
          <va-icon style="width: 42%;direction: rtl;text-align: right;margin-bottom: 5%;color:#8a8a8a" class="material-icons">expand_more</va-icon>
        </p>
      </div>
      <div v-else-if="this.is_short===0 && this.liveComment!==this.liveShortComment"  @click="this.is_short=1" class="row" style="text-align: center;cursor:pointer">
        <span style="width: 50%;direction: ltr;text-align: left;color:#8a8a8a">{{ $t('LiveDetail.less')}}</span>
        <p style="margin-top: -1%">
          <va-icon style="width: 42%;direction: rtl;text-align: right;margin-bottom: 5%;color: #8a8a8a" class="material-icons">expand_less</va-icon>
        </p>
      </div>
    </div>
  </div>

  <div  v-if="this.geted===2" class="mycard" style="width:94%;margin: 5% 3% 5% 3%;border-radius: 20px;padding-bottom: 1%">
    <div class="row">
      <p style="padding: 5% 4% 3% 4%;font-weight: bold;width: 50%;margin-top: 1%">{{$t('Meets.userComments')}}</p>
      <div @click="this.open()" style="width: 44%;margin: 1% 3% 0 3%;">
        <p style="font-weight: bold;
          padding: 6px 13px 5px 11px;
          margin-top: 5%;
          background: var(--va-greencolor);
          color: white;
          border-radius: 20px;
          text-align: center;
          height: 32px;" >
          <span  style="padding-bottom: 5px;cursor: pointer">{{$t('Meets.registerComment')}}</span><font-awesome-icon style="margin:1px 5px 0 5px" icon="fa-solid fa-plus" /></p>
      </div>
    </div>
    <p v-if="this.comments.length===0" style="width: 100%;text-align: center;margin: 10% 0 8% 0">{{ $t('LiveDetail.noComment')}}</p>
    <div v-for="comment in comments" :key="comment.id" v-if="this.geted===2" class="mycard" style="width:94%;margin: 5% 3% 5% 3%;border-radius: 20px">
      <div class="row" style="padding: 2% 2% 0 2%">
        <div style="width: 45px;border-radius: 45px;height:45px">
          <font-awesome-icon v-if="comment.profilepic==='nopic'" icon="fa-solid fa-circle-user" style="width: 40px;height: 40px;font-size: 1.9rem"  :style="{ color: '#bebebe' }"/>
          <!--         <img v-if="comment.profilepic==='nopic'" style="width: 45px;height: 45px" class="img-contact" src="../assets/images/walletgood.png">-->
          <img v-else style="width: 40px;height: 40px" class="img-contact" :src="this.baseurl+'/images/profile/'+comment.profilepic">
        </div>
        <div style="width: 45%;margin: 12px 10px 0 0">{{comment.fname}}</div>
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
      <p style="width: 100%;text-align: left;direction: rtl;padding:1% 0 2% 4%;color:#a4a4a4;font-size: 13px">{{comment.date}}</p>
    </div>
  </div>

  <div style="position: relative;width: 100%">
    <Footer :selected_num="3" />
  </div>

  <div id="myModal" class="modal" style="position: absolute !important;max-width: 540px">
    <!-- Modal content -->
    <div  class="modal-content" style="max-width: 540px;border-top-left-radius: 20px;border-top-right-radius: 20px;">
      <div class="row">
        <p style="width: 80%;padding:5% 5% 0 0">{{ $t('LiveDetail.sendComment')}}</p>
        <div style="width: 15%;margin:5% 0 50px 0;text-align: left">
          <va-avatar style="cursor: pointer" size="small"  @click="this.close()" class="mr-4" color="red"><span style="font-size: 35px;margin-top: 5px">&times;</span></va-avatar>
        </div>
      </div>
      <div style="width:96%;margin: 0 2% 6% 2%;padding:15px 10px 10px 10px ;cursor: pointer;border-radius: 15px;">
        <div class="row" style="margin-bottom: 0%">
          <p style="width: 50%">{{ $t('LiveDetail.fname')}}:</p>
          <p style="width: 50%;text-align:right">{{ $t('LiveDetail.lname')}}:</p>
        </div>
        <div class="row" style="margin-bottom: 12%">
          <input v-model="this.com_fname" type="text" style="width: 48%;margin-left: 2%" class="name">
          <input v-model="this.com_lname" type="text" style="width: 48%;margin-right: 2%" class="name">
        </div>
        <div class="row" >
          <p style="width: 70%;padding: 10px 0 0 0">{{ $t('LiveDetail.fileAttach')}}:</p>
          <label for="file-upload"  class="custom-file-upload" style="width: 30%;background-color: #6C9FD8;color: white;text-align: center;border-radius: 25px;padding: 8px 0 8px 0;cursor: pointer">
            {{ $t('LiveDetail.selectFile')}}
          </label>
          <input id="file-upload" type="file" @change="getFileName()"/>
        </div>
        <p style="font-size: 12px;color: #8d8c8c;margin: 10px 5px 0 0">{{ $t('LiveDetail.allowFormat')}}</p>
        <p v-if="this.filename!==''" style="direction: ltr;margin: 10px;color: #8d8c8c">{{this.filename}}</p>



<!--        <p v-if="this.filename!==''" style="direction: ltr;margin: 10px;">{{this.filename}}</p>-->
        <div class="row" style="margin-bottom:2%;margin-top: 10%">
          <p style="width: 100%">{{ $t('LiveDetail.liveThink')}}:</p>
        </div>
        <div class="row" style="margin-bottom: 5%">
          <textarea v-model="this.com_comment" type="tel" style="height:100px;width: 96%;padding: 10px" class="comment"></textarea>
        </div>
        <p v-if="this.geted_upload===1" style="font-size: 12px;margin-bottom: 1px">{{ $t('LiveDetail.fileUpload')}}</p>
        <va-progress-bar v-if="this.geted_upload===1" indeterminate color="var(--va-basecolor)"/>
        <button v-if="this.getedCom===1" class="comment_btn" type="button" style="margin:2% 0 3% 0;text-align: center;">
          <div style="width: 100%;text-align: center">
            <va-progress-circle style="margin: 0 45% 0 45%" size="2.5rem" indeterminate color="white" thickness="0.25" />
          </div>
        </button>
        <button v-else @click="this.sendCommentLive()" class="comment_btn" type="button" style="margin: 2% 0 3% 0;text-align: center;">
          {{ $t('LiveDetail.sendComment')}}
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
import { faBars,faBookOpenReader,faTv,faUserGroup,faCaretDown,faChartColumn,faLock,faPlus,faCircleUser,faAngleDown,faBookmark as faBookmarked,faRotateLeft,faRotateRight,faGaugeSimpleHigh,faCar,faDisplay} from '@fortawesome/free-solid-svg-icons'
import { faBell,faComments,faCircleCheck,faUser,faEye,faClock,faBookmark,faCirclePlay,faCirclePause } from '@fortawesome/free-regular-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

import {useToast} from "vue-toastification";
import 'gitart-vue-dialog/dist/style.css'
import { GDialog } from 'gitart-vue-dialog'
library.add(faBars,faBell,faBookOpenReader,faTv,faUserGroup,faComments,faCircleCheck,faUser,faEye,faCaretDown,faClock,faChartColumn,faLock,faPlus,faCircleUser,faAngleDown,faBookmark,faBookmarked,faRotateLeft,faRotateRight,faCirclePlay,faCirclePause,faGaugeSimpleHigh,faCar,faDisplay)
export default {
  name: "Meets",
  components: {
    Loading,SideMenu,Header,SubHeader,Footer,FontAwesomeIcon,GDialog
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
      if(localStorage.getItem('tk')==="" || localStorage.getItem('tk')===null){
        this.loginDialog=true;
        return
      }
      if(this.link===''){
        this.myToast(this.$t('LiveDetail.waitForLive'),2);
      }
      else{
        this.$router.push({ path: "/liveplay/"+this.$route.params.id })
        // this.$router.push({ path: '/mobile' });
        // window.open(this.link,"_self");
      }
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
    sendCommentLive(){
      if(localStorage.getItem('tk')==="" || localStorage.getItem('tk')===null){
        this.loginDialog=true
        return;
      }
      var err='';
      if(this.fname===''){
        err=this.$t('LiveDetail.enterFName');
      }
      else if(this.lname===''){
        err=this.$t('LiveDetail.enterLName');
      }
      else if(this.com_comment===''){
        err=this.$t('LiveDetail.enterComment');
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
        action:'sendCommentLive',
        LiveRef:this.$route.params.id,
        fname:this.com_fname,
        lname:this.com_lname,
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
            if(response.data.ok===1){
              this.getedCom=2;
              this.geted_upload=0;
              this.close();
              this.com_comment="";
              this.$swal({
                title: this.$t('LiveDetail.commentSent'),
                text: this.$t('LiveDetail.afterConfirmation'),
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
        action:'liveDetail',
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
              this.liveShortComment=response.data.liveShortComment;
              this.liveComment=response.data.liveComment;
              this.comments=response.data.comments;
              this.file_type=response.data.file_type;
              this.file_url=response.data.file_url;
              this.started_date=response.data.started_date;
              this.started_time=response.data.started_time;
              this.PriceInt=response.data.PriceInt;
              this.PriceOffInt=response.data.PriceOffInt;
              this.Price=response.data.Price;
              this.PriceOff=response.data.PriceOff;
              this.status=response.data.status;
              this.Duration=response.data.Duration;
              this.liveCoverPic=response.data.liveCoverPic;
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
    playVideo(id){
      if(localStorage.getItem('tk')==="" || localStorage.getItem('tk')===null){
        this.loginDialog=true
        return;
      }
      // else if(!this.iswebapp){
      else if(1===2){
        this.myToast(this.$t('LiveDetail.onlyMobile'),3)
        return;
      }
      this.getedLink=1;
      const mydata = {
        action:'getLiveLink',
        LiveRef:this.$route.params.id.toString(),
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
              // this.option.url=response.data.url;
              this.play_url=response.data.url;
              this.play_speed=1.0;
              if(response.data.type==='audio'){
                // this.style.height='120px';
                this.file_type='audio';
              }
              this.getedLink=2;
              window.scrollTo({
                top: 0,
                left: 0,
                behavior: 'smooth'
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
              this.getedLink=3;
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
            this.getedLink = 3;
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
    goToInvoice(){
      localStorage.setItem('typeGl', 'BuyLive');
      localStorage.setItem('subRefGl', '0');
      localStorage.setItem('subRef', '0');
      localStorage.setItem('CourseRefGl', '0');
      localStorage.setItem('RefGl', this.$route.params.id.toString());
      this.$router.push({ path: '/invoice'})
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
      getedLink:0,
      getedMore:0,
      openMenu:false,
      formatter : new Intl.NumberFormat('en', {
        maximumFractionDigits:0,
      }),
      data:[],
      liveName:"",
      liveShortComment:"",
      liveComment:"",
      liveCoverPic:"",

      started_date:"",
      started_time:"",
      PriceInt:0,
      PriceOffInt:0,
      Price:"",
      PriceOff:"",
      status:0,
      buyed:0,
      Duration:"",

      comments:[],
      is_short:1,
      com_fname:"",
      com_lname:"",
      com_comment:"",
      filename:"",
      file_type:"",
      file_url:"",
      iswebapp:false,
      play_url:"",
      link:"",

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