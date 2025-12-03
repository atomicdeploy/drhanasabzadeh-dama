<template>
  <div class="bg-mobile-2">
  <div class="flex xs12" >
    <div class="">
      <img v-if="this.login_pic!==''" style=" max-height: 50px; max-width: 85%;margin: 60px 0 0 0" :src="this.baseurl+'/images/appearance/'+this.login_pic">
      <div v-else style="height: 200px;width: 100%"></div>
    </div>
  </div>
  <div>
    <p style="padding: 30px 0 20px 0;font-weight: bold;font-size: 20px">ورود | ثبت نام</p>
  </div>
  <div>
    <p class="mobile2-text-color">آیا داخل ایران هستید؟</p>
  </div>
  <div class="row justify-center " style="margin-top: 20px;padding: unset">
   <div class="row justify-start mycard" style="background: #F2F4F3;border-radius: 25px;padding: 10px">
     <div class="row" style="padding: 0 5px 0 0">
       <input type="radio" id="iniran" value="1" v-model="this.selectedOption" class="myradio" name="iniran"/>
       <label for="iniran" style="margin: 2px 10px 0 5px">بله</label>
     </div>
     <div class="row" style="padding: 0 5px 0 0">
       <input type="radio" id="notiran" value="2" v-model="this.selectedOption" class="myradio" name="iniran"/>
       <label for="notiran" style="margin: 2px 10px 0 5px">خیر</label>
     </div>

    </div>
  </div>

  <!--  <div>-->
  <!--    Selected: {{ selectedOption }}-->
  <!--  </div>-->

  <div  v-if="this.selectedOption==='1'" style="margin:40px 0 0 0;text-align: right">
    <span class="mobile2-text-color" style="font-size: 14px;">{{$t('Mobile.mobile')}}</span>
  </div>
  <div  v-if="this.selectedOption==='1'" class="row" style="width: 100%;">
    <div class="mycard" style="width: 100%;padding-bottom: 20px !important;background-color: white;margin:15px 0 20px 0;color: #888585;height:45px;border-radius: 20px">
      <div class="flex xs12" style="height: 45px">
        <input class="mycard" maxlength="11" v-model="this.mobile" type="tel" style="width: 100%;height: 88%;text-align:center;direction: ltr;margin:2px 0 1px 0; padding: 1px 0 0 0;font-size: 16px;border:none;outline-width: 0;">
      </div>
    </div>

  </div>
  <div v-if="this.selectedOption==='2'" class="row">
    <span class="mobile2-text-color" style="font-size: 14px;margin: 40px 0 0 0;width: 100%;">{{$t('Mobile.email')}}</span>
  </div>
  <div v-if="this.selectedOption==='2'" class="row" style="width: 100%;">
    <div style="width: 100%;padding-bottom: 20px !important;background-color: white !important;margin:20px 0 20px 0;color: #888585;height:45px;border: #888585 solid 1px;border-radius: 20px">
      <div class="flex xs12" style="height: 45px">
        <input v-model="this.email" type="email" style="width: 100%;height: 88%;direction: ltr;text-align: center; margin:2px 0 1px 0; padding: 1px 0 0 0;font-size: 15px;border:none;outline-width: 0;">
      </div>
    </div>
  </div>

  <div  v-if="this.selectedOption==='1'" class="row">
    <span class="mobile2-text-color" style="font-size: 14px;margin: 20px 0 15px 0;width: 100%">{{$t('Mobile.introduce')}}</span>
  </div>
  <div  v-if="this.selectedOption==='1' " class="row" style="text-align: center;width: 100%;margin-bottom: 30px">
    <div class="row justify-center mycard" style="background: #F2F4F3;border-radius: 25px;padding: 10px">
      <div class="row" style="padding: 0 5px 0 0">
        <input type="radio" id="noreagent" value="1" v-model="this.selectedOption_reagent" class="myradio" name="reagent"/>
        <label for="noreagent" style="margin: 2px 10px 0 5px">خیر</label>
       </div><div class="row" style="padding: 0 5px 0 0">
        <input type="radio" id="yesreagent" value="2" v-model="this.selectedOption_reagent" class="myradio" name="reagent"/>
        <label for="yesreagent" style="margin: 2px 10px 0 5px">بله</label>
    </div>
    </div>

  </div>
  <div class="row"  v-if="this.selectedOption==='1' && selectedOption_reagent==='2'">
    <span class="mobile2-text-color" style="font-size: 14px;margin-top: 20px;width: 100%">{{$t('Mobile.representative')}}</span>
  </div>
  <div  v-if="this.selectedOption==='1' && selectedOption_reagent==='2'" class="row" style="width: 100%;padding-bottom: 1px">
    <div class="mycard" style="width: 100%;padding-bottom: 20px !important;background-color: white;margin:15px 0 0 0;color: #888585;height:45px;border-radius: 20px">
      <div class="flex xs12" style="height: 45px">
        <input class="mycard" v-model="this.reagent" type="tel" style="width: 100%;height: 88%;direction: ltr;text-align: center; padding: 1px 0 0 0;font-size: 15px;border:none;outline-width: 0;">
      </div>
    </div>
  </div>

  <div class="row " style="width: 100%;margin-top:5%;text-align: center;margin-bottom: 20px">
    <button v-if="this.geted===1" class="mobile2-btn" type="button" >
      <LoadingButton/>
    </button>
    <button v-else @click="this.doaction()" class="mobile2-btn" type="button">
      {{$t('Mobile.confirmation')}}
    </button>
  </div>
</div>


</template>
<style scoped>

</style>
<script>
import HeaderHome from '../components/HeaderHome.vue'
import Footer from '../components/Footer.vue'
import Loading from '../components/Loading.vue'
import LoadingButton from '../components/LoadingButton.vue'

import { library } from '@fortawesome/fontawesome-svg-core'
import { faSolarPanel,faInfo,faEye,faAngleLeft,faLeftLong } from '@fortawesome/free-solid-svg-icons'
import { faShopify,faReadme } from '@fortawesome/free-brands-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
library.add(faSolarPanel,faShopify,faReadme,faInfo,faEye,faAngleLeft,faLeftLong)

export default {
  name: 'Mobile',
  components: {
    HeaderHome, Footer, Loading,LoadingButton,FontAwesomeIcon
  },
  mounted() {
    this.loginPic()
    localStorage.setItem('tk', "");
    window.scrollTo(0,0);
  },
  data() {
    return {
      geted:0,
      errTitle:"",
      errMsg:"",
      login_pic:"",
      logo:"",
      options: [
        1,
        2,
      ],
      labels: [
        this.$t('Mobile.inIran'),
        this.$t('Mobile.outIran'),
      ],
      selectedOption: '1',

      options_reagent: [
        1,
        2,
      ],
      labels_reagent: [
        this.$t('Mobile.no'),
        this.$t('Mobile.yes'),
      ],
      selectedOption_reagent: 1,
      formatter : new Intl.NumberFormat('en', {
        maximumFractionDigits:0,
      }),
      mobile:"",
      email:"",
      reagent:""
    }
  },
  methods: {
    loginPic(){
      this.$http(
          {
            method: "post",
            url: this.apiurl,
            timeout: 1000 * 8, // Wait for 5 seconds
            headers: {
              "Content-Type": "application/json",
              "Authorization": 'Bearer lkasjdqkjqma'
            },
            data: {
              action: "loginPic",
              lang:this.$i18n.locale,
            }
          })
          .then((response) => {
            if(response.data.ok===1){
              this.login_pic=response.data.login_pic
              this.logo=response.data.logo
              localStorage.setItem('logo',this.logo);
            }
          })
          .catch(error => {
            if(error.response.status===401){
              this.errTitle = this.$t('General.receivingError');
              this.errMsg = this.$t('General.tryAgain');
            }
            else{
              this.getedReg = 3;
              if (error.code === 'ECONNABORTED') {
                this.errTitle = this.$t('General.receivingError');
                this.errMsg = this.$t('General.tryAgain');
              } else {
                this.errTitle = this.$t('General.error');
                this.errMsg = error.message;
              }
              this.$swal({
                title: this.errTitle,
                text: this.errMsg,
                icon: 'warning',
                confirmButtonText: this.$t('General.ok'),
                customClass: {
                  confirmButton: 'btn btn-primary'
                },
                buttonsStyling: false
              });
            }
          });
    },
    doaction(){
      this.mobile=this.fixNumbers(this.mobile);
      this.reagent=this.fixNumbers(this.reagent);

      var swal_err="";
      if(this.selectedOption===1 && (this.mobile.length<10 || this.mobile.length>11)){
        swal_err= "شماره همراه خود را به صورت صحیح وارد کنید.";
      }
      if(swal_err!==""){
        this.$swal({
          title: this.$t('General.error'),
          text: swal_err,
          icon: 'error',
          confirmButtonText:this.$t('General.ok'),
          customClass: {
            confirmButton: 'btn btn-primary'
          },
          buttonsStyling: false
        });
        swal_err="";
        return;
      }

      this.geted=1;
      this.$http(
          {
            method: "post",
            url: this.apiurl,
            timeout: 1000 * 15, // Wait for 5 seconds
            headers: {
              "Content-Type": "application/json",
              "Authorization": 'Bearer lkasjdqkjqma'
            },
            data: {
              action: "sendsms",
              mobile: this.mobile,
              reagent: this.reagent,
              email: this.email,
              lang:this.$i18n.locale,
            }
          })
          .then((response) => {
            if(response.data.ok===1){
              this.geted=2;
              localStorage.setItem('tk', "");
              localStorage.setItem('fname', response.data.fname);
              localStorage.setItem('lname', response.data.lname);
              localStorage.setItem('mobile', response.data.mobile);
              localStorage.setItem('reagent', response.data.reagent);
              localStorage.setItem('email', response.data.email);
              localStorage.setItem('is_email', response.data.is_email);
              this.$router.push({ path: '/code' })
              // this.$router.replace({ path: '/code' })
            }
            else{
              this.geted=3;
              this.errTitle=response.data.title;
              this.errMsg=response.data.msg;
              this.$swal({
                title: this.errTitle,
                text: this.errMsg,
                icon: 'warning',
                confirmButtonText: this.$t('General.ok'),
                customClass: {
                  confirmButton: 'btn btn-primary'
                },
                buttonsStyling: false
              });
            }
          })
          .catch(error => {
            if(error.response.status===401){
              this.errTitle = this.$t('General.receivingError');
              this.errMsg = this.$t('General.tryAgain');
              // localStorage.setItem('token', "");
              // this.$router.push({ path: '/login' })
            }
            else{
              this.getedReg = 3;
              if (error.code === 'ECONNABORTED') {
                this.errTitle = this.$t('General.receivingError');
                this.errMsg = this.$t('General.tryAgain');
                // timed out
              } else {
                this.errTitle = this.$t('General.error');
                this.errMsg = error.message;
                // console.log(error.message)
              }
              this.$swal({
                title: this.errTitle,
                text: this.errMsg,
                icon: 'warning',
                confirmButtonText: this.$t('General.ok'),
                customClass: {
                  confirmButton: 'btn btn-primary'
                },
                buttonsStyling: false
              });
            }
          });

    },
    fixNumbers(str)
    {
      var persianNumbers = [/۰/g, /۱/g, /۲/g, /۳/g, /۴/g, /۵/g, /۶/g, /۷/g, /۸/g, /۹/g];
      var arabicNumbers  = [/٠/g, /١/g, /٢/g, /٣/g, /٤/g, /٥/g, /٦/g, /٧/g, /٨/g, /٩/g];
      if(typeof str === 'string')
      {
        for(var i=0; i<10; i++)
        {
          str = str.replace(persianNumbers[i], i).replace(arabicNumbers[i], i);
        }
      }
      return str;
    }
  }
}
</script>
<style>
.va-radio__text{
  padding-right: 5px;
}
.item {
  text-align: center;
}
.mobile2-text-color{
  color: #727272;
}

input[type="radio"] {
  appearance: none;
  -webkit-appearance: none;
  -moz-appearance: none;
  width: 20px;
  height: 20px;
  background-color: white;
  border: 2px solid black;
  border-radius: 5px;
  position: relative;
  cursor: pointer;
}

input[type="radio"]:checked {
  background-color: black;
}

input[type="radio"]:checked::after {
  content: "\2713";
  color: white;
  font-size: 18px;
  font-weight: bold;
  position: absolute;
  top: 1px;
  left: 1px;
}
.mobile2-btn{
  width: 100%;
  text-align: center;
  margin:20px 0 0 0;
  height: 45px;
  background-image: linear-gradient(90deg, var(--va-basecolor) 0%, var(--va-seccolor) 100%);

  color:white;
  border-radius: 25px;
  border:unset
}
.bg-mobile-2{
  height: 100vh;
  padding: 20px; background: white;
  background-image: url('../assets/images/bg-mobile-2.png');
  background-size: cover;
  background-position: center center;
  background-attachment: fixed;
  overflow: auto;
}
</style>