<template>

  <HeaderShop  @headeropenMenu="this.homeOpenMenu()"  :isHome="1"/>
  <SideMenu  :openMenu="this.openMenu" @headercloseMenu="this.headerCloseMenu()" :group_ref="0"/>
  <GDialog v-model="this.loginDialog" max-width="500" >
    <div class="wrapper" style="">
      <div class="content">
        <div style="width: 100%;text-align: center">
          <img style="width:85px " src="../../assets/images/needlogin.png">
        </div>
        <div style="width: 100%;text-align: center;font-size: 18px;font-weight: bold;padding: 10px">{{$t('General.loginApplication')}}</div>

        <p style="width: 100%;text-align: center;font-size: 14px;padding: 10px 0 10px 0">
          {{$t('General.loginApplicationDesc')}}
        </p>
      </div>
    </div>
    <div class="row" style="padding: unset;margin-top: 15px ">
      <div @click="this.$router.push({ path: '/mobile' });" style="width: 50%;text-align: center;background: var(--va-basecolor);padding: 10px 0 10px 0;color:white" class="modallogin"> {{$t('General.loginApplicationBtn')}}</div>
      <div @click="this.loginDialog=false" style="width: 50%;text-align: center;background: #dddddd;padding: 10px 0 10px 0"  class="modalcancel">{{$t('General.loginApplicationCancel')}}</div>
    </div>
  </GDialog>
  <Loading v-if="this.geted===1 "/>


  <div  v-if="this.geted===2 && this.list.length>0" style="margin: 25px 3% 20px 3%;background-color: white;padding: 10px;border-radius: 20px  ">

    <div class="rowshop" style="justify-content: space-between;padding: 5px 0 20px 0">
      <div class="flex md2" style="font-size: 15px;text-align: center;width:25%">نام محصول</div>
      <div class="flex md2" style="font-size: 15px;text-align: center;width:7%">تعداد</div>
      <div class="flex md2" style="font-size: 15px;text-align: center;width:22%">قیمت</div>
      <div class="flex md2" style="font-size: 15px;text-align: center;width:23%">تخفیف</div>
      <div class="flex md2" style="font-size: 15px;text-align: center;width: 25%">قیمت فروشگاه</div>

    </div>
    <hr style="margin: 0 5% 15px 5%;width: 90%">
      <div v-for="item in list" :key="item.id" class="rowshop" style="justify-content: space-between;padding: 0 0 15px 0">
        <div class="flex md2" style="font-size: 15px;text-align: center;width: 25%">{{item.name}}</div>
        <div class="flex md2" style="font-size: 15px;text-align: center;width:7%">{{item.amount}}</div>
        <div class="flex md2" style="font-size: 15px;text-align: center;width:22%">{{item.price_off}}</div>
        <div class="flex md2" style="font-size: 15px;text-align: center;width:23%">{{item.discount}}</div>
        <div class="flex md2" style="font-size: 15px;text-align: center;width: 25%">{{item.price}}</div>
      </div>
      <hr style="margin: 0 5% 10px 5%;width: 90%;color: #b4b4b4">
      <div class="rowshop" style="justify-content: space-between;padding: 0 0 10px 0">
        <div class="flex md2" style="font-size: 15px;text-align: center;width: 25%">جمع</div>
        <div class="flex md2" style="font-size: 15px;text-align: center;width:7%">{{this.sum_amount}}</div>
        <div class="flex md2" style="font-size: 15px;text-align: center;width:22%">{{this.sum_price_off}}</div>
        <div class="flex md2" style="font-size: 15px;text-align: center;width:23%">{{this.sum_discount}}</div>
        <div class="flex md2" style="font-size: 15px;text-align: center;width: 25%">{{this.sum_price}}</div>
      </div>
    <hr style="margin: 0 5% 0 5%;width: 90%">
    <div class="rowshop" style="justify-content: space-between;padding: 15px 0 15px 0">
      <div class="flex md5" style="font-size: 15px;text-align: center;width: 50%">مبلغ قابل پرداخت:</div>
      <div class="flex md5" style="font-size: 15px;text-align: center;width:49%;color:var(--va-greencolor);font-weight: bold">{{this.sum_price}} تومان</div>
    </div>
   </div>
  <div  v-if="this.geted===2 && this.list.length>0" style="margin: 0 3% 0 3%;background-color: white;padding: 20px;border-radius: 20px  ">
      <p  style="margin-bottom: 2%">شماره تماس تحویل گیرنده:</p>
      <input type="tel" placeholder="شماره تماس" v-model="this.reciver_tel" class="myfield" style="text-align: left;">
      <p style="margin: 20px 0 2% 0">کدپستی:</p>
      <input  placeholder="کدپستی" v-model="this.postalcode" class="myfield" style="text-align: left;">
      <p  style="margin: 20px 0 2% 0">نام و نام خانوادگی تحویل گیرنده:</p>
      <input  placeholder="نام و نام خانوادگی" v-model="this.reciver_name" class="myfield" style="text-align: right">

      <p style="margin: 20px 0 2% 0">آدرس دقیق دریافت سفارش:</p>
      <textarea rows="2" type="tel" v-model="this.address" class="myfield_address"></textarea>
  </div>


  <div v-if="this.geted===2 && this.list.length>0">
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
    <div v-if="this.pay===1 || this.pay===2" class="row" style="margin: 20px 4% 15px 3%">
      <vue-feather type="credit-card" size="22" style="margin: 1% 0 0 1%"></vue-feather>
      <p style="margin: 2%;font-size: 16px">{{$t('Invoice.payable')}}: </p>
       <p style="margin: 2%;font-weight: bold;color: var(--va-greencolor)">{{ this.sum_price }} {{$t('Invoice.currency')}}</p>
    </div>
    <div v-if="this.pay===2" class="mycard" style="margin: 0 15px 25px 15px;padding:15px 10px 10px 10px ;cursor: pointer;border-radius: 15px;">
      <p v-if="this.card1_number!=='' && this.card2_number!==''" style="margin-bottom: 2%;color: #636363;font-size: 13px">{{$t('Invoice.cardMultiText')}}:</p>
      <p v-else style="margin-bottom: 2%;color: #636363;font-size: 13px">{{$t('Invoice.cardOneText')}}:</p>
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
            <img v-if="this.url!==''" :src="url" style="height: 100%;max-width:100%;text-align: center"/>
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

  </div>



  <div v-if="this.geted===2" class="row" style="text-align: right;margin: 20px 20px 15px 0">
    <input id="terms" v-model="this.terms" type="checkbox" style="width: 20px;height: 20px"/>
    <label for="terms" style="position:relative;top:2px;right: 8px;cursor: pointer">قوانین سایت را می پذیرم</label>
    <router-link to="/terms">
      <label style="position:relative;top:2px;right: 15px;cursor: pointer;color: dodgerblue">(مشاهده قوانین)</label>
    </router-link>
  </div>
  <button v-if="this.pay_status===4 && this.geted===2" @click="this.myToast('ساعاتی دیگر مجددا بررسی کنید')"   class="terms" type="button" style="margin: 5px 4% 10% 0;text-align: center ">
    پرداخت غیر فعال است
  </button>
  <button v-else-if="this.terms===false && this.geted===2" @click="this.myToast('لطفا ابتدا قوانین سایت را قبول کنید.')"  class="terms" type="button" style="margin: 5px 4% 10% 0;text-align: center;">
    پرداخت و خرید محصول
  </button>
  <button v-else-if="this.getedPay===1 && this.geted===2" class="buybtn" type="button" style="margin: 5px 4% 10% 0;text-align: center;">
    <p style="width: 100%;text-align: center">
      <LoadingButton/>
      <!--        <va-progress-circle size="42px" indeterminate color="white" thickness="0.27" />-->
    </p>
  </button>
  <button  v-else-if="this.geted===2" @click="this.doAction()" class="buybtn" type="button" style="margin: 5px 4% 10% 0;text-align: center">
    پرداخت و خرید محصول
  </button>
  <FooterShop :selected_num="2" :total_basket="this.total_basket"/>

</template>

<script>
import { library } from '@fortawesome/fontawesome-svg-core'
import Loading from '../../components/Loading.vue'
import HeaderShop from './HeaderShop.vue'
import FooterShop from './FooterShop.vue'
import SubHeader from '../../components/SubHeader.vue'
import SideMenu from '../../components/SideMenu.vue'
import LoadingButton from '../../components/LoadingButton.vue'
import { faAngleLeft,faTrash,faWallet,faMoneyCheckDollar,faCircleCheck,faCopy} from '@fortawesome/free-solid-svg-icons'
import { faTrashCan,faCreditCard,faCircle } from '@fortawesome/free-regular-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { useToast } from "vue-toastification";
import 'gitart-vue-dialog/dist/style.css'
import { GDialog } from 'gitart-vue-dialog'
library.add(faAngleLeft,faTrash,faTrashCan,faWallet,faCreditCard,faMoneyCheckDollar,faCircle,faCircleCheck,faCopy)
export default {
  name: "BasketInvoice",
  components: {
    Loading,SideMenu,HeaderShop,SubHeader,FooterShop,FontAwesomeIcon,LoadingButton,GDialog
  },
  mounted() {
    this.loadData();
    window.scrollTo(0,0);
    this.total_basket=localStorage.getItem('total_basket');
  },
  methods:{
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
    inviteFriend(){
      this.$emit("headercloseMenu");
      let self = this;
      if (navigator.share){
        navigator.share({
          title: self.title,
          text: self.description,
        })
      }
    },
    goToPage(id){
      this.$router.push({ path: '/shop/detail/'+id });
    },
    myToast(alert){
      useToast().warning(alert, {
        timeout: 2000,
        position:'top-center',
        rtl: this.$t('config.dir')==='rtl'?true:false
      });
    },
    loadData(basecat=0,cat=0,subcat=0){
      this.geted=1;
      const mydata = {
        action:'invoiceShop',
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
            this.firstLoad=0;
            if(response.data.ok===1){
              if(response.data.list!==null){
                this.list=response.data.list;
                this.sum_amount=response.data.sum_amount;
                this.sum_discount=response.data.sum_discount;
                this.sum_price=response.data.sum_price;
                this.sum_price_off=response.data.sum_price_off;
                this.list_count=this.list.length;
                this.reciver_name=response.data.reciver_name
                this.reciver_tel=response.data.reciver_tel
                this.postalcode=response.data.postalcode
                this.address=response.data.address
                this.online=response.data.online;
                this.card=response.data.card;
                this.crypto=response.data.crypto;
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
              this.myToast(response.data.msg);
            }
          })
          .catch(error => {
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
    doAction(){
      this.reciver_tel=this.fixNumbers(this.reciver_tel);
      this.postalcode=this.fixNumbers(this.postalcode);
      if(localStorage.getItem('tk')==="" || localStorage.getItem('tk')===null){
        this.loginDialog=true
        return;
      }
      else if(this.reciver_tel.length!==11){
        this.myToast("شماره تماس را به صورت 11 رقمی وارد کنید");
        return;
      }
      else if(this.postalcode.length!==10){
        this.myToast("کدپستی را به صورت 10 رقمی وارد کنید");
        return;
      }
      else if(this.reciver_name.length<4){
        this.myToast("نام و نام خانوادگی را به صورت کامل وارد کنید");
        return;
      }
      else if(this.address.length<8){
        this.myToast("آدرس را به صورت کامل وارد کنید");
        return;
      }

      this.getedPay=1;
      const mydata = {
        action:'getPayLinkShop',
        reciver_name:this.reciver_name,
        reciver_tel:this.reciver_tel,
        postal_code:this.postalcode,
        address:this.address,
        pay:this.pay,
        card_tracking:this.card_tracking,
        card_price:this.card_price,
        card_date:this.card_date,
        card_comment:this.card_comment,
        lang:this.$i18n.locale,
      };
      if(this.pay===2){
        const file = document.querySelector('#file-upload');
        if(file.files.length!==0){
          mydata.file=file.files[0]
        }
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
              if(response.data.pay===2){
                this.$router.push({ path: '/cardtocard'});
              }
              else if(response.data.pay===3){
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
                title: 'موفقیت آمیز !',
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
    slider_click(v){
      console.log(v)
    },
    homeOpenMenu(){
      this.openMenu=true;
      console.log("homeOpenMenu");
    },
    headerCloseMenu(){
      this.openMenu=false;
      console.log("homeCloseMenu");
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
      list:[],
      reciver_name:"",
      reciver_tel:"",
      postalcode:"",
      address:"",
      pay_status:0,
      terms:false,
      getedPay:0,
      sum_amount:0,
      sum_price_off:0,
      sum_price:0,
      sum_discount:0,
      pay:1,
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
    }
  }
};

</script>
<style>

.awesome{
  margin: 15px 0 15px 0;
  font-size: 2.5rem;
}
.row::-webkit-scrollbar {
  display: none;
}


.rowshop{
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
.rowshop::-webkit-scrollbar {
  display: none;
}
.footer_basket {
  background-color: white;
  margin: 0 0 0 0;
  position: fixed;
  bottom: 60px;
  height: 55px;
  /*width: 100%;*/
  /*max-width: 540px;*/
  color: white;
  /*text-align: center;*/
  /*height: 100px;*/
  width: 100% !important;
  max-width: 540px !important;
  right: unset !important;
  left: unset !important;
}
.myfield{
  width: 100%;height: 50px;
  outline: none !important;
  border:1px solid #8a8a8a;
  border-radius: 15px;
  padding-left: 10px;
  padding-right: 10px;
}
.myfield_address{
  width: 94%;
  height: 50px;
  padding: 10px;
  text-align: right;
  margin-left: 10px;
  outline: none !important;
  border:1px solid #8a8a8a;
  border-radius: 15px;
  padding-left: 10px;
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
input[type="file"] {
  display: none;
}
.price{
  width: 100%;height: 50px;
  text-align: left;
  outline: none !important;
  border:1px solid #8a8a8a;
  border-radius: 15px;
  padding-left: 10px;
}
</style>