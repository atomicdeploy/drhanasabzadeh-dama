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
  <div v-if="this.geted===2" class="center" style="width: 100%;" >
      <div class="row" style="text-align: center;">
        <p style="width: 100%;text-align: center">
          <img style="height: 170px;padding-top:5px;" src="../assets/images/invoice.png">
        </p>

      </div>
    <div class="row" style="margin: 0 3% 0 3%">
      <p style="margin: 4% 2% 4% 2%;text-align:center;line-height: 1.7;color:var(--va-basecolor);font-weight: bold">{{this.typename+" "+this.name}}</p>
    </div>
    <div v-if="this.type==='counseling'" class="mycard" style="width:94%;margin: 6% 4% 6% 2%;padding:15px 10px 10px 10px ;cursor: pointer;border-radius: 15px;">
      <p  style="margin-bottom: 2%">{{$t('Invoice.consultations')}}:</p>
      <input type="tel" :placeholder="this.$t('Invoice.mobile')" v-model="this.coun_user_mobile" class="price">
      <p  v-if="this.counseling_comment!==''" style="margin: 5% 0 2% 0">{{this.counseling_comment}}</p>
      <textarea v-if="this.counseling_comment!==''" type="tel" v-model="this.coun_user_desc" class="desc"></textarea>
    </div>
    <div v-if="this.p13==='1'">
      <div class="row" style="margin: 7% 3% 2% 2%">
        <vue-feather class="default" type="tag" size="22" style="margin: 0 2% 0 2%"></vue-feather>
        <p class="default" style="width: 63%;margin-top: 1.5%;font-size: 14px">{{$t('Invoice.discount')}} </p>
        <div class="mycard" @click="this.openDiscount()" style="width: 25%;
                  border: 1px solid var(--va-seccolor);
                  border-radius: 10px;
                  font-size: 14px;
                  background-color: white;
                  padding: 6px;
                  text-align: center; color: var(--va-basecolor)">{{$t('Invoice.enterCode')}}</div>
      </div>
      <div v-if="getedDiscount===2" class="row" style="margin: 2% 3% 7% 2%">
        <p class="default" style="color:var(--va-greencolor)">{{this.msgDiscount}}</p>
      </div>
      <div v-if="getedDiscount===1" class="row" style="margin: 2% 3% 7% 2%">
        <va-progress-circle size="35px" indeterminate color="var(--va-basecolor)" thickness="0.17" />
      </div>
    </div>

    <div v-if="this.credit>0" class="row" style="margin: 6% 5% 2% 3%">
      <font-awesome-icon icon="fa-solid fa-wallet" style="margin: 0 2% 0 2%;font-size: 1.32rem"/>
      <p style="width:74%;font-size:13px;margin: 1% 1% 0 0">{{$t('Invoice.useCredit',{credit: this.credit})}} </p>
      <!-- Rounded switch -->
      <label class="switch">
        <input type="checkbox" v-model="this.useWallet">
        <span class="slider round"></span>
      </label>
    </div>


    <div >
      <div v-if="this.pay===1" class="row" style="padding:10px 10px 0 10px;cursor: pointer">
        <div @click="this.change_pay(1)" class="card mycard" style="width: 47%;height: 160px;margin-left: 4%;text-align: center">
          <font-awesome-icon icon="fa-regular fa-credit-card" size="large" :style="{color:'#34cc73',fontSize:'42px',marginTop:'10px',marginBottom:'10px'}"/>
          <p style="color: #787878;margin-top: 10px"><b>{{$t('Invoice.bankCard')}}</b></p>
          <font-awesome-icon icon="fa-solid fa-circle-check"  :style="{color:'#34cc73',fontSize:'28px',marginTop:'20px',marginBottom:'10px'}"/>
        </div>
        <div @click="this.change_pay(2)" class="card mycard" style="width: 47%;height: 160px;text-align: center">
          <font-awesome-icon icon="fa-solid fa-money-check-dollar"  :style="{color:'#a0a0a0',fontSize:'42px',marginTop:'10px',marginBottom:'10px'}"/>
          <p style="color: #787878">{{$t('Invoice.cardToCard')}}</p>
          <font-awesome-icon icon="fa-regular fa-circle"  :style="{color:'#a0a0a0',fontSize:'28px',marginTop:'20px',marginBottom:'10px'}"/>
        </div>
      </div>
      <div v-else-if="this.pay===2" class="row" style="padding: 10px 10px 0 10px;cursor: pointer">
        <div @click="this.change_pay(1)" class="card mycard" style="width: 47%;height: 160px;margin-left: 4%;text-align: center">
          <font-awesome-icon icon="fa-regular fa-credit-card" size="large" :style="{color:'#a0a0a0',fontSize:'42px',marginTop:'10px',marginBottom:'10px'}"/>
          <p style="color: #787878;margin-top: 10px">{{$t('Invoice.bankCard')}}</p>
          <font-awesome-icon icon="fa-regular fa-circle"  :style="{color:'#a0a0a0',fontSize:'28px',marginTop:'20px',marginBottom:'10px'}"/>

        </div>
        <div @click="this.change_pay(2)" class="card mycard" style="width: 47%;height: 160px;text-align: center">
          <font-awesome-icon icon="fa-solid fa-money-check-dollar"  :style="{color:'#34cc73',fontSize:'42px',marginTop:'10px',marginBottom:'10px'}"/>
          <p style="color: #787878"><b>{{$t('Invoice.cardToCard')}}</b></p>
          <font-awesome-icon icon="fa-solid fa-circle-check"  :style="{color:'#34cc73',fontSize:'28px',marginTop:'20px',marginBottom:'10px'}"/>
        </div>
      </div>
      <div v-if="(this.pay===1 || this.pay===2) && this.get_type!==5" class="row" style="margin: 0 4% 15px 3%">
        <vue-feather class="default" type="credit-card" size="22" style="margin: 1% 0 0 1%"></vue-feather>
        <p class="default" style="margin: 2%;font-size: 16px">{{$t('Invoice.payable')}}: </p>
        <p class="default" v-if="this.useWallet && (this.price-this.credit)>0" style="margin: 2%;font-weight: bold;color: var(--va-greencolor)">{{ this.formatter.format(this.price-this.credit) }} {{$t('Invoice.currency')}}</p>
        <p class="default" v-else-if="this.useWallet" style="margin: 2%;font-weight: bold;color: var(--va-greencolor)">0 {{$t('Invoice.currency')}}</p>
        <p class="default" v-else style="margin: 2%;font-weight: bold;color: var(--va-greencolor)">{{ this.formatter.format(this.price) }} {{$t('Invoice.currency')}}</p>
      </div>
      <div v-if="this.pay===2" class="mycard" style="margin: 0 15px 25px 15px;padding:15px 10px 10px 10px ;cursor: pointer;border-radius: 15px;">
        <p v-if="this.card1_number!=='' && this.card2_number!==''" style="margin-bottom: 2%;color: #636363;font-size: 12px">{{$t('Invoice.cardMultiText')}}:</p>
        <p v-else style="margin-bottom: 2%;color: #636363;font-size: 12px">{{$t('Invoice.cardOneText')}}:</p>
        <div v-if="this.card1_number!==''" class="mycard" style="color:white;border-radius: 15px;height: 130px;width:94%;margin: 10px 3% 15px 3%;cursor: pointer;background: linear-gradient(90deg, var(--va-basecolor) 0%, var(--va-seccolor) 35%)">
          <div class="row justify-center" style="padding-top: 30px">
           <p style="font-weight: bold;font-size: 18px;direction: ltr">{{ this.card1_number }}</p>
           <div @click="this.copy(this.card1_number)" style="margin: 0px 5px;border-radius: 5px; padding: 2px 5px 2px 5px; background: #7e817e;color: white;position: relative; bottom: 4px;">
             <font-awesome-icon icon="fa-solid fa-copy" style="margin: 0 2px 0 2px;font-size: 14px"/>
             کپی
           </div>
          </div>
          <div class="row justify--space-between" style="padding-top: 30px">
            <p class="col-7" style="padding: 0 20px 0 20px">به نام: {{ this.card1_name }}</p>
            <p class="col-5" style="padding: 0 20px 0 20px">بانک: {{ this.card1_bank }}</p>
          </div>
        </div>
        <div v-if="this.card2_number!==''" class="mycard" style="color:white;border-radius: 15px;height: 130px;width:94%;margin: 10px 3% 10px 3%;cursor: pointer;background: linear-gradient(90deg, var(--va-basecolor) 0%, var(--va-seccolor) 35%)">
          <div class="row justify-center" style="padding-top: 30px">
            <p style="font-weight: bold;font-size: 18px;direction: ltr">{{ this.card2_number }}</p>
            <div @click="this.copy(this.card2_number)" style="margin: 0px 5px;border-radius: 5px; padding: 2px 5px 2px 5px; background: #7e817e;color: white;position: relative; bottom: 4px;">
              <font-awesome-icon icon="fa-solid fa-copy" style="margin: 0 2px 0 2px;font-size: 14px"/>
              کپی
            </div>
          </div>
          <div class="row justify--space-between" style="padding-top: 30px">
            <p class="col-7" style="padding: 0 20px 0 20px">به نام: {{ this.card2_name }}</p>
            <p class="col-5" style="padding: 0 20px 0 20px">بانک: {{ this.card2_bank }}</p>
          </div>
        </div>
        <div style="margin: 25px 3% 15px 3%">
          <p>پس از پرداخت به شماره کارت بالا، با انتخاب کادر زیر، تصویر فیش را انتخاب کنید</p>
        </div>

        <div class="center">
          <div class="row"  style="margin: 15px 3% 15px 3%;background: rgb(247 247 247);border-radius: 15px;height: 180px;border: 1px black dashed;">
              <label for="file-upload"  class="custom-file-upload" style="width: 100%;text-align: center; border-radius: 25px;cursor: pointer; height: 178px;">
                <img v-if="this.url!==''" :src="url" style="height: 100%;text-align: center"/>
                <p  v-else style="margin-top: 70px">تصویر فیش واریزی را انتخاب کنید</p>
              </label>
          </div>
          <input id="file-upload" type="file" accept="image/*" @change="onFileChange"/>
        </div>
        <div style="margin: 15px 3% 15px 3%">
          <p style="font-size: 13px;color: #616161">در صورت تمایل می توانید به جای ارسال عکس فیش، اطلاعات فیش واریزی را برای ما ارسال کنید</p>
        </div>
        <div @click="this.showAnother()" style="margin-bottom: 15px;">
          <span style="background: rgb(188 173 238); padding: 5px 12px 5px 12px;margin: 0 3% 15px 3%;border-radius: 8px;color: #616161">ارسال اطلاعات فیش</span>
        </div>
        <div v-if="this.showAnotherField" style="margin-bottom: 10px">
          <div  style="margin: 0 15px 0 15px;padding:15px 0 0 0 ;cursor: pointer;border-radius: 15px;">
            <p  style="margin-bottom: 2%;color: #636363">شماره پیگیری فیش واریزی:</p>
            <input type="text" v-model="this.card_tracking" class="price" style="text-align: center">
          </div>
           <div  style="margin: 0 15px 0 15px;padding:15px 0 0 0 ;cursor: pointer;border-radius: 15px;">
            <p  style="margin-bottom: 2%;color: #636363">مبلغ واریزی (تومان):</p>
            <input type="text" v-model="this.card_price" class="price" style="text-align: center">
          </div>
          <div  style="margin: 0 15px 0 15px;padding:15px 0 0 0 ;cursor: pointer;border-radius: 15px;">
            <p  style="margin-bottom: 2%;color: #636363">تاریخ و ساعت:</p>
            <input type="text" v-model="this.card_date" class="price" style="text-align: center">
          </div>
          <div  style="margin: 0 15px 0 15px;padding:15px 0 0 0 ;cursor: pointer;border-radius: 15px;">
            <p  style="margin-bottom: 2%;color: #636363">توضیحات (اختیاری):</p>
            <input type="text" v-model="this.card_comment" class="price" style="text-align: center">
          </div>
        </div>
        <div>

        </div>

      </div>
      <div v-if="this.pay===3" class="mycard" style="margin: 0 15px 25px 15px;padding:15px 10px 10px 10px ;cursor: pointer;border-radius: 15px;">
        <p  style="margin-bottom: 2%;color: #636363">{{$t('Invoice.enterEmail')}}:</p>
        <input type="email" placeholder="email" v-model="this.email" class="price">
      </div>


<!--      <div v-if="this.pay===1" class="row" style="text-align: right;margin: 3% 3% 0 3%">-->
<!--        <vue-feather type="credit-card" size="22" style="margin: 1% 0 0 1%"></vue-feather>-->
<!--        <p style="margin: 2%;font-size: 14px">مبلغ قابل پرداخت: </p>-->
<!--        <p v-if="this.get_type===5" style="margin: 2%;font-weight: bold;color: var(&#45;&#45;va-greencolor)">مبلغ دلخواه</p>-->
<!--        <p v-else-if="this.useWallet && (this.price-this.credit)>0" style="margin: 2%;font-weight: bold;color: var(&#45;&#45;va-greencolor)">{{ this.formatter.format(this.price-this.credit) }} تومان</p>-->
<!--        <p v-else-if="this.useWallet" style="margin: 2%;font-weight: bold;color: var(&#45;&#45;va-greencolor)">0 تومان</p>-->
<!--        <p v-else style="margin: 2%;font-weight: bold;color: var(&#45;&#45;va-greencolor)">{{ this.formatter.format(this.price) }} تومان</p>-->
<!--      </div>-->
<!--      <div v-else-if="this.pay===2" class="row" style="text-align: right;margin: 3% 3% 0 3%">-->
<!--        <vue-feather type="credit-card" size="22" style="margin: 1% 0 0 1%"></vue-feather>-->
<!--        <p style="margin: 2%;font-size: 14px">مبلغ قابل پرداخت: </p>-->
<!--        <p v-if="this.get_type===5" style="margin: 2%;font-weight: bold;color: var(&#45;&#45;va-greencolor)">مبلغ دلخواه</p>-->
<!--        <p v-else-if="this.useWallet && (this.price-this.credit)>0" style="margin: 2%;font-weight: bold;color: var(&#45;&#45;va-greencolor)">{{ ((this.price-this.credit)/this.dollar_price).toFixed(2)  }} تتر</p>-->
<!--        <p v-else-if="this.useWallet" style="margin: 2%;font-weight: bold;color: var(&#45;&#45;va-greencolor)">0 تتر</p>-->
<!--        <p v-else style="margin: 2%;font-weight: bold;color: var(&#45;&#45;va-greencolor)">{{ (this.price/this.dollar_price).toFixed(2) }} تتر (USDT)</p>-->
<!--      </div>-->
      <div v-if="this.get_type===5" class="mycard" style="width:92%;margin: 6% 4% 6% 2%;padding:15px 10px 10px 10px ;cursor: pointer;border-radius: 15px;">
        <p class="default" style="margin-bottom: 2%">مبلغ دلخواه خود را به تومان وارد کنید:</p>
        <input type="tel" placeholder="مثال: 500000" v-model="this.desired_price" class="price">
      </div>

    </div>

     <div v-if="this.crypto==='1'" class="row" style="margin: 3% 3% 0 3%">
      <vue-feather type="credit-card" size="22" style="margin: 1% 0 0 1%"></vue-feather>
      <p class="default" style="margin: 2%;font-size: 14px">{{$t('Invoice.payable')}}: </p>
      <p class="default" v-if="this.useWallet && (this.price-this.credit)>0" style="margin: 2%;font-weight: bold;color: var(--va-greencolor)">{{ ((this.price-this.credit)/this.dollar_price).toFixed(2)  }} {{$t('Invoice.tether')}}</p>
      <p class="default" v-else-if="this.useWallet" style="margin: 2%;font-weight: bold;color: var(--va-greencolor)">0 {{$t('Invoice.tether')}}</p>
      <p class="default" v-else style="margin: 2%;font-weight: bold;color: var(--va-greencolor)">{{ (this.price/this.dollar_price).toFixed(2) }} {{$t('Invoice.tether')}} (USDT)</p>
    </div>
    <div class="row" style="margin: 40px 3% 15px 3%">
      <input id="terms" v-model="this.terms" type="checkbox" style="width: 20px;height: 20px"/>
      <label class="default" for="terms" style="position:relative;top:2px;cursor: pointer;margin: 0 10px 0 10px">{{$t('Invoice.acceptRules')}}</label>
      <router-link to="/terms">
        <label style="position:relative;top:2px;cursor: pointer;color: dodgerblue">({{$t('Invoice.viewRules')}})</label>
      </router-link>
    </div>
    <button v-if="this.card==='0' && this.online==='0'" @click="this.myToast(this.$t('Invoice.checkHours'))"   class="terms" type="button" style="margin: 20px 4% 10% 4%;text-align: center; ">
      {{$t('Invoice.paymentDisabled')}}
    </button>
    <button v-else-if="this.terms===false" @click="this.myToast(this.$t('Invoice.rulesFirst'))"  class="terms" type="button" style="margin: 20px 4% 10% 4%;text-align: center; ">
      <span v-if="this.pay===2">{{$t('Invoice.sendData')}}</span>
      <span v-else>{{$t('Invoice.payment')}}</span>
    </button>
    <button v-else-if="this.getedPay===1" class="buybtn" type="button" style="margin: 20px 4% 10% 4%;text-align: center; ">
      <p style="width: 100%;text-align: center">
        <LoadingButton />
      </p>
    </button>

    <button  v-else-if="this.pay===2" @click="this.doAction()" class="buybtn" type="button" style="margin: 20px 4% 10% 4%;text-align: center; ">
      {{$t('Invoice.sendData')}}
    </button>
    <button  v-else @click="this.doAction()" class="buybtn" type="button" style="margin: 20px 4% 10% 4%;text-align: center; ">
      {{$t('Invoice.payment')}}
    </button>
    <div v-if="this.enamad!==''" v-html="this.enamad" style="text-align: center"></div>

   </div>

  <Footer :selected_num="3" />
</template>

<script>
import { library } from '@fortawesome/fontawesome-svg-core'
import Loading from '../components/Loading.vue'
import Header from '../components/Header.vue'
import Footer from '../components/Footer.vue'
import SubHeader from '../components/SubHeader.vue'
import SideMenu from '../components/SideMenu.vue'
import { faWallet,faMoneyCheckDollar,faCircleCheck,faCopy} from '@fortawesome/free-solid-svg-icons'


import {faCreditCard,faCircle } from '@fortawesome/free-regular-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import LoadingButton from '../components/LoadingButton.vue'
import { useToast } from "vue-toastification";
import 'gitart-vue-dialog/dist/style.css'
import { GDialog } from 'gitart-vue-dialog'
library.add(faWallet,faCreditCard,faMoneyCheckDollar,faCircle,faCircleCheck,faCopy)
export default {
  name: "Invoice",
  components: {
    Loading,SideMenu,Header,SubHeader,Footer,FontAwesomeIcon,LoadingButton,GDialog
  },
  mounted() {
    this.type=localStorage.getItem('typeGl');
    this.getRow();
    window.scrollTo(0,0);

    var poss_obj = JSON.parse(localStorage.getItem('poss'));
    if(poss_obj!=null){
      this.p13=poss_obj.p13
    }
  },
  methods:{
    showAnother(){
      this.showAnotherField=!this.showAnotherField
    },
    onFileChange(e) {
      const file = e.target.files[0];
      this.url = URL.createObjectURL(file);
    },
    copy(text) {
      if (!navigator.clipboard) {
        fallbackCopyTextToClipboard(text);
        return;
      }
      text=text.replaceAll(" ", "");
      navigator.clipboard.writeText(text).then(function() {
        // console.log('Async: Copying to clipboard was successful!');
        // this.myToast("لینک کپی شد");
        useToast().success("شماره کارت کپی شد", {
          timeout: 2000,
          position:'top-center',
          rtl: true
        });
      }, function(err) {
        // console.error('Async: Could not copy text: ', err);
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
    change_pay(pay){

       if(pay===1 && this.online==='0'){
        this.myToast("پرداخت از طریق درگاه بانک غیرفعال است");
      }
       else if(pay===2 && this.card==='0'){
         this.myToast("پرداخت از طریق کارت به کارت غیرفعال است");
      }
      else{
        this.pay=pay
      }

    },
    getRow(){
      var courseref=0;
      if(this.$route.params.id!==undefined){
        courseref=this.$route.params.id;
        localStorage.setItem('CourseRefGl', courseref.toString());
      }
      else{
        courseref=localStorage.getItem('CourseRefGl')
      }

      this.geted=1;
      const mydata = {
        action:'getPayInfo',
        type:localStorage.getItem('typeGl'),
        ref:localStorage.getItem('RefGl'),
        CourseRef:courseref,
        MeetRef:localStorage.getItem('MeetRefGl')??"",
        subRef:localStorage.getItem('subRefGl'),
        channelMounth:localStorage.getItem('channelMounth'),
        counselingRef:localStorage.getItem('CounselingRefGl'),
        mobile:localStorage.getItem('MobileGiftGl'),
        amount:localStorage.getItem('amount'),
        newInvoice:1,

        lang:this.$i18n.locale,

      };
      if(localStorage.getItem('typeGl')==='BuyLive'){
        mydata.Ref=localStorage.getItem('RefGl');
      }
      if(localStorage.getItem('PayData')!==null){
        mydata.PayData=localStorage.getItem('PayData');
      }

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

              this.name=response.data.name;
              this.price=response.data.price;
              this.credit=response.data.credit;
              this.typename=response.data.typename;
              this.dollar_price=response.data.dollar_price;

              this.online=response.data.online;
              this.card=response.data.card;
              this.crypto=response.data.crypto;
              this.get_type=response.data.get_type
              if(this.card==='1'){
                if(response.data.card1_number!==""){
                  this.card1_number=response.data.card1_number
                  this.card1_name=response.data.card1_name
                  this.card1_bank=response.data.card1_bank
                }
                if(response.data.card2_number!==""){
                  this.card2_number=response.data.card2_number
                  this.card2_name=response.data.card2_name
                  this.card2_bank=response.data.card2_bank
                }
              }
              if(this.card==='1' && this.online==='0'){
                this.pay=2;
              }
              else if(this.card==='0' && this.online==='1'){
                this.pay=1;
              }
              else{
                this.pay=1;
              }

              if(response.data.counseling_comment!==""){
                this.counseling_comment=response.data.counseling_comment;
              }
              if(response.data.enamad!=null){
                this.enamad=response.data.enamad
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
      var courseref=localStorage.getItem('CourseRefGl')
      if(localStorage.getItem('tk')==="" || localStorage.getItem('tk')===null){
        localStorage.setItem('Page', "invoice");
        this.loginDialog=true;
        return
      }
      else if(this.type==='counseling' && this.coun_user_mobile.length<11){
          this.myToast(this.$t('Invoice.mobileErr'));
          return;
      }
      else if(this.pay===3 && this.email.length<5){
          this.myToast(this.$t('Invoice.emailErr'));
          return;
      }


      this.getedPay=1;
      const mydata = {
        action:'getPayLink',
        discountCode:this.code,
        useWallet:this.useWallet?1:0,
        type:this.type,
        CourseRef:courseref,
        MeetRef:localStorage.getItem('MeetRefGl')??"",
        channelMounth:localStorage.getItem('channelMounth'),
        ref:localStorage.getItem('RefGl'),
        subRef:localStorage.getItem('subRefGl'),
        mobile:localStorage.getItem('MobileGiftGl'),
        counselingRef:localStorage.getItem('CounselingRefGl'),
        coun_user_mobile:this.coun_user_mobile,
        coun_user_desc:this.coun_user_desc,
        pay:this.pay,
        email:this.email,
        amount:localStorage.getItem('amount'),
        card_tracking:this.card_tracking,
        card_price:this.card_price,
        card_date:this.card_date,
        card_comment:this.card_comment,
        desired_price:this.desired_price,
        lang:this.$i18n.locale,
      };
      if(localStorage.getItem('PayData')!==null){
        mydata.PayData=localStorage.getItem('PayData');
      }
      if(this.pay===2){
        const file = document.querySelector('#file-upload');
        if(file.files.length!==0){
          mydata.file=file.files[0]
        }
      }
      if(localStorage.getItem('typeGl')==='BuyLive'){
        mydata.Ref=localStorage.getItem('RefGl');
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
              if(response.data.pay==="2"){
                this.$router.push({ path: '/cardtocard'});
              }
              else if(response.data.pay==="3"){
                this.$router.push({ path: '/CryptoInvoice',query:{'address':response.data.url} });
              }
              else{
                window.open(response.data.url,"_self");
              }
              this.getedPay=2;
            }
            else if(response.data.ok===3){
              localStorage.setItem('tk', "");
              this.$router.push({ path: '/mobile' })
            }
            else if(response.data.ok===2){
              this.getedPay=3;
              this.$swal({
                title: this.$t('Invoice.successful'),
                text: response.data.msg,
                icon: 'success',
                confirmButtonText:this.$t('General.ok'),
                customClass: {
                  confirmButton: 'btn btn-primary'
                },
                buttonsStyling: false
              }).then((result) => {
                this.$router.push({ path: '/' });
              });
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
    discount(){
      if(localStorage.getItem('tk')==="" || localStorage.getItem('tk')===null){
        this.loginDialog=true;
        return
      }
      this.getedDiscount=1;
      const mydata = {
        action:'discount',
        code:this.code,
        courseref:localStorage.getItem('CourseRefGl'),
        subref:localStorage.getItem('subRefGl'),
        amount:localStorage.getItem('amount'),
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
              this.msg=response.data.msg;
              this.price=response.data.price;
              this.msgDiscount=response.data.msg;
              this.getedDiscount=2;
            }
            else if(response.data.ok===3){
              localStorage.setItem('tk', "");
              this.$router.push({ path: '/mobile' })
            }
            else{
              if(response.data.ok===4){
                localStorage.setItem('tk', "");
              }
              this.getedDiscount=3;
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
            this.getedDiscount = 3;
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
    myToast(alert){
      useToast().warning(alert, {
        timeout: 2000,
        position:'top-center',
        rtl: this.$t('config.dir')==='rtl'?true:false
      });
    },
    openDiscount(){
      this.$swal({
        title: this.$t('Invoice.discountCodeDesc'),
        inputPlaceholder: this.$t('Invoice.discountCode'),
        input: 'text',
        confirmButtonText:this.$t('Invoice.submit'),
        cancelButtonText:this.$t('Invoice.cancel'),
        showCancelButton:true,
        customClass: {
          confirmButton: 'btn btn-primary'
        },
        buttonsStyling: false
      }).then((result) => {
        if (result.value) { // <-- if confirmed
          this.code=result.value;
          this.discount();
        }
      });
    }
  },

  data(){
    return{
      loginDialog:false,
      geted:0,
      getedPay:0,
      getedDiscount:0,
      msgDiscount:"",
      openMenu:false,
      formatter : new Intl.NumberFormat('en', {
        maximumFractionDigits:0,
      }),
      type:"",
      code:"",
      useWallet:0,
      credit:0,
      counseling_desc:"",
      coun_user_mobile:"",
      coun_user_desc:"",
      counseling_comment:"",
      terms:false,
      pay:1,
      dollar_price:0,
      crypto_address:"",
      email:"",
      online:0,
      card:0,
      crypto:0,
      card1_number:"",
      card1_name:"",
      card1_bank:"",
      card2_number:"",
      card2_name:"",
      card2_bank:"",
      url:"",
      showAnotherField:false,
      card_tracking:"",
      card_price:"",
      card_date:"",
      card_comment:"",
      enamad:"",
      p13:"1",
      get_type:0,
      desired_price:"",
      price:"",
    }
  }
};

</script>
<style>
.swal2-cancel{
  cursor:pointer;
  display: inline-block;
  padding: 10px;
  background: #ececec;
  border-radius: 5px;
  margin-right: 20px;
  margin-left: 20px;
}
.swal2-input{
  direction: ltr;
  text-align: center;
}
.switch {
  position: relative;
  display: inline-block;
  width:54px;
  height: 26px;
}

/* Hide default HTML checkbox */
.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

/* The slider */
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 19px;
  width: 19px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: var(--va-basecolor);
}

input:focus + .slider {
  box-shadow: 0 0 1px var(--va-basecolor);
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
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
.terms{
  width: 92%;
  text-align: center;
  margin:3%;
  height: 45px;
  background-color: #7fdca7;
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
.desc{
  width: 94%;height: 50px;
  outline: none !important;
  border:1px solid #8a8a8a;
  border-radius: 15px;
  padding: 10px;
  margin-left: 6%;
}
.card {
  /*float: left;*/
  background-color: white;

  margin-left: 2%;
  padding: 0.3rem;
  margin-bottom: 2rem;
  border: 0;
  flex-grow: 0;
  flex-shrink: 0;
}
.mycard {
  /* Add shadows to create the "card" effect */
  box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
  transition: 0.3s;
  border-radius: 10px;
  background-color: white;
}
input[type="file"] {
  display: none;
}
</style>
