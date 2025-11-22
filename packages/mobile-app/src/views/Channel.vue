<template>
    <Header  @headeropenMenu="this.homeOpenMenu()"  :isHome="0"/>

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
  <Loading v-if="this.geted===1" />
  <div class="center" style="width: 100%;" >
    <div class="row" v-if="this.geted===2" style="margin: 4% 4% 1% 4%">
      <p style="font-size: 13px;width: 50%;padding: 3% 2% 3% 0;font-weight: bold">مطالب آموزشی</p>
      <p style="font-size: 13px;width: 50%;text-align: left;padding: 3% 3% 3% 2%">
        <font-awesome-icon icon="fa-solid fa-caret-down" style="font-size: 0.75rem;padding-left: 4px"/>
      </p>
    </div>
   </div>
  <div v-for="channel in data" :key="channel.ID" v-if="this.geted===2 ">
    <div @click="this.toChannel(channel)"   class="row" style="margin: 4%">
<!--      <img class="img-contact" :src="this.baseurl+'/images/channel/'+channel.Pic" >-->
      <img v-if="channel.Pic===''" class="img-contact" src="../assets/images/nopic.png" >
      <div v-else class="imagediv">
        <va-avatar size="large"  >
          <img  class="img-contact" :src="this.baseurl+'/images/channel/'+channel.Pic" >
        </va-avatar>
      </div>

      <div style="flex-direction: column;justify-content:center;display: flex;width: 100%">
        <p style="padding: 0 15px 10px 0;" class="default">{{ channel.Name }}</p>
        <p v-if="channel.Discription!=='' && channel.Discription!==null" class="default" style="font-size: 13px;margin: 0 15px 0 5px;color: #7b7b7b;line-height: 17px;">{{ channel.Discription }}</p>
        <div v-if="channel.access_type===3" style="flex-direction: row;justify-content:left;display: flex;margin-top: 5px">
          <p style="text-align: left;color:#909090;text-decoration: line-through;">{{ channel.price_off }}</p>
          <div style="width: 15px"></div>
          <p style="text-align: left;color:var(--va-greencolor);font-weight: bold">{{ channel.price }} تومان</p>
        </div>
        <div v-if="channel.access_type===4" style="flex-direction: row;justify-content:left;display: flex;margin-top: 5px">
          <p style="text-align: left;color:var(--va-greencolor);font-weight: bold">اشتراکی</p>
        </div>

      </div>


    </div>
    <div class="row" style="background-color: #8d8c8c;width: 92%;height:1px;margin: 4% 4% 4% 4%"></div>


  </div>



  <div id="myCahnnelModal" class="modal" style="position: absolute !important;max-width: 540px">

    <!-- Modal content -->
    <div  class="modal-content" style="max-width: 540px;border-top-left-radius: 20px;border-top-right-radius: 20px;">

      <div class="row" style="margin-bottom: 10px">
        <p style="width: 82%;padding:20px 20px 0 20px">فعالسازی کانال</p>
        <div style="width:12%; margin: 0 4% 0 2%" :class="{rtl_lang:$t('config.dir')==='ltr',ltr_lang:$t('config.dir')==='rtl'}">
          <va-avatar style="margin: 10px 10px 0 5px;background-color: var(--va-basecolor);cursor: pointer" size="small"  @click="this.close()"   color="red"><span style="font-size: 35px;margin-top: 5px">&times;</span></va-avatar>
        </div>
      </div>
      <hr/>
      <div style="width:96%;margin: 10px 2% 5px 2%;padding:10px 10px 0 10px ;cursor: pointer;border-radius: 15px;">

        <div class="row" style="margin: 5px 5px 15px 3%">
          <vue-feather type="bell" size="22" style="margin: 1% 0 0 1%"></vue-feather>
          <p style="margin: 2%;font-size: 16px">نام کانال: </p>
          <p  style="margin: 2%;font-weight: bold;color: var(--va-greencolor)">{{ this.ch_name }}</p>
        </div>
        <!---- sale --->
        <div class="row" style="margin: 5px 5px 15px 3%">
          <vue-feather type="credit-card" size="22" style="margin: 1% 0 0 1%"></vue-feather>
          <p style="margin: 2%;font-size: 16px">مبلغ قابل پرداخت: </p>
          <p  style="margin: 2%;font-weight: bold;color: var(--va-greencolor)">{{ this.formatter.format(this.ch_pay_price) }} تومان</p>
        </div>
        <!--- sub ---->
        <p v-if="this.ch_access_type===4" style="margin: 0 10px 10px 0">یکی از آیتم های زیر را انتخاب کنید</p>
        <div v-if="this.ch_access_type===4" style="border: 1px solid #9e9e9e ;border-radius: 15px">

          <div v-if="this.ch_price1>0" @click="this.selectedSub(1)" class="row justify-space-between" style="margin: 5px ;border-radius: 15px;color:white;padding: 10px" :class="{active_plan:this.ch_active===1,deactive_plan:this.ch_active!==1}">
            <div class="row">
              <vue-feather v-if="this.ch_active===1" type="check-circle" size="22" style="margin: 1% 0 0 1%"></vue-feather>
              <vue-feather v-else type="circle" size="22" style="margin: 1% 0 0 1%"></vue-feather>
              <p style="margin: 2%;font-size: 16px">اشتراک 1 ماهه</p>
            </div>
            <div class="row justify-end" >
              <p v-if="this.ch_price_off1>0"  style="margin: 5px 0 0 10px;text-decoration: line-through;">{{ this.ch_price_off1 }}</p>
              <p  style="margin: 5px 10px 0 0;font-weight: bold;">{{ this.formatter.format(this.ch_price1) }} تومان</p>
            </div>
          </div>
          <div v-if="this.ch_price3>0" @click="this.selectedSub(3)" class="row justify-space-between" style="margin: 5px ;border-radius: 15px;color:white;padding: 10px" :class="{active_plan:this.ch_active===3,deactive_plan:this.ch_active!==3}">
            <div class="row">
              <vue-feather v-if="this.ch_active===3" type="check-circle" size="22" style="margin: 1% 0 0 1%"></vue-feather>
              <vue-feather v-else type="circle" size="22" style="margin: 1% 0 0 1%"></vue-feather>
              <p style="margin: 2%;font-size: 16px">اشتراک 3 ماهه</p>
            </div>
            <div class="row justify-end" >
              <p v-if="this.ch_price_off3>0"  style="margin: 5px 0 0 10px;text-decoration: line-through;">{{ this.ch_price_off3 }}</p>
              <p  style="margin: 5px 10px 0 0;font-weight: bold;">{{ this.formatter.format(this.ch_price3) }} تومان</p>
            </div>
          </div>
          <div v-if="this.ch_price6>0" @click="this.selectedSub(6)" class="row justify-space-between" style="margin: 5px ;border-radius: 15px;color:white;padding: 10px" :class="{active_plan:this.ch_active===6,deactive_plan:this.ch_active!==6}">
            <div class="row">
              <vue-feather v-if="this.ch_active===6" type="check-circle" size="22" style="margin: 1% 0 0 1%"></vue-feather>
              <vue-feather v-else type="circle" size="22" style="margin: 1% 0 0 1%"></vue-feather>
              <p style="margin: 2%;font-size: 16px">اشتراک 6 ماهه</p>
            </div>
            <div class="row justify-end" >
              <p v-if="this.ch_price_off6>0"  style="margin: 5px 0 0 10px;text-decoration: line-through;">{{ this.ch_price_off6 }}</p>
              <p  style="margin: 5px 10px 0 0;font-weight: bold;">{{ this.formatter.format(this.ch_price6) }} تومان</p>
            </div>
          </div>
          <div v-if="this.ch_price12>0" @click="this.selectedSub(12)" class="row justify-space-between" style="margin: 5px ;border-radius: 15px;color:white;padding: 10px" :class="{active_plan:this.ch_active===12,deactive_plan:this.ch_active!==12}">
            <div class="row">
              <vue-feather v-if="this.ch_active===12" type="check-circle" size="22" style="margin: 1% 0 0 1%"></vue-feather>
              <vue-feather v-else type="circle" size="22" style="margin: 1% 0 0 1%"></vue-feather>
              <p style="margin: 2%;font-size: 16px">اشتراک 12 ماهه</p>
            </div>
            <div class="row justify-end" >
              <p v-if="this.ch_price_off12>0"  style="margin: 5px 0 0 10px;text-decoration: line-through;">{{ this.ch_price_off12 }}</p>
              <p  style="margin: 5px 10px 0 0;font-weight: bold;">{{ this.formatter.format(this.ch_price12) }} تومان</p>
            </div>
          </div>
        </div>


        <button @click="this.goToInvoice()"  class="btn-channel" type="button" style="margin: 25px 0 15px 0;text-align: center;">
         ادامه
        </button>
      </div>
    </div>

  </div>




  <Footer :selected_num="4"/>
</template>

<script>

import { library } from '@fortawesome/fontawesome-svg-core'
import Loading from '../components/Loading.vue'
import Header from '../components/Header.vue'
import Footer from '../components/Footer.vue'
import SubHeader from '../components/SubHeader.vue'
import SideMenu from '../components/SideMenu.vue'
import { faCaretDown} from '@fortawesome/free-solid-svg-icons'
import { } from '@fortawesome/free-regular-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import LoadingButton from '../components/LoadingButton.vue'
import { useToast } from "vue-toastification";
import {mapWritableState} from 'pinia';
import {useTempStroe} from '@/stores/tempStore';
import 'gitart-vue-dialog/dist/style.css'
import { GDialog } from 'gitart-vue-dialog'
library.add(faCaretDown)
export default {

  name: "Invoice",
  computed: {
    ...mapWritableState(useTempStroe, ["selected_num"])
  },
  components: {
    Loading,SideMenu,Header,SubHeader,Footer,FontAwesomeIcon,LoadingButton,GDialog
  },
  mounted() {
    this.selected_num=4
    this.getRow();
    window.scrollTo(0,0);
  },
  methods:{
    goToInvoice(){
      localStorage.setItem('typeGl', 'buychannel');
      if(localStorage.getItem('tk')==="" || localStorage.getItem('tk')===null){
        this.loginDialog=true;
        return;
      }
      localStorage.setItem('RefGl', this.ch_id.toString());
      localStorage.setItem('channelMounth', this.ch_active.toString());
      localStorage.setItem('CourseRef', '0');
      localStorage.setItem('CourseRefGl', '0');
      localStorage.setItem('CounselingRefGl', '0');
      this.$router.push({ path: '/invoice'})
    },
    toChannel(channel){
      if(channel.has_channel===1){
        this.$router.push({ path: '/channelpost/'+channel.ID})
      }
      else{
        this.ch_name=channel.Name
        this.ch_price=channel.price
        this.ch_price_off=channel.price_off

        this.ch_price1=channel.price1
        this.ch_price_off1=channel.price_off1

        this.ch_price3=channel.price3
        this.ch_price_off3=channel.price_off3

        this.ch_price6=channel.price6
        this.ch_price_off6=channel.price_off6

        this.ch_price12=channel.price12
        this.ch_price_off12=channel.price_off12
        this.ch_active=channel.ch_active
        this.ch_pay_price=channel.ch_pay_price

        this.ch_access_type=channel.access_type
        this.ch_id=channel.ID

        if(this.ch_price1>0){
          this.ch_active=1
        }
        else if(this.ch_price3>0){
          this.ch_active=3
        }
        else if(this.ch_price6>0){
          this.ch_active=6
        }
        else if(this.ch_price3>12){
          this.ch_active=12
        }

        this.open()
      }

    },
    selectedSub(ch_active){
        this.ch_active=ch_active
        if(this.ch_active===0){
          this.ch_pay_price=this.ch_price
        }
        if(this.ch_active===1){
          this.ch_pay_price=this.ch_price1
        }
        if(this.ch_active===3){
          this.ch_pay_price=this.ch_price3
        }
        if(this.ch_active===6){
          this.ch_pay_price=this.ch_price6
        }
        if(this.ch_active===12){
          this.ch_pay_price=this.ch_price12
        }

    },


    close(){
      var modal = document.getElementById("myCahnnelModal");
      modal.style.display = "none";
    },

    open(){
      var modal = document.getElementById("myCahnnelModal");
      modal.style.display = "block";
    },

    homeOpenMenu(){
      this.openMenu=true;
      console.log("homeOpenMenu");
    },
    headerCloseMenu(){
      this.openMenu=false;
      console.log("homeCloseMenu");
    },
    getRow(){
      this.geted=1;
      const mydata = {
        action:'channels',
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
              this.data=response.data.data;
              this.geted=2;
              if(this.$route.query.ref!==undefined){
                const result = this.data.find(item => item.ID === parseInt(this.$route.query.ref));
                this.$router.push({
                  path: this.$route.path, // مسیر اصلی
                  query: {} // حذف تمام کوئری‌ها
                });
                setTimeout(() => {
                  this.toChannel(result)
                }, 300);
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
            if (error.code === 'ECONNABORTED') {
              this.errTitle = this.$t('General.receivingError');
              this.errMsg = this.$t('General.tryAgain');
              // timed out
            } else {
              this.errTitle = this.$t('General.error');
              this.errMsg = error.message;
            }

          });

    },
  },
  data(){
    return{
      loginDialog:false,
      geted:0,
      openMenu:false,
      formatter : new Intl.NumberFormat('en', {
        maximumFractionDigits:0,
      }),
      data:[],
      ch_id:0,
      ch_name:"",
      ch_pay_price:0,
      ch_price:0,
      ch_price_off:0,
      ch_price1:0,
      ch_price_off1:0,
      ch_price3:0,
      ch_price_off3:0,
      ch_price6:0,
      ch_price_off6:0,
      ch_price12:0,
      ch_price_off12:0,
      ch_active:0,
      ch_access_type:0,
    }
  }
};

</script>
<style>
.img-contact{
  width: 60px;
  object-fit: contain;
}
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
.imagediv{
  justify-content: center;
  align-items: center;
  display: flex;
}



.btn-channel{
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
.active_plan{
  background-color: var(--va-basecolor);
}
.deactive_plan{
  background-color: #b4b4b4;
}
</style>
