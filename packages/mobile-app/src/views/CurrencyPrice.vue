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
      <p class="default" style="font-size: 13px;width: 50%;padding: 3% 2% 3% 0;font-weight: bold">قیمت های لحظه ای</p>
      <p style="font-size: 13px;width: 50%;text-align: left;padding: 3% 3% 3% 2%">
        <font-awesome-icon class="default" icon="fa-solid fa-caret-down" style="font-size: 0.75rem;padding-left: 4px"/>
      </p>
    </div>
   </div>

  <div  v-if="this.geted===2 ">

    <table id="currencytable" style="width: 96%; margin: 0 2% 0 2%; border-collapse: collapse;border-radius: 15px">
      <tr v-for="item in data" :key="item.id">
        <td style="font-size: 13px">{{ item.name }}</td>
        <td style="line-height: 16px">{{ item.price }}<br/><span style="font-size: 12px">{{ item.unit }}</span></td>

        <td v-if="item.id===0">{{ item.change_price }}</td>
        <td v-else-if="item.change_price_int>0" style="color:#1cd91c;font-weight: bold">{{ item.change_price }}</td>
        <td v-else style="color:#ff3939">{{ item.change_price }}</td>
        <td>{{ item.date_price }}</td>
      </tr>
    </table>

  </div>



  <Footer :selected_num="3"/>
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

  name: "CurrencyPrice",
  computed: {
    ...mapWritableState(useTempStroe, ["selected_num"])
  },
  components: {
    Loading,SideMenu,Header,SubHeader,Footer,FontAwesomeIcon,LoadingButton,GDialog
  },
  mounted() {
    this.selected_num=3
    this.getRow(1);
    window.scrollTo(0,0);
    this.intervalId = setInterval(() => this.getRow(0), 30000);
  },
  methods:{


    homeOpenMenu(){
      this.openMenu=true;
      console.log("homeOpenMenu");
    },
    headerCloseMenu(){
      this.openMenu=false;
      console.log("homeCloseMenu");
    },
    getRow(hasloading=1){
      if(hasloading===1){
        this.geted=1;
      }

      const mydata = {
        action:'getCurrencyPrice',
        // lang:this.$i18n.locale,
      };
      this.$http(
          {
            method: "post",
            url: this.apiurl,
            timeout: 1000 * 20, // Wait for 5 seconds
            data: mydata,
            headers: {
              "Content-Type": "application/json",
              "Authorization": `Bearer ${localStorage.getItem('tk')}`
            },
          })
          .then((response) => {
            if(response.data.ok===1){
              this.data=response.data.data;
              if(hasloading===1){
                this.geted=2;
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
              if(hasloading===1){
                this.geted=3;
              }
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
            if(hasloading===1){
              this.geted=3;
            }
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
      intervalId: null,
    }
  }
};

</script>
<style>
table {
  width: 100%;
  max-width: 100%; /* عرض جدول از 100 درصد بیشتر نخواهد شد */
  border-collapse: collapse; /* حذف فاصله بین سلول‌ها */
  border-radius: 15px; /* گرد کردن گوشه‌ها */
  overflow: hidden; /* جلوگیری از خروج محتوا از گوشه‌های گرد */
  border: 1px solid #ddd; /* اضافه کردن خط دور جدول */
}

tr {
  line-height: 2.5; /* تنظیم فاصله بین خطوط */
}

td {
  padding: 10px; /* افزودن فضای داخلی سلول‌ها */
  text-align: right; /* تراز متن به سمت چپ */
}
</style>
