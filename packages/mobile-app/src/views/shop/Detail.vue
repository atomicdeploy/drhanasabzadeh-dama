<template>

  <HeaderShop  @headeropenMenu="this.homeOpenMenu()"  :isHome="1"/>
  <SideMenu  :openMenu="this.openMenu" @headercloseMenu="this.headerCloseMenu()" :group_ref="0"/>
  <Loading v-if="this.geted===1 "/>
  <div  v-if="this.geted===2" style="margin: 3% 3% 0 3%">
    <div class="mycard" style="width:100%;margin: 5% 0 5% 0;padding: 0 0 3% 0;border-radius: 20px !important;">

<!--        <img :src="this.baseurl+'/images/shop/'+this.pic" style="width:100%;border-radius: 20px 15px 0 0 ">-->


      <swiper
          :autoHeight="true"
          style="width: 100%;padding:15px 2% 15px 2%;"
          :modules="modules"
          :slides-per-view="1"
          :space-between="50"
          navigation
          :autoplay="{delay: 4000}"
          :pagination="{ clickable: true}"
          @swiper="onSwiper"
        >
        <swiper-slide v-if="this.pic!=='' ">
          <img  style="width: 100%;border-radius:10px;"  :src="this.baseurl+'/images/shop/'+this.pic"  alt="Third slide">
        </swiper-slide>
        <swiper-slide v-if="this.pic2!=='' ">
          <img  style="width: 100%;border-radius:10px;"  :src="this.baseurl+'/images/shop/'+this.pic2"  alt="Third slide">
        </swiper-slide>
        <swiper-slide v-if="this.pic3!=='' ">
          <img  style="width: 100%;border-radius:10px;"  :src="this.baseurl+'/images/shop/'+this.pic3"  alt="Third slide">
        </swiper-slide>
        <swiper-slide v-if="this.pic4!=='' ">
          <img  style="width: 100%;border-radius:10px;"  :src="this.baseurl+'/images/shop/'+this.pic4"  alt="Third slide">
        </swiper-slide>
        <swiper-slide v-if="this.pic5!=='' ">
          <img  style="width: 100%;border-radius:10px;"  :src="this.baseurl+'/images/shop/'+this.pic5"  alt="Third slide">
        </swiper-slide>


      </swiper>
<!--      <div v-if="this.getedLink===2" style="width: 96%;height:1px;background-color: #d0d0d0;margin: 4% 2% 4% 2%"></div>-->
      <div class="row" style="padding: unset">
        <p style="font-size: 18px;font-weight:bold;padding: 4% 3% 10% 0;width: 88%">{{ this.name }}</p>

<!--        <font-awesome-icon v-if="this.changeFav===0" @click="this.setFav()" icon="fa-regular fa-bookmark" style="width: 10%;margin:3% 0 0 2%; color: red;font-size: 20px"/>-->
<!--        <font-awesome-icon v-else                 @click="this.setFav()" icon="fa-solid fa-bookmark" style="width: 10%;margin:3% 0 0 2%; color: red;font-size: 20px"/>-->
      </div>

      <div class="row align-content-start mb-5" style="margin: 0 3% 0 5%">
        <div v-if="this.getedCart===1 && this.amount===0" class="flex xs6 " type="number" style="align-items: center;justify-content: center;display: flex;font-size: 18px;font-weight: bold" >
          <va-progress-circle  size="small" indeterminate color="var(--va-basecolor)" thickness="0.15"  />
        </div>
        <div v-else-if="this.amount===0" @click="this.updateBasket('+')" class="row flex xs7 justify--space-around align-content--start" style="justify-content: right" >
          <div style="background-color: var(--va-basecolor);border-radius: 12px;color: white;flex: unset;padding: 5px 5px 8px 8px">
            <span style="font-size: 1rem"><font-awesome-icon icon="fa-solid fa-basket-shopping" style=" color: white;font-size: 1rem;position: relative;top:2px;margin-right: 5px;margin-left: 2px  "/>&nbsp;افزودن به سبد خرید</span>
          </div>

        </div>
        <div v-else class="row flex xs5 justify--space-around align-content--center" >
          <div class="flex xs3" @click="this.updateBasket('+')">
            <div style="width: 35px; height: 35px; border-radius: 20px;background-color: var(--va-basecolor);margin-right: 5%;align-items: center;justify-content: center;display: flex;font-size: 26px;color: white;padding-top: 5px">+</div>
          </div>

          <div v-if="this.getedCart===1" class="flex xs5 " type="number" style="align-items: center;justify-content: center;display: flex;font-size: 18px;font-weight: bold" >
            <va-progress-circle  size="small" indeterminate color="var(--va-basecolor)" thickness="0.15"  />
          </div>
          <div v-else class="flex xs5 " type="number" style="align-items: center;justify-content: center;display: flex;font-size: 18px;font-weight: bold" >{{this.amount}}</div>
          <div class="flex xs3" @click="this.updateBasket('-')">
            <div style="width: 35px; height: 35px; border-radius: 20px;background-color: var(--va-basecolor);margin-right: 5%;align-items: center;justify-content: center;display: flex;font-size: 26px;font-weight: bold;color: white;padding-top: 3px">-</div>
          </div>
        </div>
        <div v-if="this.amount>0" class="flex xs1"></div>
        <div  class="flex xs5 " style=" align-items: center;justify-content: left;display: flex" >
          <p v-if="this.price_off_int===0" style="text-align: left">
           {{this.price}}
         </p>
        <div v-else style="text-align: left">
          <div class="row flex justify--start">
            <div>
              <span style="font-size: 10px;color: white;background-color: #ff1552;padding: 3px 5px 2px 5px;border-radius: 10px">{{ this.discount }}</span>

            </div>
            <del style="text-decoration: line-through; color: #8d8c8c;flex: unset;margin-right: 3px">{{this.price_off}}</del>

          </div>

           <p style="margin-top: 6px;font-size: 18px;">{{this.price}}</p>
         </div>

        </div>
      </div>
      <div style="width: 96%;height:1px;background-color: #d0d0d0;margin: 4% 2% 6% 2%"></div>

<!--      <button v-else-if="this.can_buy===0 && this.needSubscription===0" class="compbtn" type="button">-->
<!--        <va-icon class="material-icons">local_mall</va-icon>-->
<!--        محصول موجودی ندارد-->
<!--      </button>-->
<!--      <button v-else-if="this.buyed===0 && this.needSubscription===0" @click="this.goToInvoice()" class="buybtn" type="button">-->
<!--        <va-icon class="material-icons">local_mall</va-icon>-->
<!--        خرید محصول-->
<!--      </button>-->
      <p style="width: 100%;padding: 3%;font-weight: bold;font-size: 15px">معرفی محصول</p>
      <div   v-html="this.comment" style="width: 100%;padding: 3%;  line-height: 1.6;">
      </div>
    </div>
  </div>
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
  <FooterShop :selected_num="4" :shop_amount="this.total_basket" />
</template>

<script>
import 'gitart-vue-dialog/dist/style.css'
import { GDialog } from 'gitart-vue-dialog'
import { library } from '@fortawesome/fontawesome-svg-core'
import Loading from '../../components/Loading.vue'
import HeaderShop from './HeaderShop.vue'
import FooterShop from './FooterShop.vue'
import SubHeader from '../../components/SubHeader.vue'
import SideMenu from '../../components/SideMenu.vue'
import Rating from '../../components/Rating.vue'
import { faAngleLeft,faBasketShopping} from '@fortawesome/free-solid-svg-icons'
import {  } from '@fortawesome/free-regular-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

import {Autoplay, Navigation, Pagination, Scrollbar, A11y } from 'swiper';
import { Swiper, SwiperSlide } from 'swiper/vue';
import 'swiper/css';
import 'swiper/css/pagination';
import 'swiper/css/scrollbar';
import 'swiper/css/autoplay';
import { useToast } from "vue-toastification";
library.add(faAngleLeft,faBasketShopping)
import { Stories } from "vue-insta-stories";
export default {
  name: "DetailShop",
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
    // if(this.$route.params.basecat!=null){
    //   this.basecat=this.$route.params.basecat;
    // }
    // if(this.$route.params.cat!=null){
    //   this.cat=this.$route.params.cat;
    // }
    // if(this.$route.params.subcat!=null){
    //   this.subcat=this.$route.params.subcat;
    // }
  },
  data(){
    return{
      loginDialog:false,
      geted:0,
      getedCart:0,
      openMenu:false,
      formatter : new Intl.NumberFormat('en', {
        maximumFractionDigits:0,
      }),
      id:"",
      name:"",
      price:"",
      price_off:"",
      price_off_int:0,
      comment:"",
      max_purchase:"",
      inventory:"",
      discount:"",
      pic:"",
      pic2:"",
      pic3:"",
      pic4:"",
      pic5:"",
      amount:0,
      total_basket:0,


    }
  },
  methods:{
    updateBasket(type){
      if(localStorage.getItem('tk')==='' || localStorage.getItem('tk')===null){
        this.loginDialog=true
        return;
      }
      if(this.getedCart===1){
        return;
      }
      var am=0;
      if(type==='+'){
        am=this.amount+1;
      }
      else if(this.amount>0){
        am=this.amount-1;
      }
      else{
        return;
      }
      this.getedCart=1;
      const mydata = {
        action:'updateBasket',
        ref:this.$route.params.id,
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
              this.getedCart=2;
              this.amount=response.data.amount;
              this.total_basket=response.data.total_basket;
              localStorage.setItem('total_basket', response.data.total_basket);
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
      this.$router.push({ path: '/shop/detail',query:{'id':id} });
    },
    myToast(alert){
      useToast().warning(alert, {
        timeout: 2000,
        position:'top-center',
        rtl: this.$t('config.dir')==='rtl'?true:false
      });
    },
    loadData(basecat=0,cat=0,subcat=0){

      this.geted=1;
      const mydata = {
        action:'detailShop',
        ref:this.$route.params.id,
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

              this.geted=2;
              this.name=response.data.name;
              this.price=response.data.price;
              this.price_off=response.data.price_off;
              this.price_off_int=response.data.price_off_int;
              this.comment=response.data.comment;
              this.max_purchase=response.data.max_purchase;
              this.inventory=response.data.inventory;
              this.discount=response.data.discount;
              this.amount=response.data.amount;
              console.log(response.data.pic2)
             if(response.data.pic!==""){
               this.pic=response.data.pic
             }if(response.data.pic2!==""){
                this.pic2=response.data.pic2
             } if(response.data.pic3!==""){
                this.pic3=response.data.pic3
             } if(response.data.pic4!==""){
                this.pic4=response.data.pic4
             } if(response.data.pic5!==""){
                this.pic5=response.data.pic5
             }
              console.log(this.imges)
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

};

</script>
<style>

.boxshop1{
  text-align: center;
  height: 6.5rem;

  margin-bottom: 6px;
  margin-top: 6px;
  border-radius: 10px;
  background-size: cover;
  cursor: pointer;
}
.box1{
  text-align: center;
  height: 6.5rem;
  width: 32%;
  margin-right: 2%;
  margin-left: 0;
  margin-bottom: 5px;
  border-radius: 10px;
  background-size: cover;
  cursor: pointer;
}
.awesome{
  margin: 15px 0 15px 0;
  font-size: 2.5rem;
}

.scrollrow{
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
.myrow{
  justify-content: space-around;
  padding:0 1% 0 1%;
  align-items: center;
  display: flex;
  flex-direction: row;
  flex-wrap: wrap;

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


.card {
  /*float: left;*/
  max-width: 49%;
  margin-left: 2%;
  padding: 0.3rem;
  margin-bottom: 2rem;
  border: 0;
  flex-grow: 0;
  flex-shrink: 0;
}

.card > img {
  margin-bottom: .01rem;
  width: 100%;
}

.card-text {
  font-size: 85%;
}

div.scrollmenu {
  overflow: auto;
  white-space: nowrap;
  -ms-overflow-style: none;  /* IE and Edge */
  scrollbar-width: none;  /* Firefox */
}
.scrollmenu::-webkit-scrollbar {
  display: none;
}

div.scrollmenu a:hover {
  background-color: #777;
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
.buybtncounter{
  width: 40%;
  text-align: center;
  margin-top: 3px;
  height: 45px;
  background-color: var(--va-greencolor);
  color:white;
  border-radius: 10px;
  border:unset;
  cursor: pointer;
}
.va-input-wrapper__field{
  margin-left: 10px;
}
</style>