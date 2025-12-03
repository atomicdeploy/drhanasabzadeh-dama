<template>
  <div class="flex xs12" >
    <div class="item" style="text-align: center">
      <img style="width: 40%;padding-top:10px;" :src="this.baseurl+'/images/apps/'+this.logo">
    </div>
  </div>
  <div class="center" style="width: 100%;">
    <div class="row" style="text-align: center;">
      <vue-countdown :time="this.sec * 1000" v-slot="{ days, hours, minutes, seconds }" style="width: 100%;margin-top: 80px;margin-bottom: 100px">
        <div class="row" style="text-align: center;justify-content: center;direction:ltr !important;">
          <div style="width: 20%;" >
            <div style="background: var(--va-seccolor);border-radius: 5px">
              <p style="width: 100%;padding-top: 20px" class="timer">0{{ minutes }}</p>
            </div>
          </div>
          <div style="width: 10%" >
            <p style="padding: 40% 5% 0 2%;font-size: 28px;font-weight: bold">:</p>
          </div>
          <div style="width: 20%;" >
            <div style="background:var(--va-seccolor);border-radius: 5px">
              <p style="width: 100%;padding-top: 20px" class="timer" v-if="seconds>9"> {{ seconds }}</p>
              <p style="width: 100%;padding-top: 20px" class="timer" v-else> 0{{ seconds }}</p>
            </div>
          </div>
        </div>
        <div @click="this.resend()" v-if="seconds===0"  style="text-align: center;margin-top: 40px;cursor: pointer;width: 100%">
        {{$t('Code.resend')}}
        </div>
      </vue-countdown>
    </div>
    <div class="row" style="text-align: center !important">
      <p style="font-size: 15px;width:94%;margin: 0 3% 10px 3%; text-align:center;color: var(--va-textcolor);font-weight: bold">{{$t('Code.activeCode',{type: this.type}) }}</p>
    </div>
    <div class="row" style="text-align: center !important">
      <p style="font-size: 13px;width:94%;margin: 0 3% 0 3%; text-align:center;color: var(--va-textcolor)">{{$t('Code.dontSend') }}</p>
    </div>
    <div v-if="this.$t('config.lang')==='fa'" class="row" style="text-align: center;width: 100%;justify-content: center;margin: 10% 0 10% 0;flex-direction:row-reverse">
      <div style="width: 15%; " >
        <input class="code-input" @click="this.clean()" @keyup="this.set_f1()" type="number"  v-model="this.dig1" ref="d1"/>
      </div>
      <div style="width: 15%;">
        <input class="code-input" @keyup="this.set_f2()" type="number" v-model="this.dig2" ref="d2"/>
      </div>
      <div style="width: 15%;">
        <input class="code-input" @keyup="this.set_f3()" type="number" v-model="this.dig3" ref="d3"/>
      </div>
      <div style="width: 15%;" >
        <input @keyup="this.doaction()" class="code-input" type="number" v-model="this.dig4" ref="d4"/>
      </div>
    </div>
    <div v-else class="row" style="text-align: center;width: 100%;justify-content: center;margin: 10% 0 10% 0;flex-direction:row-reverse">
      <div style="width: 15%;" >
        <input @keyup="this.doaction()" class="code-input" type="number" v-model="this.dig4" ref="d4"/>
      </div>
      <div style="width: 15%;">
        <input class="code-input" @keyup="this.set_f3()" type="number" v-model="this.dig3" ref="d3"/>
      </div>
      <div style="width: 15%;">
        <input class="code-input" @keyup="this.set_f2()" type="number" v-model="this.dig2" ref="d2"/>
      </div>
      <div style="width: 15%; " >
        <input class="code-input" @click="this.clean()" @keyup="this.set_f1()" type="number"  v-model="this.dig1" ref="d1"/>
      </div>
    </div>
  </div>
  <div class="row" style="width: 100%;text-align: center;">
    <button v-if="this.geted===1" class="mybtn" type="button">
      <LoadingButton />
    </button>
    <button v-else @click="this.doaction()" class="mybtn" type="button" style="cursor: pointer">{{ $t('Code.confirmation') }}</button>
  </div>
  <div class="row" style="width: 100%;text-align: center">
    <img class="line" src="../assets/line.png">
  </div>
</template>
<script>
import VueCountdown from '@chenfengyuan/vue-countdown';
import LoadingButton from '../components/LoadingButton.vue'

export default {
  name: "CodeNew",
  components: {
    VueCountdown,LoadingButton
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

              if(typeGl!==null && typeGl==='buychannel'){
                this.$router.push({ path: "/channel" })
              }
              else if(courseref!==null && courseref!=='0'){
                if(page==='invoice'){
                  this.$router.push({ path: "/invoice/"+courseref })
                }
                else{
                  this.$router.push({ path: "/meets/"+courseref })
                }

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

.timer {
  padding-top: 16px;
  width: 60px;
  height: 60px;
  font-size: 25px;
  font-weight: bold;
  color: white;
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
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}
/* Firefox */
input[type=number] {
  -moz-appearance: textfield;
}

</style>