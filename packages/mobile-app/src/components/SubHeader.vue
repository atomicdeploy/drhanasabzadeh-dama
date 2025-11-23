<template>

  <div class="row"  :class="{ltr_lang:$t('config.dir')==='ltr',rtl_lang:$t('config.dir')==='rtl'}" style="height: 90px;width: 100%;text-align: center;background-color: white">
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
    <div @click="this.goToPage('/profile')" style="width:32%;cursor: pointer;padding:0 10px 0 10px" >
      <div class="row">
        <div class="flex xs2" style="margin-right: 2%">
          <font-awesome-icon v-if="this.profilepic==='' || this.profilepic===null" icon="fa-solid fa-circle-user" style="padding-top: 5px;font-size: 1.3rem"  :style="{ color: '#bebebe' }"/>
          <img v-else :src="this.baseurl.replace('panel.','')+'/images/profile/'+this.profilepic" style="height: 22px;max-width:22px;border-radius: 11px;margin-top: 3px; ">
        </div>
        <div style="width:65%;margin-top: 8px;margin-right:7px;margin-left: 5px" :class="{ltr_lang:$t('config.dir')==='ltr',rtl_lang:$t('config.dir')==='rtl'}">
          <span style="font-size: 12px">{{this.name}}</span>
        </div>
      </div>
    </div>
    <div v-if="this.appdirectory!=='51'" style="width:25%;cursor: pointer" @click="this.goToPage('/wallet')">
      <div class="row" >
        <div class="flex xs2" >
          <font-awesome-icon icon="fa-solid fa-ticket" style=";padding-top: 4px;font-size: 1.4rem"  :style="{ color: '#bebebe' }"/>
        </div>
        <div style="margin-top: 8px;margin-right:14px;margin-left: 14px" :class="{ltr_lang:$t('config.dir')==='ltr',rtl_lang:$t('config.dir')==='rtl'}">
          <span style="font-size: 12px">{{this.gem}}</span>
        </div>
      </div>
    </div>
    <div v-else style="width:15%;">
    </div>
    <div style="width:29%;cursor: pointer" @click="this.goToPage('/wallet')">
      <div class="row">
        <div class="flex xs2">
          <font-awesome-icon icon="fa-solid fa-credit-card" style=";padding-top: 4px;font-size: 1.3rem"   :style="{ color: '#bebebe' }"/>
        </div>
        <div style="margin-top: 8px;margin-right:10px;margin-left:12px;text-align: right;">
          <span style="font-size: 12px">{{this.credit}}</span>
        </div>
      </div> </div>
    <div v-if="this.appdirectory==='51'" style="width:10%;"></div>
    <div style="width:12%;cursor: pointer;padding:0 10px 0 10px" @click="this.goToPage('/search')">
      <font-awesome-icon icon="fa-solid fa-magnifying-glass" style=";padding-top: 4px;;padding-left: 5px;padding-right:5px;font-size: 1.3rem"  :style="{ color: '#bebebe' }"/>
    </div>
  </div>

</template>

<script>
import { library } from '@fortawesome/fontawesome-svg-core'
import Loading from '../components/Loading.vue'
import { faBars,faCircleUser,faTicket,faCreditCard,faMagnifyingGlass } from '@fortawesome/free-solid-svg-icons'
import { faBell } from '@fortawesome/free-regular-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import 'gitart-vue-dialog/dist/style.css'
import { GDialog } from 'gitart-vue-dialog'
library.add(faBars,faBell,faCircleUser,faTicket,faCreditCard,faMagnifyingGlass)
export default {
  name: "SubHeader.vue",
  components: {
    FontAwesomeIcon,GDialog
  },

  data(){
    return{
      loginDialog:false,
      name:'کاربر مهمان',
      gem:'0 امتیاز',
      credit:'0 تومان',
      profilepic:'',
    }
  },
  // computed: {
  //   // computed property that auto-updates when the prop changes
  //   dashboardPath() {
  //     if(this.group_ref===0){
  //       return "/";
  //     }
  //     else if(this.group_ref===1){
  //       return "/admin/dashboard";
  //     }
  //    else if(this.group_ref===2){
  //       return "/support/dashboard";
  //     }
  //     else if(this.group_ref===3){
  //       return "/kooshayar/dashboard";
  //     }
  //     else if(this.group_ref===4){
  //       return "/student/dashboard";
  //     }
  //      else if(this.group_ref===5){
  //       return "/agent/dashboard";
  //     }
  //     else{
  //       return false;
  //     }
  //   }
  // },
  mounted() {
    this.name=localStorage.getItem('name');
    this.gem=localStorage.getItem('gem');
    this.credit=localStorage.getItem('credit');
    this.profilepic=localStorage.getItem('profilepic');
  },
  methods:{
    goToPage(page){
      if(page==='/profile' && (localStorage.getItem('tk')==="" || localStorage.getItem('tk')===null)){
        this.loginDialog=true;
        return;
      }
      else{
        this.$router.push({ path: page })
      }

    },
    HeaderOpenMenu(){
      this.$emit('headeropenMenu')
    }
  },
}
</script>
<style>
div{
  font-family: IRANYekan !important;
}
</style>