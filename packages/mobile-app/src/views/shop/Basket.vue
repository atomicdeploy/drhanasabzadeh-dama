<template>

  <HeaderShop  @headeropenMenu="this.homeOpenMenu()"  :isHome="1"/>
  <SideMenu  :openMenu="this.openMenu" @headercloseMenu="this.headerCloseMenu()" :group_ref="0"/>
  <GDialog v-model="this.loginDialog" max-width="500" >
    <div class="wrapper" style="">
      <div class="content">
        <div style="width: 100%;text-align: center">
          <img style="width:85px " src="../../assets/images/needlogin.png">
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
  <Loading v-if="this.geted===1 "/>
  <div v-if="this.geted===2 && this.firstLoad===0 && this.list.length!==0 && this.list_count!==0" class="row justify--space-between" style=" padding:30px 0 0 0">
    <div class="flex md5 mr-3" style="font-size: 15px;text-align: right">سبد خرید</div>
  </div>
  <div v-if="this.firstLoad===0 && (this.list.length===0 || this.list_count===0)">
    <div style="width: 100%;text-align: center;margin-top: 10%">
      <img style="height: 150px" src="../../assets/notfound.png">
    </div>
    <p class="default" style="width: 100%;text-align: center;padding-bottom: 10%">سبد خرید شما خالی است</p>
  </div>
  <div  v-if="this.geted===2 && this.list.length>0" style="margin: 2% 3% 60px 3%">
    <div v-for="item in list" :key="item.id">
      <div   v-if="item.show_item===1"  class="mycard" style="height: 130px;width:100%;margin-top: 10px;margin-bottom:0.5rem;cursor: pointer">
        <div class="rowshop" style="padding: unset">
          <div style="width: 37%; display: flex; justify-content: center; align-items: center;">
            <img :src="this.baseurl+'/images/shop/'+item.pic" style="height: 100px;border-radius: 15px;padding: 5px 5px 5px 5px;max-width:200px ">
          </div>
          <div style="width:63%">
            <p style="height:45px;padding: 20px 2% 10px 0;font-size: 14px;color: var(--va-basecolor);font-weight: bold ">{{item.name}}</p>

            <!--          <div class="rowshop" style="padding-right: 0;margin: 18px 0 0 0">-->
            <!--            <div v-if="item.price_off_int>0" style="width: 45%;margin-right: 2%">-->
            <!--              <span style="font-size: 10px;color: white;background-color: #ff4977;padding: 3px 5px 2px 5px;border-radius: 10px">{{ item.discount }}</span>-->
            <!--            </div>-->
            <!--            <div v-if="item.price_off_int===0" style="width: 100%;padding: 0;margin: 1% 0 0 2%">-->
            <!--              <div class="rowshop" style="font-size: 14px;color:var(&#45;&#45;va-greencolor);font-weight:bold;text-align: left;display: block;margin-left: 1%">{{item.price}}</div>-->
            <!--            </div>-->
            <!--            <div v-else style="width: 53%;padding: 0;margin: 1% 0 0 2%">-->
            <!--              <div class="rowshop" style="font-size: 13px;color:#727272;text-align: left;display: block;margin-left: 1%"><strike>{{item.price_off}}</strike></div>-->
            <!--              <div class="rowshop" style="font-size: 14px;color:var(&#45;&#45;va-greencolor);text-align: left;font-weight:bold;display: block;margin-left: 1%">{{item.price}}</div>-->
            <!--            </div>-->
            <!--          </div>-->


            <div class="row align-content-start mb-1" style="margin: 0 0 0 5%">
              <div   class="row flex xs6 justify--space-around align-content--center" >
                <div class="flex xs3" @click="this.updateBasket('+',item)">
                  <div style="width: 25px; height: 25px; border-radius: 20px;background-color: var(--va-basecolor);margin-right: 5%;align-items: center;justify-content: center;display: flex;font-size: 26px;color: white;padding-top: 5px">+</div>
                </div>

                <div v-if="item.geted===1" class="flex xs3 " type="number" style="align-items: center;justify-content: center;display: flex;font-size: 18px;font-weight: bold" >
                  <va-progress-circle  size="small" indeterminate color="var(--va-basecolor)" thickness="0.15"  />
                </div>
                <div v-else class="flex xs3 " type="number" style="align-items: center;justify-content: center;display: flex;font-size: 16px;font-weight: bold" >{{item.amount}}</div>

                <div class="flex xs3" @click="this.updateBasket('-',item)">
                  <div v-if="item.amount>1" style="width: 25px; height: 25px; border-radius: 20px;background-color: var(--va-basecolor);margin-right: 5%;align-items: center;justify-content: center;display: flex;font-size: 26px;font-weight: bold;color: white;padding-top: 4px">
                    <span>-</span>
                  </div>
                  <font-awesome-icon v-else icon="fa-regular fa-trash-can" style="font-size: 1.3rem;margin-top: 1px;color: red"/>

                </div>
              </div>
              <div class="flex xs1"></div>
            </div>
            <div class="row" style="justify-content: end;margin-left: 1.2rem;">
              <p v-if="item.price_off_int===0" style="text-align: left">
                {{item.price}}
              </p>
              <div v-else style="text-align: left">
                <div class="row flex justify--start">
                  <div>
                    <span style="font-size: 10px;color: white;background-color: #ff1552;padding: 3px 5px 2px 5px;border-radius: 10px">{{ item.discount }}</span>
                  </div>
                  <del style="text-decoration: line-through; color: #8d8c8c;flex: unset;margin-right: 3px">{{item.price_off}}</del>

                </div>

                <p style="margin-top: 6px;font-size: 18px;">{{item.price}} تومان</p>
              </div>


            </div>
          </div>
        </div>
      </div>

    </div>
   </div>

  <FooterShop :selected_num="2" :total_basket="this.total_basket"/>
  <div class="footer_basket row" style="background-color: white">
      <div class="flex xs6">
        <div @click="this.$router.push({ path: '/shop/invoice'})" style="align-items:center;justify-content:center;display: flex;margin-top: 8px;cursor: pointer">
          <p style="background-color: #E6113D;border-radius: 10px;text-align: center;padding: 10px">ادامه فرایند خرید</p>
        </div>
      </div>
      <div class="flex xs6" style="align-items:center;justify-content:center;text-align: left;padding-left: 25px;margin-top: 8px">
        <p style="color: #5d5d5d;font-size: 14px;margin-top: 3px;margin-bottom: 3px">جمع سبد خرید</p>
        <p style="font-size: 16px;color: #5d5d5d;font-weight: bold">{{this.total_price}}</p>
      </div>
  </div>
</template>

<script>
import { library } from '@fortawesome/fontawesome-svg-core'
import Loading from '../../components/Loading.vue'
import HeaderShop from './HeaderShop.vue'
import FooterShop from './FooterShop.vue'
import SubHeader from '../../components/SubHeader.vue'
import SideMenu from '../../components/SideMenu.vue'
import Rating from '../../components/Rating.vue'
import { faAngleLeft,faTrash} from '@fortawesome/free-solid-svg-icons'
import { faTrashCan } from '@fortawesome/free-regular-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

import {Autoplay, Navigation, Pagination, Scrollbar, A11y } from 'swiper';
import { Swiper, SwiperSlide } from 'swiper/vue';
import 'swiper/css';
import 'swiper/css/pagination';
import 'swiper/css/scrollbar';
import 'swiper/css/autoplay';
import { useToast } from "vue-toastification";
import 'gitart-vue-dialog/dist/style.css'
import { GDialog } from 'gitart-vue-dialog'
library.add(faAngleLeft,faTrash,faTrashCan)
import { Stories } from "vue-insta-stories";
export default {
  name: "BasketShop",
  setup() {
    return {
      modules: [Autoplay,Navigation, Pagination, Scrollbar, A11y ],
    };
  },
  components: {
    Loading,SideMenu,HeaderShop,SubHeader,FooterShop,FontAwesomeIcon,Swiper, SwiperSlide,Rating,Stories,GDialog
  },
  mounted() {
    this.loadData();
    window.scrollTo(0,0);
    this.total_basket=localStorage.getItem('total_basket');
  },
  methods:{
    inviteFriend(){
      this.$emit("headercloseMenu");
      let self = this;
      if (navigator.share){
        navigator.share({
          title: self.title,
          text: self.description,
        })
      }
    },
    goToPage(id){
      this.$router.push({ path: '/shop/detail/'+id });
    },
    myToast(alert){
      useToast().warning(alert, {
        timeout: 2000,
        position:'top-center',
        rtl: this.$t('config.dir')==='rtl'?true:false
      });
    },
    updateBasket(type,item){
      if(localStorage.getItem('tk')==="" || localStorage.getItem('tk')===null){
        this.loginDialog=true;
        return
      }

      console.log(this.list);
      if(this.list[item.i].geted===1){
        return;
      }
      var am=0;
      if(type==='+'){
        am=this.list[item.i].amount+1;
      }
      else if(this.list[item.i].amount>0){
        am=this.list[item.i].amount-1;
      }
      else{
        return;
      }
      this.list[item.i].geted=1;
      const mydata = {
        action:'updateBasket',
        ref:this.list[item.i].product_ref,
        amount:am,
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
              this.list[item.i].geted=0;
              this.list[item.i].amount=response.data.amount;
              this.total_basket=response.data.total_basket;
              this.total_price=response.data.total_price;
              localStorage.setItem('total_basket', response.data.total_basket);
              if(response.data.amount===0){
                this.list[item.i].show_item=0;
                this.list_count--;
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
              this.list[item.i].geted=0;
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
            this.list[item.i].geted=0;
            if(error.response.status===401){
              // localStorage.setItem('token', "");
              this.$router.push({ path: '/login' })
            }
            else {
              if (error.code === 'ECONNABORTED') {
                this.errTitle = this.$t('General.receivingError');
                this.errMsg = this.$t('General.tryAgain');
                // timed out
              } else {
                this.errTitle = this.$t('General.error');
                this.errMsg = error.message;
              }
            }
          });
    },
    loadData(basecat=0,cat=0,subcat=0){
      if(localStorage.getItem('tk')==="" || localStorage.getItem('tk')===null){
        this.loginDialog=true
        return;
      }
      this.geted=1;

      const mydata = {
        action:'basketShop',
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
            this.firstLoad=0;
            if(response.data.ok===1 || response.data.ok===0){
              if(response.data.list!==null){
                this.list=response.data.list;
                this.total_price=response.data.total_price;
                this.list_count=this.list.length;
                if(this.list_count===0){
                  localStorage.setItem('total_basket',0);
                  this.total_basket=0;
                }
              }
              else{
                localStorage.setItem('total_basket',0);
                this.total_basket=0;
              }
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
              this.myToast(response.data.msg);

            }
          })
          .catch(error => {
            this.geted = 3;
            if(error.response.status===401){
              // localStorage.setItem('token', "");
              this.$router.push({ path: '/login' })
            }
            else {

              if (error.code === 'ECONNABORTED') {
                this.errTitle = this.$t('General.receivingError');
                this.errMsg = this.$t('General.tryAgain');
                // timed out
              } else {
                this.errTitle = this.$t('General.error');
                this.errMsg = error.message;
              }
            }
          });

    },
    slider_click(v){
      console.log(v)
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
      loginDialog:false,
      geted:0,
      openMenu:false,
      formatter : new Intl.NumberFormat('en', {
        maximumFractionDigits:0,
      }),
      list:[],
      total_basket:0,
      total_price:"...",
      firstLoad:1,
      list_count:1
    }
  }
};

</script>
<style>

.awesome{
  margin: 15px 0 15px 0;
  font-size: 2.5rem;
}
.row::-webkit-scrollbar {
  display: none;
}


.rowshop{
  padding:0 2% 0 2%;
  align-items: stretch;
  display: flex;
  flex-direction: row;
  flex-wrap: nowrap;
  overflow-x: auto;
  overflow-y: hidden;
  -ms-overflow-style: none;  /* IE and Edge */
  scrollbar-width: none;  /* Firefox */
}
.rowshop::-webkit-scrollbar {
  display: none;
}
.footer_basket {
  background-color: white;
  margin: 0 0 0 0;
  position: fixed;
  bottom: 60px;
  height: 55px;
  /*width: 100%;*/
  /*max-width: 540px;*/
  color: white;
  /*text-align: center;*/
  /*height: 100px;*/
  width: 100% !important;
  max-width: 540px !important;
  right: unset !important;
  left: unset !important;
}
</style>