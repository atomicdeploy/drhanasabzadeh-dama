<template>
  <div class="bg-code-2">
    <div class="flex xs12" >
      <div class="">
        <img v-if="this.login_pic!==''" style=" max-height: 50px; max-width: 85%;margin: 60px 0 0 0" :src="this.baseurl+'/images/appearance/'+this.login_pic">
        <div v-else style="height: 200px;width: 100%"></div>
      </div>
    </div>
    <div>
      <p style="padding: 30px 0 20px 0;font-weight: bold;font-size: 20px">کد تایید را وارد کنید</p>
    </div>
    <div>
      <p class="code2-text-color">{{$t('Code.activeCode',{type: this.type}) }}</p>
    </div>
    <div >
      <p class="code2-text-color" style="font-size: 13px;margin: 10px 0 0 0;color: #727272;">{{$t('Code.dontSend') }}</p>
    </div>
    <div class="row" style="text-align: center;width: 100%;justify-content: center;margin: 15% 0 15% 0;flex-direction:row-reverse">
      <div style="width: 22%; " >
        <input class="code2-input" @click="this.clean()" @keyup="this.set_f1()" type="number"  v-model="this.dig1" ref="d1"/>
      </div>
      <div style="width: 22%;">
        <input class="code2-input" @keyup="this.set_f2()" type="number" v-model="this.dig2" ref="d2"/>
      </div>
      <div style="width: 22%;">
        <input class="code2-input" @keyup="this.set_f3()" type="number" v-model="this.dig3" ref="d3"/>
      </div>
      <div style="width: 22%;" >
        <input @keyup="this.doaction()" class="code2-input" type="number" v-model="this.dig4" ref="d4"/>
      </div>
    </div>
    <div class="center" style="width: 100%;">
      <div class="row" style="text-align: center;">
        <vue-countdown :time="this.sec * 1000" v-slot="{ days, hours, minutes, seconds }">
          <div class="row justify-space-between" style="text-align: center;direction:ltr !important;">
            <p v-if="seconds===0" @click="this.resend()" style="padding: 0 3px 0 3px;color: var(--va-basecolor);font-weight: bold">ارسال دوباره</p>
            <p v-else @click="this.cantsend()" style="padding: 0 3px 0 3px;color: #a2a2a2;">ارسال دوباره</p>
            <p  style="padding: 0 5px 0 5px;width: auto">هنوز کد را دریافت نکرده اید؟</p>
            <p class="timer-code2">0{{ minutes }}</p>
            <p style="font-weight: bold" class="timer-code2">:</p>
            <p v-if="seconds>9" class="timer-code2"> {{ seconds }}</p>
            <p v-else class="timer-code2" > 0{{ seconds }}</p>

          </div>
          <div @click="this.resend()" v-if="seconds===0"  style="text-align: center;margin-top: 40px;cursor: pointer;">
          {{$t('Code.resend')}}
          </div>
        </vue-countdown>

      </div>


    </div>
    <div class="row" style="width: 100%;text-align: center;margin: 20px 0 0 0 ">
      <button v-if="this.geted===1" class="code2-btn" type="button">
        <LoadingButton />
      </button>
      <button v-else @click="this.doaction()" class="code2-btn" type="button" style="cursor: pointer">{{ $t('Code.confirmation') }}</button>
    </div>
    <div class="row" style="width: 100%;text-align: center">

  </div>
  </div>
</template>
<script>
import VueCountdown from '@chenfengyuan/vue-countdown';
import LoadingButton from '../components/LoadingButton.vue'
import { useToast } from "vue-toastification";
import {mapWritableState} from 'pinia';
import {usePermStroe} from '@/stores/permStore';
export default {
  name: "CodeNew",
  components: {
    VueCountdown,LoadingButton
  },
  computed: {
    ...mapWritableState(usePermStroe, ["forced_profile","custom1_profile","custom2_profile","custom3_profile"]),
  },
  mounted() {
    this.logo=localStorage.getItem('logo')
    this.isInStandaloneMode();
    if(localStorage.getItem('is_email')==='1'){
      this.type=this.$t('Code.email');
    }
    else{
      this.type=this.$t('Code.sms');
    }
    this.$refs.d1.focus();
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
    doaction(){
      var courseref=localStorage.getItem('CourseRefGl')
      var page=localStorage.getItem('Page')
      var typeGl=localStorage.getItem('typeGl')
      if(this.dig1==="" || this.dig2==="" || this.dig3==="" || this.dig4===""){
        this.$swal({
          title: this.$t('General.error'),
          text: this.$t('Code.correctly'),
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
      this.$http(
          {
            method: "post",
            url: this.apiurl,
            timeout: 1000 * 15, // Wait for 5 seconds
            headers: {
              "Content-Type": "application/json",
            },
            data: {
              action: "signin",
              code: this.dig1.toString()+this.dig2.toString()+this.dig3.toString()+this.dig4.toString(),
              mobile: localStorage.getItem('mobile'),
              reagent: localStorage.getItem('reagent'),
              email: localStorage.getItem('email'),
              lang:this.$i18n.locale,
            }
          })
          .then((response) => {
            if(response.data.ok===1){
              this.geted=2;
              localStorage.setItem('android_link', response.data.android_link);
              localStorage.setItem('tk', response.data.tk);
              localStorage.setItem('credit', response.data.credit);
              localStorage.setItem('gem', response.data.gem);
              localStorage.setItem('name', response.data.name);
              this.forced_profile=response.data.forced_profile
              if(typeGl!==null && typeGl==='buychannel'){
                this.$router.push({ path: "/channel" })
              }
              else if(courseref!=='' && courseref!==null && courseref!=='0'){
                if(page==='invoice'){
                  this.$router.push({ path: "/invoice/"+courseref })
                }
                else{
                  this.$router.push({ path: "/meets/"+courseref })
                }
              }
              else if(this.forced_profile===1 && response.data.compelete<100){
                this.$router.push({ path: "/profile" })
              }
              else{
                this.$router.push({ path: "/" })
              }

              // if(this.iswebapp){
              //   this.$router.push({ path: '/',query:{ f: 1 } })
              // }
              // else{
              //   this.$router.push({ path: '/installer' })
              // }
            }
            else{
              this.dig1=this.dig2=this.dig3=this.dig4="";
              this.$refs.d1.focus();
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
            this.geted=3;
            if(error.response.status===401){
              this.errTitle = this.$t('General.receivingError');
              this.errMsg = this.$t('General.tryAgain');
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
            else{
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

    cantsend(){
      useToast().warning('تا صفر شدن ثانیه شمار صبر کنید', {
        timeout: 3000,
        position:'top-center'
      });
    },
    resend(){
      this.sec=100;
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
              mobile: localStorage.getItem('mobile'),
              reagent: localStorage.getItem('reagent'),
              email: localStorage.getItem('email'),
              lang:this.$i18n.locale,
            }
          })
          .then((response) => {
            if(response.data.ok===1){

            }
            else{
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
    clean(){
      this.dig1="";
      this.dig2="";
      this.dig3="";
      this.dig4="";
    },
    set_f1(){
      this.dig2="";
      this.dig3="";
      this.dig4="";
      this.$refs.d2.focus();
    },
    set_f2(){
      this.$refs.d3.focus();
    },
    set_f3(){
      this.$refs.d4.focus();
    },
  },
  data(){
    return{
      logo:"",
      dig1:"",
      dig2:"",
      dig3:"",
      dig4:"",
      type:this.$t('Code.sms'),
      sec:90,
      geted:0,
      iswebapp:false
    }
  }
};
</script>
<style>

.timer-code2 {
  font-size: 20px;
  color: var(--va-basecolor);
}
.s1{
  margin: 22px !important;
}
.code-input{
  width:45px;
  height: 45px;
  text-align: center;
  border-radius: 10px;
  margin: 5px;
  border: var(--va-basecolor) 2px solid;
}
.code2-input{
  width:50px;
  height: 50px;
  text-align: center;
  border-radius: 15px;
  margin: 5px;
  background: #eaeaea;
  border: #8a8a8a 1px solid;
}

input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}
/* Firefox */
input[type=number] {
  -moz-appearance: textfield;
}



.code2-btn{
  width: 100%;
  text-align: center;
  margin:20px 0 0 0;
  height: 45px;
  background-image: linear-gradient(90deg, var(--va-basecolor) 0%, var(--va-seccolor) 100%);

  color:white;
  border-radius: 25px;
  border:unset
}
.bg-code-2{
  height: 100vh;
  padding: 20px; background: white;
  background-image: url('../assets/images/bg-mobile-2.png');
  background-size: cover;
  background-position: center center;
  background-attachment: fixed;
  overflow: auto;
}
.code2-text-color{
  color: #525252;
  font-size: 15px;
}
</style>