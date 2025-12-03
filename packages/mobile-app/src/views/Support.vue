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
  <div class="row" v-if="this.geted===2">
    <p style="font-size: 13px;width: 50%;padding: 3% 2% 3% 0">پشتیبانی</p>
    <p style="font-size: 13px;width: 50%;text-align: left;padding: 3% 3% 3% 2%">
      <font-awesome-icon icon="fa-solid fa-caret-down" style="font-size: 0.75rem;padding-left: 4px"/>
    </p>
  </div>
  <Loading v-if="this.geted===1" />
  <div  v-else-if="this.geted===2 && this.data.length>0" style="margin: 0 3% 70px 3%">
    <div  v-for="item in data" :key="item.ID" @click="this.goToSupport(item.ID)" class="mycard" style="height: 130px;width:100%;margin-top: 10px;margin-bottom:15px;cursor: pointer;border-radius:15px">
      <div class="row" style="padding: unset;background-color: var(--va-basecolor);border-radius: 15px 15px 0 0;height: 35px">
        <p style="width:40%;padding: 13px 10px 0 0;font-size: 12px;color: white;font-weight: normal ">شماره تیکت: {{item.ID}}</p>
        <p style="width:60%;padding: 10px 10px 0 0;font-size: 12px;color: white;font-weight: normal;text-align: left ">{{item.Date}}<font-awesome-icon icon="fa-regular fa-calendar" style=";font-size: 0.85rem;margin-left: 10px;margin-right: 5px"  :style="{ color: '#ffffff' }"/></p>
      </div>
      <div class="row" style="padding: unset">
        <div style="width:90%">
          <p style="height:65px;padding: 20px 10px 10px 10px;font-size: 12px;color: #636363;font-weight: bold ">{{item.Name}}</p>
        </div>
        <font-awesome-icon  style="width: 8%;margin-top: 18px" icon="fa-solid fa-angle-left" size="md"  :style="{ color: '#a1a1a1' }"/>
      </div>
      <div class="row" style="padding: unset;height: 30px">
        <div style="width:50%;">
          <va-badge :text="item.CatName" color="warning" style="margin-right: 5%;color: white"/>
        </div>
        <div style="width:50%;text-align: left">
          <va-badge v-if="item.Active===0" text="منتظر پاسخ" color="warning" style="margin-left: 5%"/>
          <va-badge v-else text="پاسخ داده شد" color="success" style="margin-left: 5%"/>
        </div>

      </div>
    </div>
  </div>
  <div v-else-if="this.geted===2 && this.data.length===0">
    <div class="row" >
      <p style="width: 100%;text-align: center">
        <img style="height: 150px" src="../assets/notfound.png">
      </p>
    </div>
    <div class="row" style="width: 100%;text-align: center;">
      <p class="default" style="width: 100%;text-align: center">هیچ تیکتی تاکنون ارسال نکرده اید</p>
    </div>
  </div>
  <div style="max-width: 540px;position:fixed;bottom: 50px">
    <div @click="this.open()" class="sendTicket">
      + ارسال تیکت
    </div>
  </div>
  <Footer :selected_num="1" />
  <div id="myModal" class="modal" style="position: absolute !important;max-width: 540px">
    <!-- Modal content -->
    <div  class="modal-content" style="max-width: 540px;border-top-left-radius: 20px;border-top-right-radius: 20px;">
      <div class="row">
        <p style="width: 80%;padding:5% 5% 0 0">تیکت پشتیبانی</p>
        <div style="width: 15%;margin:15px 0 10px 0;text-align: left">
          <va-avatar style="cursor: pointer" size="small"  @click="this.close()" class="mr-4" color="red"><span style="font-size: 35px;margin-top: 5px">&times;</span></va-avatar>
        </div>
      </div>
      <div style="width:96%;margin: 0 2% 0 2%;padding:5px 10px 10px 10px ;cursor: pointer;border-radius: 15px;">
        <p style="width: 100%">موضوع:</p>
        <input v-model="this.name" type="text" style="width: 95%;margin-left: 2%" class="name">
        <div class="row" style="margin-bottom: 30px;margin-top: 30px">
          <p style="width: 30%;margin-top: 13px">دپارتمان:</p>
          <select v-model="this.cat_ref" style="width: 68%;margin-left: 2%;" class="name">
            <option v-for="cat in this.data_cat" :value="cat.ID">{{ cat.Name }}</option>
          </select>
        </div>

        <div class="row" >
          <p style="width: 70%;padding: 10px 0 0 0">
            عکس، صدا یا ویدئو (دلخواه):
            <br/>
            <span style="font-size: 11px;color: #8d8c8c"></span>
          </p>
          <label for="file-upload"  class="custom-file-upload" style="width: 30%;height:35px;background-color: #6C9FD8;color: white;text-align: center;border-radius: 25px;padding: 8px 0 8px 0;cursor: pointer">
            انتخاب فایل
          </label>
          <input id="file-upload" type="file" @change="getFileName()"/>
        </div>
        <p style="font-size: 12px;color: #8d8c8c;margin: 10px 5px 0 0">حداکثر 10 مگابایت ، فرمت های مجاز: mp3,mp4,jpg,png</p>
        <pre v-if="this.filename!==''" style="color: #8d8c8c;direction: ltr;padding: 5px 0 0 5px">{{this.filename}}</pre>
        <div class="row" style="margin-bottom:5px;margin-top: 15px">
          <p style="width: 100%">متن پیام:</p>
        </div>
        <div class="row" style="margin-bottom: 5px">
          <textarea v-model="this.comment" type="tel" class="comment"></textarea>
        </div>
        <p v-if="this.geted_upload===1" style="font-size: 12px;margin-bottom: 1px">در حال آپلود فایل (چند دقیقه منتظر بمانید)</p>
        <va-progress-bar v-if="this.geted_upload===1" indeterminate color="var(--va-basecolor)"/>
        <button v-if="this.geted===1" class="comment_btn" type="button" style="margin:5px 0 3% 0;text-align: center;">
          <div style="width: 100%;text-align: center">
            <va-progress-circle style="margin: 0 45% 0 45%" size="2.5rem" indeterminate color="white" thickness="0.25" />
          </div>
        </button>
        <button v-else @click="this.sendSupport()" class="comment_btn" type="button" style="margin: 5px 0 0 0;text-align: center;">
          ارسال تیکت
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
import { faAngleLeft,faCaretDown } from '@fortawesome/free-solid-svg-icons'
import { faCalendar} from '@fortawesome/free-regular-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

import 'swiper/css/pagination';
import 'swiper/css/scrollbar';
import 'swiper/css/autoplay';
import 'gitart-vue-dialog/dist/style.css'
import { GDialog } from 'gitart-vue-dialog'
import {mapWritableState} from 'pinia';
import {useTempStroe} from '@/stores/tempStore';
library.add(faCalendar,faAngleLeft,faCaretDown)
export default {
  name: "Support",
  components: {
    Loading,SideMenu,Header,SubHeader,Footer,FontAwesomeIcon,GDialog
  },
  computed: {
    ...mapWritableState(useTempStroe, ["selected_num"])
  },
  mounted() {
    this.selected_num=1
    this.getRow(true);
    window.scrollTo(0,0);
  },
  methods:{
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
    sendTicket(){
      console.log("sendticket")
    },
    goToSupport(id){
      this.$router.push({ path: "/support/"+id })
    },
    sendSupport(){
      if(localStorage.getItem('tk')==="" || localStorage.getItem('tk')===null){
        this.loginDialog=true;
        return
      }
      var err='';
      if(this.name===''){
        err='موضوع تیکت وارد نشده است';
      }
      else if(this.cat_ref===0){
        err='دپارتمان تیکت انتخاب نشده است';
      }
      else if(this.comment===''){
        err='متن تیکت وارد نشده است';
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
      this.geted=1;
      const file = document.querySelector('#file-upload');
      const mydata = {
        action:'sendSupport',
        name:this.name,
        cat_ref:this.cat_ref,
        comment:this.comment,
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
            timeout: 1000 * 600, // Wait for 5 seconds
            data: mydata,
            headers: {
              'Content-Type': 'multipart/form-data',
              "Authorization": `Bearer ${localStorage.getItem('tk')}`
            },
          })
          .then((response) => {
            this.geted_upload=0;
            if(response.data.ok===1){
              this.getRow(false);
              this.geted=2;
              this.close();
              this.comment="";
              this.name="";
              this.$swal({
                title: 'پیام شما ارسال شد',
                text: "به زودی پاسخ شما داده خواهد شد و در همین قسمت نمایش داده خواهد شد.",
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
            this.geted_upload=0;
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
    getRow(loading){

      if(localStorage.getItem('tk')==="" || localStorage.getItem('tk')===null){
        this.loginDialog=true;
        return
      }

      if(loading)
      this.geted=1;
      const mydata = {
        action:'support',
        lang:this.$i18n.locale,
      };

      this.$http(
          {
            method: "post",
            url: this.apiurl,
            timeout: 1000 * 20, // Wait for 5 seconds
            data: mydata,
            headers: {
              "Content-Type": "application/json",
              "Authorization": `Bearer ${localStorage.getItem('tk')}`
            },
          })
          .then((response) => {
            if(response.data.ok===1){
              this.data=[];
              if(response.data.data!==null){
                this.data=response.data.data;
              }
               if(response.data.data_cat!==null){
                this.data_cat=response.data.data_cat;
              }

              console.log(response.data.data_cat);
              if(loading)
              this.geted=2;
            }
            else if(response.data.ok===3){
              localStorage.setItem('token', "");
              this.$router.push({ path: '/login' })
            }
            else{
              if(response.data.ok===4){
                localStorage.setItem('tk', "");
              }
              if(loading)
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
            if(loading)
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
    onSwiper(){
    },
    onSlideChange(){
    },
  },

  data(){
    return{
      geted:0,
      geted_upload:0,
      openMenu:false,
      formatter : new Intl.NumberFormat('en', {
        maximumFractionDigits:0,
      }),
      data:[],
      data_cat:[],
      cat_ref:0,
      comment:"",
      name:"",
      filename:"",
    }
  }
};

</script>
<style>

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
.card {
  /*float: left;*/
  max-width: 49%;
  margin-left: 2%;
  padding: 0;
  margin-bottom: 2rem;
  border: 0;
  flex-basis: 49%;
  flex-grow: 0;
  flex-shrink: 0;
}
.card > img {
  margin-bottom: .01rem;
  width: 100%;
}
.card-text {
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
.sendTicket{
  position: absolute;
  bottom: 30px;
  right: 15px;
  background-color: var(--va-greencolor);
  /*width: 100%;*/
  /*max-width: 540px;*/
  color: white;
  /*text-align: center;*/
  /*height: 100px;*/
  width: 120px !important;
  text-align: center;
  max-width: 540px !important;
  padding: 10px;
  border-radius: 25px;

  left: unset !important;
}
.va-badge__text{
  color: white;
  font-size: 12px;
  font-weight: normal;
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
input[type="file"] {
  display: none;
}
.name{
  width: 100%;height: 35px;
  text-align: right;
  direction: rtl;
  outline: none !important;
  border-bottom:1px solid #8a8a8a;
  border-top-width:0;
  border-right-width:0;
  border-left-width:0;
  padding-left: 10px;
}
option {
  font-family: IRANYekan;
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
.comment{
  width: 96%;
  height: 60px;
  text-align: right;
  direction: rtl;
  outline: none !important;
  border:1px solid #8a8a8a;
  border-radius: 10px;
  padding: 10px;
}
</style>