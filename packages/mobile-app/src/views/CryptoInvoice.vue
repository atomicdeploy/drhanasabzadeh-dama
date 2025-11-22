<template>
    <Header  @headeropenMenu="this.homeOpenMenu()"  :isHome="0"/>
    <SideMenu :openMenu="this.openMenu" @headercloseMenu="this.headerCloseMenu()" :group_ref="0"/>
  <div  class="center" style="width: 100%;" >
      <div  style="text-align: center;">
        <p v-if="this.crypto_address!==''" style="width: 100%;text-align: center;margin-top: 30px;margin-bottom: 10px">
          <qrcode-vue :value="this.crypto_address" :size="200" level="H" />
        </p>

        <p @click="this.copy(this.crypto_address)" style="text-align: center;margin-bottom: 20px;width: 100%;cursor: pointer">{{this.crypto_address}}
          <font-awesome-icon icon="fa-solid fa-copy" style=" font-size: 1.32rem"/>
        </p>
        <p  style="text-align: center;margin: 20px">
         پس از پرداخت ، تا حداکثر 10 دقیقه محصول خریداری شده برای شما فعال خواهد شد
        </p>

      </div>
    <button @click="this.$router.back()" class="buybtn" type="button" style="margin: 5px 4% 10% 0;text-align: center;">
      بازگشت
    </button>

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
import { faCopy,faMoneyCheckDollar,faCircleCheck} from '@fortawesome/free-solid-svg-icons'


import {faCreditCard,faCircle } from '@fortawesome/free-regular-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import LoadingButton from '../components/LoadingButton.vue'
import { useToast } from "vue-toastification";
import QrcodeVue from 'qrcode.vue'
library.add(faCopy)
export default {

  name: "Invoice",

  components: {
    Loading,SideMenu,Header,SubHeader,Footer,FontAwesomeIcon,QrcodeVue
  },
  mounted() {
    window.scrollTo(0,0);
    this.crypto_address=this.$route.query.address
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
    copy(text) {

      if (!navigator.clipboard) {
        fallbackCopyTextToClipboard(text);
        return;
      }
      navigator.clipboard.writeText(text).then(function() {
        console.log('Async: Copying to clipboard was successful!');
        // this.myToast("لینک کپی شد");
        useToast().success("آدرس کیف پول کپی شد", {
          timeout: 2000,
          position:'top-center',
          rtl: this.$t('config.dir')==='rtl'?true:false
        });
      }, function(err) {
        console.error('Async: Could not copy text: ', err);
      });
    },
    myToast(alert){
      useToast().warning(alert, {
        timeout: 2000,
        position:'top-center',
        rtl: this.$t('config.dir')==='rtl'?true:false
      });
    },
  },

  data(){
    return{
      geted:0,
      openMenu:false,
      formatter : new Intl.NumberFormat('en', {
        maximumFractionDigits:0,
      }),
      crypto_address:"",
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
  text-align: center;
}
.switch input {
  opacity: 0;
  width: 0;
  height: 0;
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
.card {
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
</style>
