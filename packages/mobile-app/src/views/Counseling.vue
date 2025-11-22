<template>
  <Header  @headeropenMenu="this.homeOpenMenu()"  :isHome="0"/>
  <SideMenu :openMenu="this.openMenu" @headercloseMenu="this.headerCloseMenu()" :group_ref="0"/>
  <Loading v-if="this.geted===1" />
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

  <p style="text-align: center;margin: 5% 0 0 0">{{$t('Counselling.title')}}</p>
  <div  v-if="this.geted===2" class="mycard" style="margin:8% 4% 8% 4%;font-size:14px;padding:8px ;width: 92%;border-radius: 15px">
    <div v-html="this.counseling_desc"  style="line-height: 1.7;padding: 10px 0 10px 0">
    </div>
  </div>
  <hr style="margin: 0 4% 5% 4%" v-if="this.geted===2"/>

  <div v-for="item in this.list" :key="item.ID"  @click="this.doClick(item.ID,item.Price)" style="margin:4% 3% 4% 3%;width: 94%;cursor: pointer">
    <div  v-if="this.geted===2" class="mycard" :class="{ active_card: item.ID === this.selected_ref,deactive_card:item.ID !== this.selected_ref }" style="margin:0 0 0 0;padding:0 ;width: 100%;border-radius: 15px;">
      <div v-if="item.pic!=='' && item.pic!==null" style="text-align: center">
        <img :src="this.baseurl+'/images/course/'+item.pic" style="width:100%;border-top-right-radius: 20px;border-top-left-radius: 20px" />
      </div>
      <p style="text-align: center;padding-top: 2%;font-weight: bold">{{item.Name}}</p>
      <div v-html="item.Content" style="padding: 15px 15px 15px 15px;margin: 0;font-size: 14px;line-height: 1.4em">

      </div>
      <hr style="margin: 0 4% 0 4%;color:white"/>
      <div v-if="item.PriceIntOff===0" style="padding: 2% 4% 2% 4%;width: 100%;margin: 1% 0 0 0">
        <div class="row" style="font-size: 12px;color:white;text-align: left;display: block;margin-left: 1%"><span>{{item.Price}}</span></div>
      </div>
      <div v-else class="" style="padding: 10px 0 10px 15px;margin: 1% 0 0 0;text-align: left">
        <div style="margin: 0 5px 0 15px; font-size: 12px;color:#5d5d5d;display: block;margin-left: 1%"><strike>{{item.PriceOff}}</strike></div>
        <div style="margin: 0 5px 0 15px;font-size: 12px;color:white;display: block;margin-left: 1%"><span>{{item.Price}}</span></div>
      </div>

    </div>
  </div>
  <p v-if="this.geted===2" style="width: 100%;text-align: center;margin-top: 15%">
    {{$t('Counselling.payable')}} : {{this.payPrice}}
  </p>
  <button v-if="this.geted===2" @click="this.goToInvoice()" class="buybtn" type="button" style="margin: 15% 4% 10% 4%;text-align: center;">
    {{$t('Counselling.continuation')}}
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
import { faCaretDown} from '@fortawesome/free-solid-svg-icons'
import { } from '@fortawesome/free-regular-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import LoadingButton from '../components/LoadingButton.vue'
import { useToast } from "vue-toastification";
import 'gitart-vue-dialog/dist/style.css'
import { GDialog } from 'gitart-vue-dialog'
library.add(faCaretDown)
export default {

  name: "Counseling",

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
    doClick(id,price){
      console.log('aaaaaa');
      this.selected_ref=id;
      this.payPrice=price;
      window.scrollTo({
        top: 1500,
        left: 0,
        behavior: 'smooth'
      });
    },
    goToInvoice(){
      if(localStorage.getItem('tk')==="" || localStorage.getItem('tk')===null){
        this.loginDialog=true;
        return;
      }
      localStorage.setItem('typeGl', 'counseling');
      localStorage.setItem('subRefGl', '0');
      localStorage.setItem('CourseRef', '0');
      localStorage.setItem('CourseRefGl', '0');
      localStorage.setItem('CounselingRefGl', this.selected_ref.toString());
      this.$router.push({ path: '/invoice'})
    },
    getRow(){
      this.geted=1;
      const mydata = {
        action:'counseling',
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
              this.list=response.data.data;
              this.counseling_desc=response.data.counseling_desc;
              this.geted=2;
              this.list.forEach((item, i) => {
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
      loginDialog:false,
      geted:0,
      payPrice:"0",
      selected_ref:1,
      openMenu:false,
      formatter : new Intl.NumberFormat('en', {
        maximumFractionDigits:0,
      }),
      list:[],
      sub_desc:"",
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
  color:white;
  background: linear-gradient(90deg, var(--va-basecolor) 0%, var(--va-seccolor) 35%);
}
.deactive_card{
  color:black;
  background: #eeeeee;
}
.deactive_card span {
  color:black;
}

.filterbar{
  cursor: pointer;
  width: 500px;

  border-radius: 20px;
  text-align: center;
  display: table-cell;
  vertical-align: middle;
  font-size: 13px
}
div.outer-div {
  width: 100%;

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