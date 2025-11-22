<template>

  <div class="flex xs12" >
    <div class="item">
      <img style="height: 50px" :src="this.baseurl+'/images/apps/'+this.logo">
    </div>
  </div>
  <div class="flex xs12" >
    <div class="item">
      <img v-if="this.login_pic!==''" style=" max-height: 200px; max-width: 85%;margin: 0 5% 0 5%" :src="this.baseurl+'/images/appearance/'+this.login_pic">
      <div v-else style="height: 200px;width: 100%"></div>
    </div>
  </div>
  <div v-if="this.$t('config.lang')==='fa'" class="row justify-center" style="margin-top: 20px">
   <div class="row justify-center">
     <input type="radio" id="iniran" value="1" v-model="this.selectedOption" class="myradio" name="iniran"/>
     <label for="iniran" style="margin: 2px 5px 0 5px">{{$t('Mobile.inIran')}}</label>
     <div style="width: 20px"></div>
    <input type="radio" id="notiran" value="2" v-model="this.selectedOption" class="myradio" name="iniran"/>
    <label for="notiran" style="margin: 2px 5px 0 5px">{{$t('Mobile.outIran')}}</label>
    </div>
  </div>

  <!--  <div>-->
  <!--    Selected: {{ selectedOption }}-->
  <!--  </div>-->

  <div  v-if="this.selectedOption==='1'" style="margin:40px 0 0 0;text-align: center">
    <span style="color: var(--va-textcolor);font-size: 14px;">{{$t('Mobile.mobile')}}</span>
  </div>
  <div  v-if="this.selectedOption==='1'" class="row" style="width: 100%;">
    <div style="width: 100%;padding-bottom: 20px !important;background-color: white !important;margin:20px 20px 20px 20px;color: #888585;height:45px;border: #888585 solid 1px;border-radius: 10px">
      <div class="flex xs12" style="height: 45px">
        <input maxlength="11" v-model="this.mobile" type="tel" style="width: 100%;height: 88%;text-align:center;direction: ltr;margin:2px 0 1px 0; padding: 1px 0 0 0;font-size: 16px;border:none;outline-width: 0;">
      </div>
    </div>

  </div>
  <div v-if="this.selectedOption==='2'" class="row">
    <span style="color: var(--va-textcolor);font-size: 14px;margin: 40px 0 0 0;width: 100%;text-align: center">{{$t('Mobile.email')}}</span>
  </div>
  <div v-if="this.selectedOption==='2'" class="row" style="width: 100%;">
    <div style="width: 100%;padding-bottom: 20px !important;background-color: white !important;margin:20px 20px 20px 20px;color: #888585;height:45px;border: #888585 solid 1px;border-radius: 10px">
      <div class="flex xs12" style="height: 45px">
        <input v-model="this.email" type="email" style="width: 100%;height: 88%;direction: ltr;text-align: center; margin:2px 0 1px 0; padding: 1px 0 0 0;font-size: 15px;border:none;outline-width: 0;">
      </div>
    </div>
  </div>

  <div  v-if="this.selectedOption==='1'" class="row">
    <span style="color: var(--va-textcolor);font-size: 14px;text-align: center;margin: 20px 0 30px 0;width: 100%">{{$t('Mobile.introduce')}}</span>
  </div>
  <div  v-if="this.selectedOption==='1' " class="row" style="text-align: center;width: 100%;margin-bottom: 30px">
    <div class="row justify-center">

        <input type="radio" id="noreagent" value="1" v-model="this.selectedOption_reagent" class="myradio" name="reagent"/>
        <label for="noreagent" style="margin: 2px 5px 0 5px">{{$t('Mobile.no')}}</label>
        <div style="width: 20px"></div>
        <input type="radio" id="yesreagent" value="2" v-model="this.selectedOption_reagent" class="myradio" name="reagent"/>
        <label for="yesreagent" style="margin: 2px 5px 0 5px">{{$t('Mobile.yes')}}</label>

    </div>

  </div>
  <div class="row"  v-if="this.selectedOption==='1' && selectedOption_reagent==='2'">
    <span style="color: var(--va-textcolor);font-size: 14px;text-align: center;margin-top: 20px;width: 100%">{{$t('Mobile.representative')}}</span>
  </div>
  <div  v-if="this.selectedOption==='1' && selectedOption_reagent==='2'" class="row" style="width: 100%;padding-bottom: 1px">
    <div style="width: 100%;padding-bottom: 20px !important;background-color: white !important;margin:20px 20px 0 20px;color: #888585;height:45px;border: #888585 solid 1px;border-radius: 10px">
      <div class="flex xs12" style="height: 45px">
        <input v-model="this.reagent" type="tel" style="width: 100%;height: 88%;direction: ltr;text-align: center; padding: 1px 0 0 0;font-size: 15px;border:none;outline-width: 0;">
      </div>
    </div>
  </div>

  <div class="row " style="width: 100%;margin-top:5%;text-align: center;margin-bottom: 20px">
    <button v-if="this.geted===1" class="mybtn" type="button" >
      <LoadingButton/>
    </button>
    <button v-else @click="this.doaction()" class="mybtn" type="button">
      {{$t('Mobile.confirmation')}}
    </button>
  </div>
  <div class="row"  style="width: 100%;text-align: center">
    <img class="line" src="../assets/line.png">
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
    if(this.$t('config.lang')!=='fa'){
      this.selectedOption='2'
    }
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

</style>