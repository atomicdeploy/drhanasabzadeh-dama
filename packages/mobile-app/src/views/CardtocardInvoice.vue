<template>
  <Header  @headeropenMenu="this.homeOpenMenu()"  :isHome="0"/>
 <SideMenu :openMenu="this.openMenu" @headercloseMenu="this.headerCloseMenu()" :group_ref="0"/>

  <div class="center" style="width: 100%;" >
    <div class="row">
      <p style="width: 100%;text-align: center">
        <img  style="height: 170px;padding-top:5px;" src="../assets/images/okorder.png">
      </p>
    </div>
    <div class="row" style="text-align: center;margin: 0 3% 0 3%">
      <p style="margin: 10% 2% 4% 2%;line-height: 1.7;color:var(--va-textcolor);font-weight: bold;
      text-align: center;width: 100%; font-size: 24px;">اطلاعات پرداخت با موفقیت ارسال شد</p>
    </div>
    <div class="row" style="text-align: center;margin: 0 3% 0 3%">
      <p style="margin: 10% 2% 4% 2%;line-height: 1.5;color:var(--va-textcolor);
      text-align: center;width: 100%; font-size: 24px;">پس از تایید اطلاعات، پرداخت شما تایید خواهد شد و خرید شما فعال خواهد شد</p>
    </div>



    <button  @click="this.$router.push({ path: '/' })" class="mybtn2" type="button" style="margin: 15% 4% 10% 0;text-align: center;">
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


library.add(faWallet)
export default {

  name: "CardtocardInvoice",

  components: {
    Loading,SideMenu,Header,SubHeader,Footer,FontAwesomeIcon
  },
  mounted() {
    window.scrollTo(0,0);
  },
  methods:{
    homeOpenMenu(){
      this.openMenu=true;
    },
    headerCloseMenu(){
      this.openMenu=false;
    },
  },
  data(){
    return{
      openMenu:false,
    }
  }
};

</script>
<style>
.mybtn2{
  width: 92%;
  text-align: center;
  margin:20px;
  height: 45px;
  background-color: var(--va-basecolor);
  color:white;
  border-radius: 10px;
  border:unset;
  cursor:pointer;
}
</style>