<template>
  <Header v-if="this.forced_profile!==1 || this.compelete===100" @headeropenMenu="this.homeOpenMenu()" :isHome="0"/>
  <SideMenu v-if="this.forced_profile!==1 || this.compelete===100" :openMenu="this.openMenu" @headercloseMenu="this.headerCloseMenu()" :group_ref="0"/>
  <div v-if="this.forced_profile===1 && this.compelete!==100" style="background-color: var(--va-basecolor);padding: 20px;margin: 0;color: white;text-align: center">
    جهت ورود به اپلیکیشن لطفا پروفایل خود را تکمیل کنید
  </div>
  <Loading v-if="this.geted===1" />

  <div class="profile" v-if="this.geted===2" style="background: #fafafa">
    <div class="center">
      <div class="row"  style="margin: 0 4% 1% 4%">
        <va-progress-circle
            class="profile"
            style="width: 100% !important;background-color: #fafafa"
            size="170px"
            :modelValue="this.compelete"
            color="danger">
          <label for="file-upload"  class="custom-file-upload" style="width: 30%;height:35px;text-align: center;border-radius: 25px;padding: 8px 0 8px 0;cursor: pointer">
            <img v-if="this.url!==''" :src="url" style="width: 116px;height: 116px;text-align: center;border-radius: 58px;"/>
            <img v-else-if="this.profilepic!==''" :src="this.baseurl.replace('panel.','')+'/images/profile/'+this.profilepic" style="width: 116px;height: 116px;text-align: center;border-radius: 58px;"/>
            <font-awesome-icon v-else icon="fa-solid fa-user" size="5x"  :style="{ color: '#868686' }"/>
          </label>
        </va-progress-circle>
      </div>
      <input id="file-upload" type="file" accept="image/*" @change="onFileChange"/>
    </div>
    <div class="row" >


    </div>
    <p style="width: 100%;text-align: center">{{ this.compelete }}% تکمیل شده </p>
    <div class="profile" v-if="this.appdirectory!=='51'" style="width: 55%;height:40px;border-radius:10px;padding: 8px 0 0 0; margin:30px 22% 0 22%; text-align: center !important;background-color: #eaeaea">
      <div class="row" style="text-align: center;width: 100%;padding: 0 20% 0 20%">
        <font-awesome-icon  icon="fa-solid fa-barcode" style="width: 18%;padding-bottom: 5px;margin-left: 2%" size="xl"  :style="{ color: '#868686' }"/>
        <p style="width: 60%;padding-top: 5px">کد معرف:</p>
        <p style="width: 20%;padding-top: 5px;">{{ this.invite_code }}</p>
      </div>
    </div>



    <div class="row" style="width: 100%;margin-top:5%;height:150px; text-align: center !important;">
      <va-progress-circle
          v-if="this.exp===0"
          style="width: 35% !important;margin-right: 5%"
          size="170px"
          :modelValue="100"
          thickness="0.20"
          :color="this.exp===0?'#bdbdbd':this.exp<11?'#FFA500FF':'#34cc73'">
        <p v-if="this.exp===0" style="font-size: 45px;margin-top: 10px;color: orangered">{{this.exp}}</p>
      </va-progress-circle>
      <va-progress-circle
          v-else
          style="width: 35% !important;margin-right: 5%"
          size="170px"
          :modelValue="this.exp*3"
          thickness="0.20"
          :color="this.exp===0?'#a1a1a1':this.exp<11?'#FFA500FF':'#34cc73'">
        <p v-if="this.exp===0" style="font-size: 45px;margin-top: 10px;color: orangered">{{this.exp}}</p>
        <p v-else-if="this.exp<11" style="font-size: 45px;margin-top: 10px;color: orange">{{this.exp}}</p>
        <p v-else style="font-size: 22px;margin-top: 10px;color: var(--va-greencolor)">{{this.exp}}</p>
      </va-progress-circle>
      <p v-if="this.exp===0" style="width: 55%;margin-top: 70px;font-weight: bold;font-size:22px; color: orangered">
        اشتراک ندارید
        <br/>
        <router-link to="/subscription" style="margin-top: 5px;font-size: 14px;font-weight: unset;color: #5d5d5d">(خرید اشتراک)</router-link>
      </p>
      <p v-else-if="this.exp<11" style="width: 55%;margin-top: 70px;font-size:22px;font-weight: bold; color: orange">
        وضعیت اشتراک
        <br/>
        <span style="color: #8a8a8a;font-size: 14px;font-weight: normal">{{this.exp}} روز باقیمانده تا پایان اشتراک</span>
      </p>
      <p v-else style="width: 55%;margin-top: 70px;font-size:22px;font-weight: bold; color: var(--va-greencolor)">
        وضعیت اشتراک
        <br/>
        <span style="color: #8a8a8a;font-size: 14px;font-weight: normal">{{this.exp}} روز باقیمانده تا پایان اشتراک</span>
      </p>
    </div>
    <div class="row" style="width: 100%;margin-top:7%; text-align: center !important;">
      <div style="width: 45%;height: 30px;margin-right: 3%;margin-left: 0">
        <p style="text-align: right;padding-right: 10px">نام کاربری:</p>
      </div>
      <div style="width: 45%;height: 30px;margin-left: 0;margin-right: 4%">
        <p style="text-align: right;padding-right: 10px">{{this.mobile}}</p>
      </div>
    </div>
    <div class="row" style="width: 100%;margin-top:7%; text-align: center !important;">
      <div class="profileinput" style="width: 45%;border-radius:10px;background-color: #eeeeee;height: 40px;margin-right: 3%;margin-left: 0">
        <input v-model="this.fname" placeholder="نام" class="myinput" style="width: 90%" >
      </div>
      <div class="profileinput" style="width: 45%;border-radius:10px;background-color: #eeeeee;height: 40px;margin-left: 0;margin-right: 4%">
        <input v-model="this.lname" placeholder="نام خانوادگی" class="myinput" >
      </div>
    </div>
    <div class="row" style="width: 100%;margin-top:5%;margin-bottom:5%; text-align: center !important;">
      <div class="profileinput" style="width: 45%;border-radius:10px;background-color: #eeeeee;height: 45px;margin-right: 3%;margin-left: 0">
        <select v-model="this.education" class="myinput " style="width: 95%">
          <option value="انتخاب تحصیلات">انتخاب تحصیلات</option>
          <option value="زیر دیپلم">زیر دیپلم</option>
          <option value="دیپلم">دیپلم</option>
          <option value="لیسانس">لیسانس</option>
          <option value="فوق لیسانس">فوق لیسانس</option>
          <option value="دکترا">دکترا</option>
        </select>
      </div>
      <div class="profileinput" style="width: 45%;border-radius:10px;background-color: #eeeeee;height: 45px;margin-left: 0;margin-right: 4%">
        <input v-model="this.study" placeholder="رشته تحصیلی" class="myinput" >
      </div>

    </div>
    <div v-if="skills.length>0" class="row" style="width: 100%;margin-top:5%;margin-bottom:5%; text-align: center !important;">
      <div class="profileinput" style="width: 94%;border-radius:10px;background-color: #eeeeee;height: 45px;margin-right: 3%;margin-left: 0">
        <select v-model="this.skill_ref" class="myinput" style="width: 95%">
          <option value="0">تخصص</option>
          <option v-for="skill in this.skills" :key="skill.id" :value="skill.id">{{skill.name}}</option>
        </select>
      </div>
    </div>
    <div class="row" style="width: 100%;margin-top:5%;margin-bottom:5%; text-align: center !important;">
      <div class="profileinput" style="width: 45%;border-radius:10px;background-color: #eeeeee;height: 45px;margin-right: 3%;margin-left: 0">
        <select v-model="this.history_ref" class="myinput" style="width: 95%">
          <option value="0">سابقه کار</option>
          <option v-for="history in this.histories" :key="history.id" :value="history.id">{{history.name}}</option>
        </select>
      </div>
      <div class="profileinput" style="width: 45%;border-radius:10px;background-color: #eeeeee;height: 45px;margin-left: 0;margin-right: 4%">
        <select v-model="this.introduction_ref" class="myinput" style="width: 95%">
          <option value="0">نحوه آشنایی</option>
          <option v-for="introduction in this.introductions" :key="introduction.id" :value="introduction.id">{{introduction.name}}</option>
        </select>
      </div>

    </div>
    <div class="row" style="width: 100%;margin-bottom:5%; text-align: center !important;">
      <div class="profileinput" style="width: 45%;border-radius:10px;background-color: #eeeeee;height: 45px;margin-right: 3%;margin-left: 0">
        <select v-model="this.province" class="myinput" style="width: 95%">
          <option value="انتخاب استان">انتخاب استان</option>
          <option value="آذربایجان شرقی">آذربایجان شرقی</option>
          <option value="آذربایجان غربی">آذربایجان غربی</option>
          <option value="اردبیل">اردبیل</option>
          <option value="اصفهان">اصفهان</option>
          <option value="البرز">البرز</option>
          <option value="ایلام">ایلام</option>
          <option value="بوشهر">بوشهر</option>
          <option value="تهران">تهران</option>
          <option value="چهارمحال و بختیاری">چهارمحال و بختیاری</option>
          <option value="خراسان جنوبی">خراسان جنوبی</option>
          <option value="خراسان رضوی">خراسان رضوی</option>
          <option value="خراسان شمالی">خراسان شمالی</option>
          <option value="خوزستان">خوزستان</option>
          <option value="زنجان">زنجان</option>
          <option value="سمنان">سمنان</option>
          <option value="سیستان و بلوچستان">سیستان و بلوچستان</option>
          <option value="فارس">فارس</option>
          <option value="قزوین">قزوین</option>
          <option value="قم">قم</option>
          <option value="کردستان">کردستان</option>
          <option value="کرمان">کرمان</option>
          <option value="کرمانشاه">کرمانشاه</option>
          <option value="کهگیلویه و بویراحمد">کهگیلویه و بویراحمد</option>
          <option value="گلستان">گلستان</option>
          <option value="گیلان">گیلان</option>
          <option value="لرستان">لرستان</option>
          <option value="مازندران">مازندران</option>
          <option value="مرکزی">مرکزی</option>
          <option value="هرمزگان">هرمزگان</option>
          <option value="همدان">همدان</option>
          <option value="یزد">یزد</option>
        </select>
      </div>
      <div class="profileinput" style="width: 45%;border-radius:10px;background-color: #eeeeee;height: 45px;margin-left: 0;margin-right: 4%">
        <input v-model="this.job" placeholder="شغل" class="myinput" >
      </div>
    </div>



    <div v-if="this.custom1_profile!==''" class="row" style="width: 100%;margin-top:7%; text-align: center !important;">
      <div class="profileinput" style="width: 94%;border-radius:10px;background-color: #eeeeee;height: 45px;margin-right: 3%;margin-left: 0">
        <input v-model="this.custom1" :placeholder="this.custom1_profile" class="myinput" style="width: 95%" >
      </div>
    </div>
    <div v-if="this.custom2_profile!==''" class="row" style="width: 100%;margin-top:7%; text-align: center !important;">
      <div class="profileinput" style="width: 94%;border-radius:10px;background-color: #eeeeee;height: 45px;margin-right: 3%;margin-left: 0">
        <input v-model="this.custom2" :placeholder="this.custom2_profile" class="myinput" style="width: 95%" >
      </div>
    </div>
    <div v-if="this.custom3_profile!==''" class="row" style="width: 100%;margin-top:7%; text-align: center !important;">
      <div class="profileinput" style="width: 94%;border-radius:10px;background-color: #eeeeee;height: 45px;margin-right: 3%;margin-left: 0">
        <input v-model="this.custom3" :placeholder="this.custom3_profile" class="myinput" style="width: 95%" >
      </div>
    </div>

    <div class="row" style="width: 100%;margin-top:10%;margin-bottom:10%; text-align: center !important;">
      <div class="row" style="width: 50%">
        <div style="width: 65%;margin-left: 5%;margin-top:2px;text-align:left; direction: rtl">
          <input id="man" v-model="this.gender"   style="text-align: left;" type="radio" value="1">
        </div>
        <div style="width: 20%;text-align: right;">
          <label for="man">مرد</label>
        </div>
      </div>
      <div class="row" style="width: 50%;margin-right: 0">
        <div style="width: 20%;margin-left: 5%;margin-top:2px;text-align:left; direction: rtl">
          <input id="woman" v-model="this.gender"  style="text-align: left;" type="radio" value="2">
        </div>
        <div style="width: 65%;text-align: right;">
          <label for="woman">زن</label>
        </div>
      </div>
    </div>
    <button v-if="this.geted_edit===1" class="buybtnp" type="button" style="margin:0 5% 8% 5%;text-align: center;">
      <div style="width: 100%;text-align: center">
        <va-progress-circle style="margin: 0 45% 0 45%" size="2.5rem" indeterminate color="white" thickness="0.25" />
      </div>
    </button>
    <button v-else @click="this.editProfile()" class="buybtnp" type="button" style="margin: 0 5% 8% 5%;text-align: center;">
      ویرایش پروفایل
    </button>
  </div>

  <div style="height: 10px">&nbsp;</div>
  <Footer v-if="this.forced_profile!==1 || this.compelete===100" :selected_num="3" />
</template>

<script>
import { library } from '@fortawesome/fontawesome-svg-core'
import Loading from '../components/Loading.vue'
import Header from '../components/Header.vue'
import Footer from '../components/Footer.vue'
import SubHeader from '../components/SubHeader.vue'
import SideMenu from '../components/SideMenu.vue'

import {faUser,faBarcode } from '@fortawesome/free-solid-svg-icons'
// import { } from '@fortawesome/free-regular-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { useToast } from "vue-toastification";
import {mapWritableState} from 'pinia';
import {usePermStroe} from '@/stores/permStore';
library.add(faUser,faBarcode)
export default {
  name: "Profile",
  components: {
    Loading,SideMenu,Header,SubHeader,Footer,FontAwesomeIcon
  },
  computed: {
    ...mapWritableState(usePermStroe, ["forced_profile"]),
  },
  mounted() {

    this.getRow();
    window.scrollTo(0,0);
  },
  methods:{
    onFileChange(e) {
      const file = e.target.files[0];
      this.url = URL.createObjectURL(file);
    },
    getFileName(){
      this.filename= document.getElementById("file-upload").value;
    },
    myToast(alert){
      useToast().success(alert, {
        timeout: 3000,
        position:'top-center',
        rtl: this.$t('config.dir')==='rtl'?true:false
      });
    },
    getRow(){
      this.geted=1;
      const mydata = {
        action:'getProfile',
        filter:this.filter,
        catref:this.catref,
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
              this.mobile=response.data.mobile;
              this.fname=response.data.fname;
              this.lname=response.data.lname;
              this.study=response.data.study;
              this.custom1_profile=response.data.custom1_profile;
              this.custom2_profile=response.data.custom2_profile;
              this.custom3_profile=response.data.custom3_profile;
              this.custom1=response.data.custom1;
              this.custom2=response.data.custom2;
              this.custom3=response.data.custom3;
              this.forced_profile=response.data.forced_profile;

              if(response.data.province!=null && response.data.province!==''){
                this.province=response.data.province;
              }
             if(response.data.skills!=null){
                this.skills=response.data.skills;
              }
            if(response.data.introductions!=null){
                this.introductions=response.data.introductions;
              }
            if(response.data.histories!=null){
                this.histories=response.data.histories;
              }

              this.education=response.data.education;
              if(this.education===null || this.education===''){
                this.education='انتخاب تحصیلات'
              }
              this.job=response.data.job;
              this.gender=response.data.gender;
              this.profilepic=response.data.profilepic;
              this.compelete=response.data.compelete;
              this.exp=response.data.exp;
              this.exp_percent=response.data.exp_percent;
              this.invite_code=response.data.invite_code;
              this.history_ref=response.data.history_ref;
              this.introduction_ref=response.data.introduction_ref;
              this.skill_ref=response.data.skill_ref;
              this.geted=2;
            }
            else if(response.data.ok===3){
              localStorage.setItem('token', "");
              this.$router.push({ path: '/login' })
            }
            else{
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
            this.geted_f = 0;
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
    editProfile(){
      this.geted_edit=1;

      const file = document.querySelector('#file-upload');
      const mydata = {
        action:'editProfile',
        fname:this.fname,
        lname:this.lname,
        study:this.study,
        province:this.province,
        education:this.education,
        job:this.job,
        gender:this.gender,
        custom1:this.custom1,
        custom2:this.custom2,
        custom3:this.custom3,
        history_ref:this.history_ref,
        introduction_ref:this.introduction_ref,
        lang:this.$i18n.locale,
      };
      if(file.files.length!==0){
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
              this.myToast("اطلاعات شما با موفقیت ویرایش شد.");
              this.compelete=response.data.compelete;
              this.geted_edit=2;
              if(response.data.forced_profile===1){
                this.$router.push({ path: '/' })
              }
            }
            else if(response.data.ok===3){
              localStorage.setItem('token', "");
              this.$router.push({ path: '/login' })
            }
            else{
              this.geted_edit=3;
              this.$swal({
                title: this.$t('General.error'),
                html: response.data.msg.replace(/\n/g, '<br/>'),
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
            this.geted_edit = 3;
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
    onSwiper(){},
    onSlideChange(){},
  },

  data(){
    return{
      mobile:"",
      geted:0,
      geted_edit:0,
      openMenu:false,
      formatter : new Intl.NumberFormat('en', {
        maximumFractionDigits:0,
      }),
      fname:"",
      lname:"",
      study:"",
      province:"انتخاب استان",
      education:"انتخاب تحصیلات",
      job:"",
      gender:"",
      profilepic:"",
      compelete:0,
      exp:0,
      exp_percent:0,
      invite_code:0,
      filename:"",
      url:"",
      skill_ref:0,
      skills:[],
      histories:[],
      introductions:[],
      introduction_ref:0,
      history_ref:0,
      custom1_profile:"",
      custom2_profile:"",
      custom3_profile:"",
      custom1:"",
      custom2:"",
      custom3:"",
    }
  }
};

</script>
<style>
.myinput{
  padding: 0 8px 0 5px;
  background: unset;
  border-radius: unset;
  height: 45px;
  border: 0;
  font-family: IRANYekan;
}
option {
  font-family: IRANYekan;
}
.va-progress-circle{
  /*width: auto !important;*/
}
.buybtnp{
  width: 90%;
  text-align: center;

  height: 45px;
  background-color: var(--va-greencolor);
  color:white;
  border-radius: 10px;
  border:unset;
  cursor: pointer;
}
input[type="file"] {
  display: none;
}
</style>