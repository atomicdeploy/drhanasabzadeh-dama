<template>
  <Header  @headeropenMenu="this.homeOpenMenu()" :isHome="0"/>
 <SideMenu :openMenu="this.openMenu" @headercloseMenu="this.headerCloseMenu()" :group_ref="0"/>
  <div class="center" style="width: 100%;" >
    <div class="row" style="margin: 4% 4% 0 4%">
      <div style="width: 100%" class="row justify--start">
        <p @click="this.base_type=1" style="font-size: 13px;padding: 9px 7px 10px 7px; border-radius: 7px;margin-left: 15px" :class="{ activeconvert: this.base_type === 1,deactiveconvert:this.base_type === 2 }">کمیسیون خرید و فروش</p>
        <p @click="this.base_type=2" style="font-size: 13px;padding: 9px 7px 10px 7px;border-radius: 7px;" :class="{ deactiveconvert: this.base_type === 1,activeconvert:this.base_type === 2 }">کمیسیون رهن و اجاره</p>

      </div>
<!--      <div style="width: 5%;margin-top: 5px">-->
<!--        <p style="font-size: 13px;text-align: left;padding: 3% 3% 0 2%">-->
<!--          <font-awesome-icon icon="fa-solid fa-caret-down" style="font-size: 0.75rem;padding-left: 4px"/>-->
<!--        </p>-->
<!--      </div>-->

    </div>
  </div>
  <div  class="mycard" style="height:auto;margin:8% 4% 8% 4%;font-size:14px;padding:8px ;width: 92%;border-radius: 15px">

  <div style="background: #ffffff">
    <p v-if="base_type===1" style="padding: 20px 25px 10px 0">مبلغ ملک را به تومان وارد کنید</p>
    <div v-if="base_type===1" style="width: 90%;margin:0 5% 0 5%;border-radius:10px;background-color: #eeeeee;height: 45px;margin-left: 0;">
      <input v-model="this.price" @keyup="this.format_prict()" placeholder="مبلغ به تومان" class="myfield" style="text-align: center;direction: ltr;width: 100%;font-size: 18px">
    </div>


    <p v-if="base_type===2" style="padding: 20px 25px 10px 0">مبلغ رهن  را به تومان وارد کنید</p>
    <div v-if="base_type===2" style="width: 90%;margin:0 5% 0 5%;border-radius:10px;background-color: #eeeeee;height: 45px;margin-left: 0;">
      <input v-model="this.rahn" @keyup="this.format_prict_rahn()" placeholder="مبلغ به تومان" class="myfield" style="text-align: center;direction: ltr;width: 100%;font-size: 18px">
    </div>
    <p v-if="base_type===2" style="padding: 20px 25px 10px 0">مبلغ اجاره  را به تومان وارد کنید</p>
    <div v-if="base_type===2" style="width: 90%;margin:0 5% 0 5%;border-radius:10px;background-color: #eeeeee;height: 45px;margin-left: 0;">
      <input v-model="this.ejare" @keyup="this.format_prict_ejare()" placeholder="مبلغ به تومان" class="myfield" style="text-align: center;direction: ltr;width: 100%;font-size: 18px">
    </div>

    <p v-if="this.calced && this.base_type===1" style="padding: 30px 25px 10px 0">کمیسیون = نیم درصد مبلغ ملک + 9 درصد مالیات از کمیسیون محاسبه شده</p>
    <p v-if="this.calced && this.base_type===2" style="padding: 30px 25px 10px 0">کمیسیون = 50 درصد مبلغ اجاره + 1 درصد از مبلغ رهن + 9 درصد مالیات از کمیسیون محاسبه شده</p>
    <p v-if="this.calced" style="padding: 30px 25px 20px 0">جمع کل کمیسیون : <b>{{this.comission_formater}}</b> تومان</p>
    <p v-if="this.calced" style="padding: 1px 25px 20px 0">سهم خریدار : <b>{{this.payable_formater}}</b> تومان</p>
    <p v-if="this.calced" style="padding: 1px 25px 20px 0">سهم فروشنده : <b>{{this.payable_formater}}</b> تومان</p>
    <button  @click="this.calc()" class="buybtnp" type="button" style="margin:20px 5% 20px 5%;text-align: center;">
    محاسبه کمیسیون
    </button>
  </div>
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

import {faUser,faBarcode } from '@fortawesome/free-solid-svg-icons'
// import { } from '@fortawesome/free-regular-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { useToast } from "vue-toastification";

library.add(faUser,faBarcode)
export default {
  name: "Profile",
  components: {
    Loading,SideMenu,Header,SubHeader,Footer,FontAwesomeIcon
  },
  mounted() {
    window.scrollTo(0,0);
  },
  methods:{
    format_prict(){
      this.con_price=Number(this.price.replaceAll(",", ""))
      if(Number.isNaN(this.con_price)){
        this.myToast("لطفا یک عدد لاتین وارد کنید");
      }
      else{
        this.price=this.formatter.format(this.con_price)
      }
    },
   format_prict_rahn(){
      this.con_price=Number(this.rahn.replaceAll(",", ""))
      if(Number.isNaN(this.con_price)){
        this.myToast("لطفا یک عدد لاتین وارد کنید");
      }
      else{
        this.rahn=this.formatter.format(this.con_price)
      }
    },
   format_prict_ejare(){
      this.con_price=Number(this.ejare.replaceAll(",", ""))
      if(Number.isNaN(this.con_price)){
        this.myToast("لطفا یک عدد لاتین وارد کنید");
      }
      else{
        this.ejare=this.formatter.format(this.con_price)
      }
    },
    calc(){
      if(this.base_type===1){
        var price=Number(this.price.replaceAll(",", ""))
        if(Number.isNaN(price)){
          this.myToast("لطفا یک عدد لاتین وارد کنید");
        }
        else{
          this.comission=price*0.005;
          this.comission=this.comission+(0.09*this.comission);
          this.comission=Math.trunc(this.comission);
          this.comission_formater=this.formatter.format(Math.trunc(this.comission));
          this.payable=Math.trunc(this.comission/2);
          this.payable_formater=this.formatter.format(Math.trunc(this.payable));
          this.calced=true
          //  Math.trunc(-1.6)
        }
      }
      if(this.base_type===2){

        var rahn1=Number(this.rahn.replaceAll(",", ""))

        var ejare1=Number(this.ejare.replaceAll(",", ""))
        if(Number.isNaN(rahn1)){
          this.myToast("لطفا رهن را یک عدد لاتین وارد کنید");
        }
        else if(Number.isNaN(ejare1)){
          this.myToast("لطفا اجاره را یک عدد لاتین وارد کنید");
        }
        else{
          var coms=0;
          if(rahn1>0){
            coms=rahn1* 0.01
          }
          if(ejare1>0){
            coms+=ejare1*0.5
          }

          this.comission=coms;
          this.comission=this.comission+(0.09*this.comission);
          this.comission=Math.trunc(this.comission);
          this.comission_formater=this.formatter.format(Math.trunc(this.comission));
          this.payable=Math.trunc(this.comission/2);
          this.payable_formater=this.formatter.format(Math.trunc(this.payable));
          this.calced=true
          //  Math.trunc(-1.6)
        }
      }

    },
    onFileChange(e) {
      const file = e.target.files[0];
      this.url = URL.createObjectURL(file);
    },
    getFileName(){
      this.filename= document.getElementById("file-upload").value;
    },
    myToast(alert){
      useToast().warning(alert, {
        timeout: 3000,
        position:'top-center'
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

  },

  data(){
    return{
      base_type:1,
      openMenu:false,
      formatter : new Intl.NumberFormat('en', {
        maximumFractionDigits:20,
      }),
      calced:false,
      price:"",
      rahn:"",
      ejare:"",
      comission:0,
      payable:0,
      con_price:0,
      comission_formater:"",
      payable_formater:"",
    }
  }
};

</script>
<style>
.myinput{
  padding: 0 8px 0 5px;
  background: unset;
  border-radius: unset;
  height: 45px;
  border: 0;
  font-family: IRANYekan;
}
option {
  font-family: IRANYekan;
}
.va-progress-circle{
  /*width: auto !important;*/
}
.buybtnp{
  width: 90%;
  text-align: center;

  height: 45px;
  background-color: var(--va-greencolor);
  color:white;
  border-radius: 10px;
  border:unset;
  cursor: pointer;
}

.myfield{
  padding: 0 8px 0 5px;
  background: unset;
  border-radius: unset;
  height: 45px;
  border: 0;
  font-family: IRANYekan;
}
.activeconvert{
  cursor: pointer;
  background: var(--va-basecolor);
  color: white;
  font-weight: bold;
}
.deactiveconvert{
  cursor: pointer;
  background: #dbdbdb;
  color: black;
}
</style>