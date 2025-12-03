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
  <div class="center" style="width: 100%;" >
    <div class="row"  style="margin: 4% 4% 1% 4%">
<!--      <p style="font-size: 13px;width: 50%;padding: 3% 2% 3% 0;font-weight: bold">کیف پول</p>-->
<!--      <p style="font-size: 13px;width: 50%;padding: 3% 3% 3% 2%">-->
<!--        <font-awesome-icon icon="fa-solid fa-caret-down" style="font-size: 0.75rem;padding-left: 4px"/>-->
<!--      </p>-->

      <p style="font-size: 13px;width: 49%;padding: 3% 2% 3% 3%">{{$t('Wallet.wallet')}}</p>
      <p style="font-size: 13px;width: 49%;padding: 3% 3% 3% 2%" :class="{rtl_lang:$t('config.dir')==='ltr',ltr_lang:$t('config.dir')==='rtl'}">
        <font-awesome-icon icon="fa-solid fa-caret-down" style="font-size: 0.75rem;padding-left: 4px"/>
      </p>
    </div>
   </div>
  <div class="mycard" style="border-radius: 15px;height: 190px;width:92%;margin: 3% 3% 3% 3%;cursor: pointer;background: linear-gradient(90deg, var(--va-basecolor) 0%, var(--va-seccolor) 35%)">
    <div class="row">
      <div style="width: 45%">
        <p style="padding: 15px 15px 0 24px;color:white">{{$t('Wallet.credit')}}:</p>
        <p style="padding: 10px 15px 0 15px;color:white">{{ this.credit }}</p>
        <img style="width: 55px;margin: 20px 15px 0 18px" src="../assets/images/barcod.png">
      </div>
      <div style="width: 55%">
        <div style="text-align: center;width: 100%;height: 55px">
<!--          <img style="max-height: 30px; margin: 15px 15px 0 0" src="../assets/images/logowhite.png">-->
        </div>
        <div style="text-align: center;width: 100%">
          <img style="width: 120px;margin: 10px 15px 0 0" src="../assets/images/barcode.png">
        </div>
        <div style="text-align: center;width: 100%">
          <p style="padding: 15px 15px 0 0;color:white">{{this.walleturl}}</p>
        </div>
      </div>
    </div>
  </div>

  <div class="row" style="margin: 6% 2% 0 2%">
      <div @click="this.changeType('costs')" style="width: 48%;margin-right: 2%;padding-bottom: 5px">
        <div class="mycard" style="height: 120px;width:95%;margin: 0 0 0 5%;cursor: pointer;;border-radius: 15px">
          <div style="width: 100%;text-align: center">
            <img style="width: 40px;margin: 20px 0 0 0" src="../assets/images/wallethistory.png">
          </div>
          <div style="width: 100%;text-align: center">
            <p style="padding: 10px 0 0 0;">{{$t('Wallet.transactions')}}</p>
          </div>
        </div>
      </div>
      <div @click="this.changeType('addcredit')" style="width: 48%;margin-left: 2%;padding-bottom: 5px">
        <div class="mycard" style="height: 120px;width:94%;margin: 0 4% 0 2%;cursor: pointer;border-radius: 15px">
          <div style="width: 100%;text-align: center">
            <img style="width: 55px;margin: 18px 0 0 0" src="../assets/images/walletinc.png">
          </div>
          <div style="width: 100%;text-align: center">
            <p style="padding: 10px 0 0 0;">{{$t('Wallet.addCredit')}}</p>
          </div>

        </div>
      </div>
    </div>
  <div  class="row" style="margin: 1% 2% 0 2%">
    <div @click="this.changeType('gift')" style="width: 48%;margin-right: 2%;margin-top: 2%;padding-bottom: 15px">
      <div class="mycard" style="height: 120px;width:95%;margin: 0 0 0 5%;cursor: pointer;border-radius: 15px;">
        <div style="width: 100%;text-align: center">
          <img style="width: 45px;margin: 20px 0 0 0" src="../assets/images/walletgift.png">
        </div>
        <div style="width: 100%;text-align: center">
          <p style="padding: 10px 0 0 0;">{{$t('Wallet.gift')}}</p>
        </div>
      </div>
    </div>
    <div @click="this.goToPage('/subscription')" style="width: 48%;margin-left: 2%;margin-top: 2%;padding-bottom: 15px">
      <div class="mycard" style="height: 120px;width:94%;margin: 0 4% 0 2%;cursor: pointer;border-radius: 15px;">
        <div style="width: 100%;text-align: center">
          <img style="width: 36px;margin: 18px 0 0 0" src="../assets/images/walletgood.png">
        </div>
        <div style="width: 100%;text-align: center">
          <p style="padding: 10px 0 0 0;">{{$t('Wallet.subscription')}}</p>
        </div>
      </div>
    </div>
  </div>
  <Loading v-if="this.geted===1"/>

  <div v-if="this.type==='addcredit'" class="mycard" style="width:92%;margin: 6% 4% 6% 2%;padding:15px 10px 10px 10px ;cursor: pointer;border-radius: 15px;">
    <p style="margin:0 5px 5% 5px">{{$t('Wallet.enterAmount')}}</p>
    <input type="number" :placeholder="this.$t('Wallet.amount')" v-model="this.price" class="price">
    <div class="row" style="border:1px solid #c7c7c7;height: 45px;border-radius: 15px;margin-top: 5%">
      <div @click="this.price=this.p1" style="width: 25%;text-align: center;padding-top: 14px">{{ this.fixNumbers(this.p1) }}</div>
      <div @click="this.price=this.p2" style="width: 25%;border-left: 1px #c7c7c7 solid;border-right: 1px #c7c7c7 solid;text-align: center;padding-top: 14px">{{ this.fixNumbers(this.p2) }}</div>
      <div @click="this.price=this.p3" style="width: 25%;border-left: 1px #c7c7c7 solid;border-right: 1px #c7c7c7 solid;text-align: center;padding-top: 14px">{{ this.fixNumbers(this.p3) }}</div>
      <div @click="this.price=this.p4" style="width: 25%;text-align: center;padding-top: 14px">{{ this.fixNumbers(this.p4) }}</div>
    </div>
    <button v-if="this.getedPay===1" class="buybtnWٌ" type="button" style="margin:5% 0 3% 0;text-align: center;">
      <div style="width: 100%;text-align: center">
        <va-progress-circle style="margin: 0 45% 0 45%" size="2.5rem" indeterminate color="white" thickness="0.25" />
      </div>
    </button>
    <button v-else @click="this.doAction()" class="buybtn" type="button" style="margin: 7% 0 3% 0;text-align: center;width: 100%">
      {{$t('Wallet.payment')}}
    </button>
  </div>
  <div v-for="cost in costs" :key="cost.ID" v-if="this.type==='costs'" class="mycard" style="width:92%;margin: 6% 4% 6% 2%;padding:15px 10px 10px 10px ;cursor: pointer;border-radius: 15px;">
    <div v-if="cost.Name==='NORECORD'">
      <div style="width: 100%;text-align: center">
        <img style="height: 150px" src="../assets/notfound.png">
      </div>
      <p class="default" style="width: 100%;text-align: center;padding-bottom: 10%">{{$t('Wallet.noTransactions')}}</p>
    </div>
    <div v-else>
      <div class="row">
        <div style="width: 50%">{{cost.Name}}</div>
        <div style="width:40%;text-align: left">{{cost.Price}}</div>
        <div style="width: 10%;text-align: left">
          <font-awesome-icon v-if="cost.Type==='+'" icon="fa-solid fa-caret-up" style="font-size: 0.75rem;padding-left: 4px;color: green"/>
          <font-awesome-icon v-else icon="fa-solid fa-caret-down" style="font-size: 0.75rem;padding-left: 4px;color: red"/>
        </div>
      </div>
      <div class="row" style="margin-top: 8%">
        <div style="width: 30%">{{$t('Wallet.date')}}:</div>
        <div style="width:70%;text-align: left;padding-left: 1%">{{ cost.Date }}</div>
      </div>
    </div>
  </div>
  <div v-if="this.type==='gift' && this.geted===2" class="mycard" style="width:92%;margin: 6% 4% 8% 2%;padding:6% 10px 6% 10px ;cursor: pointer;border-radius: 15px;">
    <p style="margin-bottom: 7%">{{$t('Wallet.friendHelp')}}</p>
    <p style="margin-bottom: 2%;font-weight: bold">{{$t('Wallet.choosing')}}</p>
    <div style="width: 100% !important;height: 45px !important;">
      <Select2 dir="rtl" dropdownCssClass="msel" v-model="this.course_ref" :options="this.course_list" :settings="{ settingOption: value, settingOption: value }"  @change="myChangeEvent($event)" @select="mySelectEvent($event)"/>
    </div>
    <p style="margin: 8% 0 2% 0;font-weight: bold">{{$t('Wallet.friendNumber')}}</p>
    <input type="tel" :placeholder="this.$t('Wallet.phoneNumber')" v-model="this.mobile" class="price">
    <button @click="this.goToInvoice('gift')" class="buybtn" type="button" style="margin: 8% 0 3% 0;text-align: center;">
      {{$t('Wallet.continuation')}}
    </button>
  </div>

  <Footer :selected_num="3"/>
</template>

<script>
import { library } from '@fortawesome/fontawesome-svg-core'
import Loading from '../components/Loading.vue'
import LoadingButton from '../components/LoadingButton.vue'
import Header from '../components/Header.vue'
import Footer from '../components/Footer.vue'
import SubHeader from '../components/SubHeader.vue'
import SideMenu from '../components/SideMenu.vue'
import { faCaretDown,faCaretUp} from '@fortawesome/free-solid-svg-icons'
import { } from '@fortawesome/free-regular-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { useToast } from "vue-toastification";
import Select2 from 'vue3-select2-component';
import 'gitart-vue-dialog/dist/style.css'
import { GDialog } from 'gitart-vue-dialog'
library.add(faCaretDown,faCaretUp)
export default {
  name: "Invoice",
  components: {
    Loading,SideMenu,Header,SubHeader,Footer,FontAwesomeIcon,Select2,LoadingButton,GDialog
  },
  updated() {
    if(this.type!==''){
      window.scrollTo({
        top: 350,
        left: 0,
        behavior: 'smooth'
      });
    }
  },
  mounted() {
    // this.getRow();
    window.scrollTo(0,0);
    this.credit=localStorage.getItem('credit');
    this.price=this.$i18n.locale==='fa'?50000:5
    this.p1=this.$i18n.locale==='fa'?50000:5
    this.p2=this.$i18n.locale==='fa'?100000:10
    this.p3=this.$i18n.locale==='fa'?20000:20
    this.p4=this.$i18n.locale==='fa'?500000:50
  },
  methods:{
    goToPage(page){
      this.$router.push({ path: page });
    },
    homeOpenMenu(){
      this.openMenu=true;
    },
    headerCloseMenu(){
      this.openMenu=false;
    },
    changeType(ctype){
      this.type=ctype;
      window.scrollTo({
        top: 100,
        left: 0,
        behavior: 'smooth'
      });
      if(this.costs===null && ctype!=='addcredit'){
        this.getRow();
      }

    },
    myChangeEvent(val){
      console.log(val);
    },
    mySelectEvent({id, text}){
      this.course_ref=id;
    },
    goToInvoice(type){
      if(type==='credit'){
        this.price=this.fixNumbers(this.price);
        // get paylink

      }
      else if(type==='gift'){
        this.mobile=this.fixNumbers(this.mobile);
        if(this.mobile.length<11){
          useToast().warning("شماره موبایل(11 رقمی) یا ایمیل را به صورت صحیح رقمی وارد کنید", {
            timeout: 2000,
            position:'top-center',
            rtl: this.$t('config.dir')==='rtl'?true:false
          });
        }
        else if(this.course_ref===0){
          useToast().warning("دوره انتخاب نشده است", {
            timeout: 2000,
            position:'top-center',
            rtl: this.$t('config.dir')==='rtl'?true:false
          });
        }
        else{
          localStorage.setItem('typeGl', 'GiftCourse');
          localStorage.setItem('subRefGl', '0');
          localStorage.setItem('CourseRef', '0');
          localStorage.setItem('MobileGiftGl', this.mobile.toString());
          localStorage.setItem('CourseRefGl', this.course_ref.toString());
          this.$router.push({ path: '/invoice'})
        }

      }


    },
    myToast(alert){

      useToast().warning(alert, {
        timeout: 2000,
        position:'top-center',
        rtl: this.$t('config.dir')==='rtl'?true:false
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
    },
    getRow(){
      this.geted=1;
      const mydata = {
        action:'walletHistory',
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
            console.log(response.data);
            if(response.data.ok===1){

              if(response.data.courses!==null){

                response.data.courses.forEach(object => {
                  console.log(object.Name)
                  this.course_list.push({id: object.ID, text: object.Name})
                });
              }
              this.costs=response.data.costs;
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
    doAction(){
      if(localStorage.getItem('tk')==="" || localStorage.getItem('tk')===null){
        this.loginDialog=true;
        return
      }
      this.getedPay=1;
      const mydata = {
        action:'getPayLink',
        discountCode:this.code,
        useWallet:0,
        type:'ChargeWallet',
        price:this.price.toString(),
        subRef:'0',
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
              window.open(response.data.url,"_self");
              this.getedPay=2;
            }
            else if(response.data.ok===3){
              localStorage.setItem('tk', "");
              this.$router.push({ path: '/mobile' })
            }
            else{
              if(response.data.ok===4){
                localStorage.setItem('tk', "");
              }
              this.getedPay=3;
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
            this.getedPay = 3;
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
      getedPay:0,
      price:50000,
      p1:50000,
      p2:100000,
      p3:200000,
      p4:500000,
      openMenu:false,
      formatter : new Intl.NumberFormat('en', {
        maximumFractionDigits:0,
      }),
     credit:"0 تومان",
      type:"",
      course_list:[{id: 0, text: "انتخاب کنید..."}],
      costs:null,
      course_ref:0,
      mobile:"",
    }
  }
};

</script>
<style>
.select2 {
  width:100%!important;
  border-radius: 15px !important;
  direction: rtl !important;
  margin: unset;
}
.buybtnWٌ{
  width: 100%;
  text-align: center;

  height: 45px;
  background-color: var(--va-greencolor);
  color:white;
  border-radius: 10px;
  border:unset;
  cursor: pointer;
}
.price{
  width: 100%;height: 50px;
  text-align: left;
  outline: none !important;
  border:1px solid #8a8a8a;
  border-radius: 15px;
  padding-left: 10px;
}
.select2-container--default .select2-selection--single {
  background-color: #fff;
  border: 1px solid #aaa;
  border-radius: 15px;
  padding: 8px;
  height: 50px;


}

.select2-container--default[dir="rtl"] .select2-selection--single .select2-selection__arrow {
  left: 20px;
  right: auto;
  top: 12px;
  padding-top: 3px;

}
.select2-container{
  width: 100% !important;
}
</style>
