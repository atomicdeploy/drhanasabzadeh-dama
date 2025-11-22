<template>
  <Header  @headeropenMenu="this.homeOpenMenu()" :isHome="0"/>
  <SideMenu :openMenu="this.openMenu" @headercloseMenu="this.headerCloseMenu()" :group_ref="0"/>
  <div class="center" style="width: 100%;" >
    <div class="row" style="margin: 4% 4% 0 4%">
      <div style="width: 100%" class="row justify--start">
        <p @click="this.base_type=1" style="font-size: 13px;padding: 9px 10px 10px 10px; border-radius: 7px;margin-left: 15px" :class="{ activeconvert: this.base_type === 1,deactiveconvert:this.base_type === 2 }">تبدیل رهن به اجاره</p>
        <p @click="this.base_type=2" style="font-size: 13px;padding: 9px 10px 10px 10px;border-radius: 7px;" :class="{ deactiveconvert: this.base_type === 1,activeconvert:this.base_type === 2 }">تبدیل اجاره به رهن</p>

      </div>
<!--      <div style="width: 10%;margin-top: 5px">-->
<!--        <p style="font-size: 13px;text-align: left;padding: 3% 3% 0 2%">-->
<!--          <font-awesome-icon icon="fa-solid fa-caret-down" style="font-size: 0.75rem;padding-left: 4px"/>-->
<!--        </p>-->
<!--      </div>-->

    </div>
  </div>
  <div  class="mycard" style="height:auto;margin:6% 4% 8% 4%;font-size:14px;padding:8px ;width: 92%;border-radius: 15px">

    <div style="background: #ffffff">
      <p style="padding: 20px 25px 20px 0">مبلغ رهن را به تومان وارد کنید</p>
      <div style="width: 90%;margin:0 5% 0 5%;border-radius:10px;background-color: #eeeeee;height: 45px;margin-left: 0;">
        <input v-model="this.rahn1" @keyup="this.format_prict_rahn1()" placeholder="مبلغ به تومان" class="myfield" style="text-align: center;direction: ltr;width: 100%;font-size: 18px">
      </div>

      <p style="padding: 20px 25px 20px 0">مبلغ اجاره را به تومان وارد کنید</p>
      <div style="width: 90%;margin:0 5% 0 5%;border-radius:10px;background-color: #eeeeee;height: 45px;margin-left: 0;">
        <input v-model="this.ejare1" @keyup="this.format_prict_ejare1()" placeholder="مبلغ به تومان" class="myfield" style="text-align: center;direction: ltr;width: 100%;font-size: 18px">
      </div>

      <hr style="margin: 30px 25px 20px 25px">

<!--      <div style="width: 90%;border-radius:10px;background-color: #eeeeee;height: 45px;margin:20px 5% 20px 5%">-->
<!--        <select v-model="this.convert_type" class="myinput" style="width: 100%">-->
<!--          <option value="0">محاسبه با وارد کردن مبلغ رهن</option>-->
<!--          <option value="1">محاسبه با وارد کردن مبلغ اجاره</option>-->
<!--        </select>-->
<!--      </div>-->

      <p v-if="  this.base_type===1" style="padding: 20px 25px 20px 0">مبلغ رهن جدید را به تومان وارد کنید</p>
      <div v-if=" this.base_type===1" style="width: 90%;margin:0 5% 0 5%;border-radius:10px;background-color: #eeeeee;height: 45px;margin-left: 0;">
        <input v-model="this.rahn2" @keyup="this.format_prict_rahn2()" placeholder="مبلغ به تومان" class="myfield" style="text-align: center;direction: ltr;width: 100%;font-size: 18px">
      </div>


      <p v-if=" this.base_type===2" style="padding: 20px 25px 20px 0">مبلغ اجاره جدید را به تومان وارد کنید</p>
      <div v-if=" this.base_type===2" style="width: 90%;margin:0 5% 0 5%;border-radius:10px;background-color: #eeeeee;height: 45px;margin-left: 0;">
        <input v-model="this.ejare2" @keyup="this.format_prict_ejare2()" placeholder="مبلغ به تومان" class="myfield" style="text-align: center;direction: ltr;width: 100%;font-size: 18px">
      </div>


      <p v-if="this.calced" style="padding: 30px 25px 10px 0">محاسبه بر اساس هر 1 میلیون تومان رهن معادل 30 هزارتومان اجاره</p>
      <p v-if="this.calced" style="padding: 30px 25px 20px 0">مبلغ رهن : <b>{{this.formatter.format(this.newRahn)}}</b> تومان</p>
      <p v-if="this.calced" style="padding: 1px 25px 20px 0">مبلغ اجاره : <b>{{this.formatter.format(this.newEjare)}}</b> تومان</p>

      <button  @click="this.calc()" class="buybtnp" type="button" style="margin:50px 5% 20px 5%;text-align: center;">
        تبدیل
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

import {faUser,faBarcode,faCaretDown } from '@fortawesome/free-solid-svg-icons'
// import { } from '@fortawesome/free-regular-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { useToast } from "vue-toastification";

library.add(faUser,faBarcode,faCaretDown)
export default {
  name: "Profile",
  components: {
    Loading,SideMenu,Header,SubHeader,Footer,FontAwesomeIcon
  },
  mounted() {
    window.scrollTo(0,0);
  },
  methods:{
    format_prict_rahn1(){
      this.con_price=Number(this.rahn1.replaceAll(",", ""))
      if(Number.isNaN(this.con_price)){
        this.myToast("لطفا یک عدد لاتین وارد کنید");
      }
      else{
        this.rahn1=this.formatter.format(this.con_price)
      }
    },
    format_prict_rahn2(){
      this.con_price=Number(this.rahn2.replaceAll(",", ""))
      if(Number.isNaN(this.con_price)){
        this.myToast("لطفا یک عدد لاتین وارد کنید");
      }
      else{
        this.rahn2=this.formatter.format(this.con_price)
      }
    },
    format_prict_ejare1(){
      this.con_price=Number(this.ejare1.replaceAll(",", ""))
      if(Number.isNaN(this.con_price)){
        this.myToast("لطفا یک عدد لاتین وارد کنید");
      }
      else{
        this.ejare1=this.formatter.format(this.con_price)
      }
    },
     format_prict_ejare2(){
      this.con_price=Number(this.ejare2.replaceAll(",", ""))
      if(Number.isNaN(this.con_price)){
        this.myToast("لطفا یک عدد لاتین وارد کنید");
      }
      else{
        this.ejare2=this.formatter.format(this.con_price)
      }
    },



    calc(){
      if(this.rahn1==="" && this.ejare1==="" ){
        this.myToast("هیچکدام از فیلدهای رهن و اجاره پر نشده است.");
        return;
      }
      else if(this.rahn2===""){
        this.myToast("مبلغ رهن جدید وارد نشده است");
        return;
      }
      var rahn11=Number(this.rahn1.replaceAll(",", ""))
      var ejare11=Number(this.ejare1.replaceAll(",", ""))
      if(Number.isNaN(rahn11)){
        this.myToast("مبلغ رهن را یک عدد لاتین وارد کنید");
      }
      else if(Number.isNaN(ejare11)){
        this.myToast("مبلغ اچاره را یک عدد لاتین وارد کنید");
      }
      else{

        if(this.base_type===1){
          var rahn22=Number(this.rahn2.replaceAll(",", ""))
          if(Number.isNaN(rahn22)){
            this.myToast("مبلغ اچاره را یک عدد لاتین وارد کنید");
            return
          }
          else{
            var nEjare=Number(rahn11-rahn22)/1000000*30000;
            console.log(rahn11)
            console.log(rahn22)
            this.newEjare=ejare11+nEjare;

            this.newRahn=rahn22;
            this.calced=true;
          }
        }
        else if(this.base_type===2){
          var ejare22=Number(this.ejare2.replaceAll(",", ""))
          if(Number.isNaN(ejare22)){
            this.myToast("مبلغ اچاره را یک عدد لاتین وارد کنید");
            return
          }
          else{
            var nRahn=Number(ejare11-ejare22)/30000*1000000;
            console.log(ejare11)
            console.log(ejare22)
            this.newRahn=Math.round(rahn11+nRahn);

            this.newEjare=ejare22;
            this.calced=true;
          }
        }
        //  Math.trunc(-1.6)
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
      rahn1:"",
      rahn2:"",
      ejare1:"",
      ejare2:"",
      comission:0,
      payable:0,
      con_price:0,
      comission_formater:"",
      payable_formater:"",
      convert_type:0,
      newEjare:0,
      newRahn:0,
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