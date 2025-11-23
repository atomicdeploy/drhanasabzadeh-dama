<template>
    <Header  @headeropenMenu="this.homeOpenMenu()"  :isHome="0"/>
    <SideMenu :openMenu="this.openMenu" @headercloseMenu="this.headerCloseMenu()" :group_ref="0"/>
  <Loading v-if="this.geted===1" />
  <div v-if="this.geted===2" class="center" style="width: 100%;" >
      <div class="row">
        <p style="width: 100%;text-align: center">
          <img v-if="this.ok===1" style="height: 170px;padding-top:5px;" src="../assets/images/okorder.png">
          <img v-if="this.ok===0" style="height: 120px;padding-top:25px;" src="../assets/images/faildpay.png">
        </p>
      </div>
    <div class="row" style="text-align: center;margin: 0 3% 0 3%">
      <p style="margin: 10% 2% 4% 2%;line-height: 1.7;color:var(--va-textcolor);font-weight: bold;
          text-align: center;width: 100%; font-size: 24px;">{{ this.msg }}</p>

      <p style="width: 100%;">{{ this.content }}</p>
    </div>


    <button v-if="this.ok===0" @click="this.$router.push({ path: '/' })" class="mybtn2" type="button" style="margin: 15% 4% 10% 0;text-align: center;">
        بازگشت
    </button>
    <button v-else-if="this.buy_type==='BuyCourse'" @click="this.$router.push({ path: '/mycourses' })" class="mybtn2" type="button" style="margin: 15% 4% 10% 0;text-align: center;background-color: #34cc73">
      مشاهده دوره های من
    </button>
    <button v-else @click="this.$router.push({ path: '/' })" class="mybtn2" type="button" style="margin: 15% 4% 10% 0;text-align: center;">
      بازگشت
    </button>

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
import { faWallet} from '@fortawesome/free-solid-svg-icons'
import { } from '@fortawesome/free-regular-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

import { useToast } from "vue-toastification";

library.add(faWallet)
export default {

  name: "Invoice",

  components: {
    Loading,SideMenu,Header,SubHeader,Footer,FontAwesomeIcon
  },
  mounted() {
    this.getRow();
    window.scrollTo(0,0);
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
    getRow(){
      // if (typeof this.$route.query.Authority === 'undefined'){
      //   this.$router.push({ path: '/' });
      //   return;
      // }
      if(localStorage.getItem('tk')===null){
        this.$router.push({ path: '/mobile' });
        return;
      }
      this.geted=1;
      const mydata = {
        action:'payresult',
        lang:this.$i18n.locale,
      };
      if (typeof this.$route.query.Authority !== 'undefined'){
        mydata.Authority=this.$route.query.Authority
      }
      else if (typeof this.$route.query.trackId !== 'undefined'){
        mydata.success=this.$route.query.success
        mydata.trackId=this.$route.query.trackId
        mydata.orderId=this.$route.query.orderId
      }
       else if (typeof this.$route.query.code !== 'undefined'){
        mydata.code=this.$route.query.code
        mydata.refid=this.$route.query.refid
      }
      // else{
      //     this.$router.push({ path: '/' });
      //     return;
      // }
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

            if(response.data.ok===1 || response.data.ok===0){
              this.ok=response.data.ok;
              this.msg=response.data.msg;
              this.content=response.data.content;
              this.geted=2;
              this.buy_type=response.data.buy_type;
              localStorage.setItem('total_basket',0);
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
      geted:0,
      getedPay:0,
      getedDiscount:0,
      openMenu:false,
      formatter : new Intl.NumberFormat('en', {
        maximumFractionDigits:0,
      }),
      code:"",
      useWallet:0,
      credit:0,
      ok:2,
      msg:"",
      content:"",
      buy_type:"",
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
}
.swal2-input{
  direction: ltr;
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
</style>
