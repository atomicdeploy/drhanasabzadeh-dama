<template>
  <Header  @headeropenMenu="this.homeOpenMenu()"  :isHome="0"/>
  <SideMenu :openMenu="this.openMenu" @headercloseMenu="this.headerCloseMenu()" :group_ref="0"/>
  <Loading v-if="this.geted===1" />
  <div class="center" style="width: 100%;" >
    <div class="row" v-if="this.geted===2" style="margin: 4% 4% 1% 4%">
      <p  style="font-size: 13px;width: 49%;padding: 3% 2% 3% 3%">{{$t('Contact.contact')}}</p>
      <p style="font-size: 13px;width: 49%;padding: 3% 3% 3% 2%" :class="{rtl_lang:$t('config.dir')==='ltr',ltr_lang:$t('config.dir')==='rtl'}">
        <font-awesome-icon icon="fa-solid fa-caret-down" style="font-size: 0.75rem;padding-left: 4px"/>
      </p>
    </div>
    <div v-if="this.geted===2" class="row" style="text-align: right;margin: 0 3% 0 3%">
      <div v-if="this.isLongAbout===1 && this.is_short===0" v-html="this.about" style="margin: 4% 2% 4% 2%;line-height: 1.7;color:var(--va-textcolor);text-align: justify;text-justify: inter-word;word-wrap: break-word;">

      </div>
      <div v-else-if="this.is_short===1" v-html="this.Shortabout" style="margin: 4% 2% 4% 2%;line-height: 1.7;color:var(--va-textcolor);text-align: justify;text-justify: inter-word;word-wrap: break-word;">
      </div>
    </div>
    <div v-if="this.is_short===1 && this.geted===2" @click="this.is_short=0" class="row" style="text-align: center;cursor:pointer;justify-content: center">
      <span style="color:#8a8a8a">{{$t('Contact.more')}}</span>
      <p style="margin-top: -1%">
        <va-icon style="margin-bottom: 5%;color:#8a8a8a" class="material-icons">expand_more</va-icon>
      </p>
    </div>
    <div v-else-if="this.is_short===0 && this.geted===2"  @click="this.is_short=1" class="row" style="text-align: center;cursor:pointer;justify-content: center">
      <span style="color:#8a8a8a">{{$t('Contact.less')}}</span>
      <p style="margin-top: -1%">
        <va-icon style="margin-bottom: 5%;color: #8a8a8a" class="material-icons">expand_less</va-icon>
      </p>
    </div>

  </div>
  <p v-if="this.geted===2" style="font-size: 15px;width: 90%;padding: 3% 20px 3% 20px;font-weight: bold;color:var(--va-basecolor)">{{$t('Contact.touchWithUs')}}</p>

  <a v-if="this.geted===2 && this.instageram!==''" :href="this.instageram" class="row" style="margin: 4%">
    <img class="img-contact" src="../assets/images/instageram.png" >
    <p class="p-contact">{{$t('Contact.instagram')}}</p>
  </a>
  <a v-if="this.geted===2 && this.whatsapp!==''" :href="this.whatsapp" class="row"  style="margin: 4%">
    <img class="img-contact" src="../assets/images/whatsapp.png">
    <p class="p-contact">{{$t('Contact.whatsapp')}}</p>
  </a>
  <a v-if="this.geted===2 && this.youtube!==''" :href="this.youtube" class="row"  style="margin: 4%">
    <img src="../assets/images/youtube.png" class="img-contact">
    <p class="p-contact">{{$t('Contact.youtube')}}</p>
  </a>
  <a v-if="this.geted===2 && this.telegram!==''" :href="this.telegram" class="row" style="margin: 4%">
    <img src="../assets/images/telegram.png" class="img-contact">
    <p class="p-contact">{{$t('Contact.telegram')}}</p>
  </a>
  <a v-if="this.geted===2 && this.aparat!==''" :href="this.aparat" class="row" style="margin: 4%">
    <img src="../assets/images/aparat.png" class="img-contact">
    <p class="p-contact">{{$t('Contact.aparat')}}</p>
  </a>
  <hr v-if="this.geted===2" style="margin: 20px 30px 20px 30px"/>
  <p v-if="this.geted===2" style="width: 100%;text-align: center;margin-bottom: 10px;color: #6a6a6a">{{$t('Contact.development')}}: <span style="color: #5d8bff">dama-app.ir</span></p>
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

library.add(faCaretDown)
export default {

  name: "Invoice",

  components: {
    Loading,SideMenu,Header,SubHeader,Footer,FontAwesomeIcon,LoadingButton
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
        action:'getContact',
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
              this.about=response.data.about;
              this.instageram=response.data.instageram;
              this.aparat=response.data.aparat;
              this.telegram=response.data.telegram;
              this.whatsapp=response.data.whatsapp;
              this.youtube=response.data.youtube;
              this.isLongAbout=response.data.isLongAbout;
              this.Shortabout=response.data.Shortabout;
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
      isLongAbout:0,
      is_short:1,
      Shortabout:"",
      about:"",
      whatsapp:"",
      telegram:"",
      instageram:"",
      youtube:"",
      aparat:"",
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