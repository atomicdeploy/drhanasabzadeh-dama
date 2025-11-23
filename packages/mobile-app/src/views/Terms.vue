<template>
  <Header  @headeropenMenu="this.homeOpenMenu()"  :isHome="0"/>
  <SideMenu :openMenu="this.openMenu" @headercloseMenu="this.headerCloseMenu()" :group_ref="0"/>
  <Loading v-if="this.geted===1" />
  <div class="center" style="width: 100%;" >
    <div class="row" v-if="this.geted===2" style="margin: 4% 4% 1% 4%">
      <p  style="font-size: 13px;width: 49%;padding: 3% 2% 3% 3%">{{$t('Terms.rules')}}</p>
      <p style="font-size: 13px;width: 49%;padding: 3% 3% 3% 2%" :class="{rtl_lang:$t('config.dir')==='ltr',ltr_lang:$t('config.dir')==='rtl'}">
        <font-awesome-icon icon="fa-solid fa-caret-down" style="font-size: 0.75rem;padding-left: 4px"/>
      </p>
    </div>
    <div v-if="this.geted===2" class="row" style="text-align: right;margin: 0 3% 0 3%">
      <div  v-html="this.terms" style="margin: 4% 2% 4% 2%;line-height: 1.7;color:var(--va-textcolor);text-align: justify;text-justify: inter-word;">
      </div>
    </div>
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

library.add(faCaretDown)
export default {
  name: "Terms",
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
      this.geted=1;
      const mydata = {
        action:'getTerms',
        lang:this.$i18n.locale,
      };
      this.$http(
          {
            method: "post",
            url: this.apiurl,
            timeout: 1000 * 10, // Wait for 5 seconds
            data: mydata,
            headers: {
              "Content-Type": "application/json",
              "Authorization": `Bearer ${localStorage.getItem('tk')}`
            },
          })
          .then((response) => {
            if(response.data.ok===1){
              this.terms=response.data.terms;
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
  },
  data(){
    return{
      geted:0,
      openMenu:false,
      formatter : new Intl.NumberFormat('en', {
        maximumFractionDigits:0,
      }),
      terms:"",
    }
  }
};
</script>
<style>
.img-contact{
  width: 60px;
  object-fit: contain;
}
.p-contact{
  width: 70%;
  padding: 20px 5% 0 0;
}
</style>