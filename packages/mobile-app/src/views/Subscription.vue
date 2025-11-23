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
  <div class="row" v-if="this.geted===0">
    <p style="font-size: 13px;width: 50%;padding: 3% 2% 3% 0">{{ $t('Subscription.buySub')}}</p>
    <p style="font-size: 13px;width: 50%;text-align: left;padding: 3% 3% 3% 2%">
      <font-awesome-icon icon="fa-solid fa-caret-down" style="font-size: 0.75rem;padding-left: 4px"/>
    </p>
  </div>
  <div  v-if="this.geted===2" class="mycard" style="margin:8% 4% 8% 4%;font-size:14px;padding:10px ;width: 92%;border-radius: 15px;line-height: 1.7;">
   <pre>{{this.sub_desc}}</pre>
  </div>
  <div v-for="sub in this.subs" :key="sub.ID"  @click="this.selected_ref=sub.ID;this.payPrice=sub.Price" style="margin:4% 4% 0 4%">
    <div  v-if="this.geted===2" class="mycard" style="position: absolute;margin: 4px 0 0 0; height: 60px;padding:0 ;width: 18%;border-radius: 25%">
      <div  style="padding: 0;">
        <div  class="filterbar" >
          <div class='outer-div'>
            <div class='middle-div' style="margin-top: 12px">
              {{ sub.Name }}
            </div>
          </div>
        </div>
      </div>
    </div>
    <div  v-if="this.geted===2" class="mycard" :class="{ active_card: sub.ID === this.selected_ref,deactive_card:sub.ID !== this.selected_ref }" style="height: 70px;margin:0 30px 0 10%;padding:0 ;width: 92%;border-radius: 15px;">
      <div  style="padding: 15px 0 0 0;margin: 0">
        <div  class="filterbar" >
          <div class='outer-div'>
            <div class='middle-div'>
             <div class="row">
               <p style="width: 70%"><strike>{{ sub.PriceOff }}</strike></p>
               <p style="width: 30%">{{ sub.Price }}</p>
             </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <p v-if="this.geted===2" style="width: 100%;text-align: center;margin-top: 15%">
    {{ $t('Subscription.payable')}} : {{this.payPrice}}
  </p>
  <button v-if="this.geted===2" @click="this.goToInvoice()" class="buybtn" type="button" style="margin: 15% 4% 10% 4%;text-align: center;">
    {{ $t('Subscription.continuation')}}
  </button>
  <Footer :selected_num="3" />
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
import LoadingButton from '../components/LoadingButton.vue'
import { useToast } from "vue-toastification";
import 'gitart-vue-dialog/dist/style.css'
import { GDialog } from 'gitart-vue-dialog'
library.add(faWallet)
export default {

  name: "Subscription",

  components: {
    Loading,SideMenu,Header,SubHeader,Footer,FontAwesomeIcon,LoadingButton,GDialog
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
    goToInvoice(){
      localStorage.setItem('typeGl', 'subscription');
      localStorage.setItem('subRefGl', this.selected_ref.toString());
      localStorage.setItem('CourseRef', '0');
      localStorage.setItem('CourseRefGl', '0');
      console.log(localStorage.getItem('tk'));
      console.log("___");
      if(localStorage.getItem('tk')==="" || localStorage.getItem('tk')===null){
        this.loginDialog=true;
        return;
      }
      else{
        this.$router.push({ path: '/invoice'})
      }

    },
    getRow(){
      this.geted=1;
      const mydata = {
        action:'subscriptions',
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
              this.subs=response.data.data;
              this.sub_desc=response.data.sub_desc;
              this.geted=2;
              this.subs.forEach((item, i) => {
                if(i===0){
                  this.selected_ref=item.ID;
                  this.payPrice=item.Price;
                  if(this.payPrice<0){
                    this.payPrice=0;
                  }
                }
              });
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
      payPrice:"0",
      selected_ref:1,
      openMenu:false,
      formatter : new Intl.NumberFormat('en', {
        maximumFractionDigits:0,
      }),
      subs:[],
      sub_desc:"",
      loginDialog:false,
    }
  }
};

</script>
<style>
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
.active_card{
  box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
  color:white;
  background: linear-gradient(90deg, var(--va-basecolor) 0%, var(--va-seccolor) 35%);
}
.deactive_card{
  color:black;
  background: #eeeeee;
}

.filterbar{

  cursor: pointer;
  width: 500px;
  height:40px;
  border-radius: 20px;
  text-align: center;
  display: table-cell;
  vertical-align: middle;
  font-size: 13px
}
div.outer-div {
  width: 100%;
  height:35px;
  text-align: center;
}

div.middle-div {
  position: relative;
  top: 50%;
  text-align: center;
  width: 100%;
  padding: 10px;
  -webkit-transform: translateY(-50%);
  -ms-transform: translateY(-50%);
  transform: translateY(-50%);
}
</style>
