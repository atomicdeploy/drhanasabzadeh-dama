<template>
  <Header  @headeropenMenu="this.homeOpenMenu()" :isHome="0"/>
  <SideMenu :openMenu="this.openMenu" @headercloseMenu="this.headerCloseMenu()" :group_ref="0"/>
  <GDialog v-model="this.loginDialog" max-width="500" >
    <div class="wrapper" style="">
      <div class="content">
        <div style="width: 100%;text-align: center">
          <img style="width:85px " src="../../assets/images/needlogin.png">
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

  <Loading v-if="this.geted===1"  />
  <div  v-if="this.geted===2" style="margin: 3% 3% 0 3%">
    <div class="mycard" style="width:100%;margin: 5% 0 5% 0;padding: 0 0 3% 0;border-radius: 20px !important;">
      <div class="row"  style="padding: unset" oncontextmenu="return false;">
        <img v-if="this.geted===2 && this.data.pic!==''" :src="this.baseurl+'/images/profile/'+this.data.pic" style="width:100%;border-radius: 20px 15px 0 0 ">
      </div>
      <div class="row" style="padding: unset">
        <p style="font-size: 15px;padding: 4% 3% 5% 3%;width: 86%;font-weight: bold">{{ this.data.name }}</p>
      </div>
      <div style="width: 96%;height:1px;background-color: #d0d0d0;margin: 4% 2% 4% 2%"></div>
      <button  @click="this.goToCourses()" class="buybtncounter1" type="button">
        <font-awesome-icon style="margin:0 0 0 5px" icon="fa-solid fa-chalkboard-user" />
       دوره های مدرس
      </button>


      <div v-if="this.is_short===1" v-html="this.data.short_description" style="width: 100%;padding: 3%;  line-height: 1.6;">

      </div>
      <div v-else  v-html="this.data.description" style="width: 100%;padding: 3%;  line-height: 1.6;">
      </div>
      <div v-if="this.is_short===1 && this.data.short_description!==this.data.description" @click="this.is_short=0" class="row" style="text-align: center;cursor:pointer">
        <span style="width: 50%;color:#8a8a8a">{{$t('Meets.more')}}</span>
        <p style="margin-top: -1%">
          <va-icon style="width: 42%;direction: rtl;text-align: right;margin-bottom: 5%;color:#8a8a8a" class="material-icons">expand_more</va-icon>
        </p>
      </div>
      <div v-else-if="this.is_short===0 && this.data.short_description!==this.data.description"  @click="this.is_short=1" class="row" style="text-align: center;cursor:pointer">
        <span style="width: 50%;color:#8a8a8a">{{$t('Meets.less')}}</span>
        <p style="margin-top: -1%">
          <va-icon style="width: 42%;direction: rtl;text-align: right;margin-bottom: 5%;color: #8a8a8a" class="material-icons">expand_less</va-icon>
        </p>
      </div>
    </div>
  </div>
  <a href="#meetcomment">
    <button @click="this.moreComment(0)" v-if="this.geted===2 && this.comments.length>0 " class="buybtn" type="button" style="margin-top: unset;margin-bottom: unset">
      <font-awesome-icon style="margin:1px 0 0 5px" icon="fa-solid fa-angle-down" />
      {{$t('Meets.viewComments')}}
    </button>
  </a>

  <div  v-if="this.geted===2" class="mycard" style="width:94%;margin: 5% 3% 5% 3%;border-radius: 20px;padding-bottom: 1%">
    <div class="row">
      <p style="padding: 5% 4% 3% 4%;font-weight: bold;width: 50%;margin-top: 1%">{{$t('Meets.userComments')}}</p>
      <div @click="this.open()" style="width: 40%;margin: 1% 3% 0 3%;">
        <p style="font-weight: bold;
          padding: 6px 13px 5px 11px;
          margin-top: 5%;
          background: var(--va-greencolor);
          color: white;
          border-radius: 20px;
          text-align: center;
          height: 32px;" >
          <span  style="position: relative;bottom: 3px;cursor: pointer">{{$t('Meets.registerComment')}}</span><font-awesome-icon style="margin:3px 5px 0 5px" icon="fa-solid fa-plus" /></p>
      </div>
    </div>

    <p v-if="this.comments.length===0" style="width: 100%;text-align: center;margin: 10% 0 8% 0">{{$t('Meets.noComment')}}</p>

    <div v-for="comment in comments" :key="comment.id" v-if="this.geted===2" class="mycard" style="width:94%;margin: 5% 3% 5% 3%;border-radius: 20px">
      <div class="row" style="padding: 2% 2% 0 2%">
        <div style="width: 10%;">
          <div style="width: 35px;border-radius: 35px;height:35px">
            <font-awesome-icon v-if="comment.profilepic==='nopic'" icon="fa-solid fa-circle-user" style="width: 35px;height: 35px;font-size: 1.9rem"  :style="{ color: '#bebebe' }"/>
            <!--         <img v-if="comment.profilepic==='nopic'" style="width: 45px;height: 45px" class="img-contact" src="../assets/images/walletgood.png">-->
            <img v-else style="width: 40px;height: 40px" class="img-contact" :src="this.baseurl+'/images/profile/'+comment.profilepic">
          </div>
        </div>
        <div style="width: 47%;margin: 12px 3% 0 0">{{comment.name}}</div>
        <div style="width: 38%;margin: 12px 0 0 0">
          <Rating :size="'0.85rem'" :rate="comment.rating" style="margin-left: 4%"/>
        </div>
      </div>
      <div v-if="comment.file_type==='pic'" style="text-align: center">
        <img :src="this.baseurl+'/images/comment/'+comment.file" style="max-height:200px;margin:2% 2% 1% 2%;max-width:96%; border-radius:5px ">
      </div>
      <audio v-else-if="comment.file_type==='audio'" preload="none" webkit-playsinline playsinline controlsList="nodownload"  controls oncontextmenu="return false;" style="border-top-right-radius: 20px;border-top-left-radius: 20px;width: 100%;height: 100px">
        <source :src="this.baseurl+'/images/comment/'+comment.file"  type="audio/mpeg" />
      </audio>
      <video v-else-if="comment.file_type==='video'" controlsList="nodownload"  controls oncontextmenu="return false;" style="border-top-right-radius: 20px;border-top-left-radius: 20px;width: 100%;margin-top: 15px">
        <source :src="this.baseurl+'/images/comment/'+comment.file"  type="video/mp4" />
      </video>
      <pre style="width: 100%;padding: 2% 3% 4% 3%;direction: rtl;line-height: 1.4;">{{comment.comment}}</pre>

      <div class="row" >
        <va-badge :text="comment.meet_name" text-color="white" color="success" style="width: 52%;margin: 0 2% 10px 0"/>
        <p style="width: 43%;text-align: left;direction: rtl;margin:8px 0 0 2%;color:#a4a4a4;font-size: 13px">{{comment.date}}</p>
      </div>

    </div>
    <button @click="this.moreComment(0)" v-if="this.geted===2 && this.getedMore!==1 && this.getedMore!==2 && this.comments.length>0 " class="buybtn" type="button">
      <font-awesome-icon style="margin:1px 0 0 5px" icon="fa-solid fa-angle-down" />
      {{$t('Meets.moreComments')}}
    </button>
    <button v-if="this.geted===2&& this.getedMore===1 " type="button" class="buybtn">
      <div style="width: 100%;text-align: center">
        <va-progress-circle style="margin: 0 45% 0 45%" size="2.5rem" indeterminate color="white" thickness="0.25" />
      </div>
    </button>
  </div>
  <div style="position: relative;width: 100%">
    <Footer :selected_num="3" />
  </div>

  <div id="myModal" class="modal" style="position: absolute !important;max-width: 540px">

    <!-- Modal content -->
    <div  class="modal-content" style="max-width: 540px;border-top-left-radius: 20px;border-top-right-radius: 20px;">

      <div class="row" style="margin-bottom: 10px">
        <p style="width: 78%;padding:20px 20px 0 20px">{{$t('Meets.registerComment')}}</p>
        <div style="width:14%; margin: 0 4% 0 4%" :class="{rtl_lang:$t('config.dir')==='ltr',ltr_lang:$t('config.dir')==='rtl'}">
          <va-avatar style="margin: 10px 10px 0 10px;cursor: pointer" size="small"  @click="this.close()"   color="red"><span style="font-size: 35px;margin-top: 5px">&times;</span></va-avatar>
        </div>
      </div>
      <hr/>
      <div style="width:96%;margin: 10px 2% 5px 2%;padding:10px 10px 0 10px ;cursor: pointer;border-radius: 15px;">
        <div class="row" style="margin-bottom: 30px">
          <p style="width: 50%;margin-top: 1%">{{$t('Teacher.pointsTeacher')}}:</p>
          <va-rating color="#ffdd02"  v-model="this.com_rating" style="width: 50%" :class="{rtl_lang:$t('config.dir')==='ltr',ltr_lang:$t('config.dir')==='rtl'}"/>
        </div>

        <div class="row" style="margin: 20px 0 20px 0">
          <input v-model="this.show_name" type="checkbox" class="va-checkbox__square" id="shname">
          <label for="shname" style="margin: 1px 5px 0 10px">{{$t('Meets.displayInformation')}}</label>
        </div>
        <div class="row" >
          <p style="width: 70%;padding: 10px 0 0 0">
            {{$t('Meets.attach')}}:
            <br/>
            <span style="font-size: 11px;color: #8d8c8c"></span>
          </p>
          <label for="file-upload"  class="custom-file-upload" style="width: 30%;height:35px;background-color: #6C9FD8;color: white;text-align: center;border-radius: 25px;padding: 8px 0 8px 0;cursor: pointer">
            {{$t('Meets.selectFile')}}
          </label>
          <input id="file-upload" type="file" @change="getFileName()"/>
        </div>
        <p style="font-size: 12px;color: #8d8c8c;margin: 5px 5px 0 0">{{$t('Meets.allowFormat')}}: mp3,mp4,jpg,png</p>
        <pre v-if="this.filename!==''" style="color: #8d8c8c;padding: 5px 0 0 5px">{{this.filename}}</pre>

        <div class="row" style="margin:30px 0 5px 0">
          <p style="width: 100%">{{$t('Teacher.opinion')}}:</p>
        </div>
        <div class="row" style="margin-bottom:5%">
          <textarea v-model="this.com_comment" type="tel" style="height:60px;width: 96%;padding: 10px" class="comment"></textarea>
        </div>
        <p v-if="this.geted_upload===1" style="font-size: 12px;margin-bottom: 1px">{{$t('Meets.uploading')}}</p>
        <va-progress-bar v-if="this.geted_upload===1" indeterminate color="var(--va-basecolor)"/>
        <button v-if="this.getedCom===1" class="comment_btn" type="button" style="margin:4px 0 3% 0;text-align: center;">
          <div style="width: 100%;text-align: center">
            <va-progress-circle style="margin: 0 45% 0 45%" size="2.5rem" indeterminate color="white" thickness="0.25" />
          </div>
        </button>
        <button v-else @click="this.sendComment()" class="comment_btn" type="button" style="margin: 4px 0 3% 0;text-align: center;">
          {{$t('Meets.registerComment')}}
        </button>
      </div>
    </div>

  </div>
</template>

<script>
import { library } from '@fortawesome/fontawesome-svg-core'
import Loading from '../../components/Loading.vue'
import Header from '../../components/Header.vue'
import Footer from '../../components/Footer.vue'
import SubHeader from '../../components/SubHeader.vue'
import SideMenu from '../../components/SideMenu.vue'
import Rating from '../../components/Rating.vue'

import { faBars,faBookOpenReader,faTv,faUserGroup,faCaretDown,faChartColumn,faLock,faPlus,faCircleUser,faAngleDown,faBookmark as faBookmarked,faRotateLeft,faRotateRight,faGaugeSimpleHigh,faChalkboardUser} from '@fortawesome/free-solid-svg-icons'
import { faBell,faComments,faCircleCheck,faUser,faEye,faClock,faBookmark,faCirclePlay,faCirclePause } from '@fortawesome/free-regular-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

import {Autoplay, Navigation, Pagination, Scrollbar, A11y } from 'swiper';
import { Swiper, SwiperSlide } from 'swiper/vue';
// Import Swiper styles
import 'swiper/css';
// import 'swiper/css/navigation';
import 'swiper/css/pagination';
import 'swiper/css/scrollbar';
import 'swiper/css/autoplay';
import {useToast} from "vue-toastification";
import 'gitart-vue-dialog/dist/style.css'
import { GDialog } from 'gitart-vue-dialog'

library.add(faBars,faBell,faBookOpenReader,faTv,faUserGroup,faComments,faCircleCheck,faUser,faEye,faCaretDown,faClock,faChartColumn,faLock,faPlus,faCircleUser,faAngleDown,faBookmark,faBookmarked,faRotateLeft,faRotateRight,faCirclePlay,faCirclePause,faGaugeSimpleHigh,faChalkboardUser)
export default {
  name: "TeacherDetail",
  components: {
    Loading,SideMenu,Header,SubHeader,Footer,FontAwesomeIcon,Swiper, SwiperSlide,Rating,GDialog
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
    localStorage.setItem('course_ref',this.$route.params.id.toString());
    // window.addEventListener('contextmenu', function (e) {
    //   e.preventDefault();
    // }, false);
  },
  methods:{
    moreComment(){
      this.getedMore=1;
      const mydata = {
        action:'moreComment',
        ref:this.$route.params.id,
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
              if(response.data.comments!==null){
                this.comments=response.data.comments;
              }
              else{
                this.comments=[];
              }

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
    sendComment(){
      if(localStorage.getItem('tk')==="" || localStorage.getItem('tk')===null){
        this.loginDialog=true;
        return;
      }
      var err='';
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
      const mydata = {
        action:'sendComment',
        ref:this.$route.params.id,
        comment:this.com_comment,
        title:this.title,
        subject:this.subject,
        rating:this.com_rating.toString(),
        show_name:this.show_name===true?1:0,
        lang:this.$i18n.locale,
      };
      const file = document.querySelector('#file-upload');
      if(file.files.length!==0){
        this.geted_upload=1;
        mydata.file=file.files[0]
      }
      this.$http(
          {
            method: "post",
            url: this.apiurl,
            timeout: 1000 * 120, // Wait for 5 seconds
            data: mydata,
            headers: {
              'Content-Type': 'multipart/form-data',
              "Authorization": `Bearer ${localStorage.getItem('tk')}`
            },
          })
          .then((response) => {
            this.geted_upload=0;

            document.getElementById("file-upload").value='';
            this.filename='';

            if(response.data.ok===1){
              this.getedCom=2;
              this.close();
              this.com_comment="";
              this.title="";
              this.subject="";
              this.$swal({
                title: this.$t('Meets.commentSent'),
                text: this.$t('Meets.afterConfirmation'),
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
            this.geted_upload=0;
            this.getedCom = 3;
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
    goToCourses(){
      this.$router.push({ path: '/courses',query:{pageref:0,ref:this.$route.params.id}})
    },
    goToPageNeedLogin(page){
      if(localStorage.getItem('tk')==="" || localStorage.getItem('tk')===null){
        this.loginDialog=true;
        return;
      }
      else{
        this.$router.push({ path: page})
      }

    },
    getRow(){

      this.geted=1;
      const mydata = {
        action:'teacher_detail',
        ref:this.$route.params.id,
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
              if(response.data.data!==null){
                this.data=response.data.data;

              }
              if(response.data.comments!==null){
                this.comments=response.data.comments;
              }
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
    close_speed(){
      var modal = document.getElementById("mySpeed");
      modal.style.display = "none";
    },
    open_speed(){
      var modal = document.getElementById("mySpeed");
      modal.style.display = "block";
    },
    close(){
      var modal = document.getElementById("myModal");
      modal.style.display = "none";
    },
    open(){
      var modal = document.getElementById("myModal");
      modal.style.display = "block";
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
  },
  setup() {
    return {
      modules: [Autoplay,Navigation, Pagination, Scrollbar, A11y],
    };
  },

  data(){
    return{
      data:[],
      color:"#FFFFFF",
      geted:0,
      getedCom:0,
      getedMore:0,
      getedLink:0,
      loginDialog:false,
      rating:3,
      openMenu:false,
      formatter : new Intl.NumberFormat('en', {
        maximumFractionDigits:0,
      }),
      comments:[],
      is_short:1,
      com_rating:5,
      com_comment:"",
      iswebapp:false,
      geted_upload:0,
      show_name:true,
      title:"",
      subject:"",
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
.video {
  position: relative;
  left: 0;
  width: 100% !important;
  top: 0;
  opacity: 1;
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
  outline: none !important;
  border:1px solid #8a8a8a;
  border-radius: 10px;
  padding: 10px;
}
.minput{
  width: 100%;height: 25px;
  text-align: right;
  direction: rtl;
  outline: none !important;
  border-bottom:1px solid #8a8a8a;
  border-left: unset;
  border-right: unset;
  border-top: unset;
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
option {
  font-family: IRANYekan;
}
input[type="file"] {
  display: none;
}
.myinput{
  padding: 0 8px 0 10px;
  background: #eeeeee;
  border-radius: 25px;
  height: 35px;
  border: 0;
  font-family: IRANYekan;
}
html {
  scroll-behavior: smooth;
}
.buybtncounter1{
  width: 90%;
  text-align: center;
  margin: 3px 5% 10px 5%;
  padding: 0 20px 0 20px;
  height: 45px;
  background-color: var(--va-greencolor);
  color:white;
  border-radius: 10px;
  border:unset;
  cursor: pointer;
}
.compbtn{
  width: 92%;
  text-align: center;
  margin:3%;
  height: 45px;
  background-color:#95E292FC;
  color:white;
  border-radius: 10px;
  border:unset;
}
</style>