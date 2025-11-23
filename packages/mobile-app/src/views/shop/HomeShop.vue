<template>

  <HeaderShop  @headeropenMenu="this.homeOpenMenu()"  :isHome="1"/>
  <SideMenu  :openMenu="this.openMenu" @headercloseMenu="this.headerCloseMenu()" :group_ref="0"/>
  <Loading v-if="this.geted===1 "/>
  <div v-if="this.geted===2 && this.home_pic!==''" class="container">
    <img style="width: 94%;margin: 25px 3% 0 3%;border-radius: 15px" :src="this.baseurl+'/images/shop/'+this.home_pic">
  </div>
  <div v-if="this.geted===2 && this.cats.length>0" class="row justify-space-between" style=" padding:30px 0 5px 0">
    <div class="flex md5 mr-3" style="font-size: 15px;text-align: right">دسته بندی محصولات</div>
    <div @click="this.goToPage('/shop/category')" class="flex md5 ml-3" style="font-size: 13px;text-align: left; ">
      <span style="background-color:var(--va-basecolor);color:white;padding: 5px 10px 5px 10px;border-radius: 15px;cursor: pointer">همه دسته ها
      <font-awesome-icon style="margin-right:5px;font-size: 11px " icon="fa-solid fa-angle-left" size="lg"  :style="{ color: 'white' }"/></span>
    </div>
  </div>
  <div v-if="this.geted===2 && this.cats.length>0" color="background-element" style="padding: 0.5rem;">
    <div class="myrow" style="text-align: center;">
      <div v-for="cat in this.cats" :key="cat.id"  @click="this.goToCat(cat.basecat,cat.cat,cat.subcat)" class="flex xs6 md4" >
        <div class="boxshop1" style="background: white;margin: 10px">
          <img v-if="cat.pic===''" src="/src/assets/images/nopic.png" style="height: 22px;max-width:22px;border-radius: 15px;margin-top: 3px; ">
          <img v-else :src="this.baseurl+'/images/shop/'+cat.pic" style="height: 65px;max-width:65px;border-radius: 15px;margin-top: 7px; ">
          <p style="color: black;font-size: 13px;margin-top: 5px ">{{cat.name}}</p>
        </div>
      </div>
    </div>
  </div>

  <div @click="goToProduct('special')" v-if="this.geted===2 && this.specials.length>0" class="row justify-space-between mb-3" style=" padding:30px 0 5px 0">
    <div class="flex md5 mr-3" style="font-size: 15px;text-align: right">پیشنهادات ویژه</div>
    <div class="flex md5 ml-3" style="font-size: 13px;text-align: left; ">
      <span style="background-color:var(--va-basecolor);color:white;padding: 5px 10px 5px 10px;border-radius: 15px;cursor: pointer">مشاهده همه
      <font-awesome-icon style="margin-right:5px;font-size: 11px " icon="fa-solid fa-angle-left" size="lg"  :style="{ color: 'white' }"/></span>
    </div>
  </div>

  <div v-if="this.geted===2 && this.specials.length>0" class="container">
    <div class="scrollrow" >
      <div class="card mycard_shop" style="height: 230px" v-for="special in this.specials" :key="special.ID"  @click="this.$router.push({ path: '/shop/detail/'+special.ID })">
        <img :src="this.baseurl+'/images/shop/'+special.Pic" style="height: 150px;border-radius: 15px">
        <p style="font-size: 12px;height: 23px;padding: 2px 2px 0 2px;font-weight: bold" class="card-text">{{special.Name}}</p>
        <span style="background-color: #ff6969;border-radius: 10px;color: white;padding: 2px 7px 2px 7px;font-size: 11px">{{special.cat_name}}</span>

        <div class="row" style="padding-right: 0">
          <div style="padding: 0;margin: 0;width: 100%">
            <div v-if="special.PriceOffInt===0" style="width: 100%;padding: 0;margin: 7px 0 0 7px">
              <p style="font-size: 12px;color:var(--va-greencolor);text-align: left;font-weight: bold;display: block;margin-left: 1%">{{special.Price}}</p>
            </div>
            <div v-else style="padding: 0;margin: 2px 0 0 2px">
              <p style="font-size: 12px;color:#5d5d5d;text-align: left;display: block;margin-left: 1px"><strike>{{special.PriceOff}}</strike></p>
              <p style="font-size: 12px;color:var(--va-greencolor);text-align: left;font-weight: bold; display: block;margin-left: 1px">{{special.Price}}</p>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
  <div @click="goToProduct('popular')" v-if="this.geted===2 && this.populars.length>0" class="row justify-space-between mb-3" style=" padding:30px 0 5px 0">
    <div class="flex md5 mr-3" style="font-size: 15px;text-align: right">محبوب ترین محصولات</div>
    <div class="flex md5 ml-3" style="font-size: 13px;text-align: left; ">
      <span style="background-color:var(--va-basecolor);color:white;padding: 5px 10px 5px 10px;border-radius: 15px;cursor: pointer">مشاهده همه
      <font-awesome-icon style="margin-right:5px;font-size: 11px " icon="fa-solid fa-angle-left" size="lg"  :style="{ color: 'white' }"/>
      </span>
    </div>
  </div>
  <div v-if="this.geted===2 && this.populars.length>0" class="container">
    <div class="scrollrow" >
      <div class="card mycard_shop" style="height: 230px" v-for="popular in this.populars" :key="popular.ID"  @click="this.$router.push({ path: '/shop/detail/'+popular.ID })">
        <img :src="this.baseurl+'/images/shop/'+popular.Pic" style="height: 150px;border-radius: 15px">
        <p style="font-size: 12px;height: 23px;padding: 2px 2px 0 2px;font-weight: bold" class="card-text">{{popular.Name}}</p>
        <span style="background-color: #ff6969;border-radius: 10px;color: white;padding: 2px 7px 2px 7px;font-size: 11px">{{ popular.cat_name }}</span>

        <div class="row" style="padding-right: 0">
          <div style="padding: 0;margin: 0;width: 100%">
            <div v-if="popular.PriceOffInt===0" style="width: 100%;padding: 0;margin: 7px 0 0 7px">
              <p style="font-size: 12px;color:var(--va-greencolor);text-align: left;font-weight: bold;display: block;margin-left: 1%">{{popular.Price}}</p>
            </div>
            <div v-else style="padding: 0;margin: 2px 0 0 2px">
              <p style="font-size: 12px;color:#5d5d5d;text-align: left;display: block;margin-left: 1px"><strike>{{popular.PriceOff}}</strike></p>
              <p style="font-size: 12px;color:var(--va-greencolor);text-align: left;font-weight: bold; display: block;margin-left: 1px">{{popular.Price}}</p>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>




  <FooterShop :selected_num="4" :total_basket="this.total_basket"/>
</template>

<script>
import { library } from '@fortawesome/fontawesome-svg-core'
import Loading from '../../components/Loading.vue'
import HeaderShop from './HeaderShop.vue'
import FooterShop from './FooterShop.vue'
import SubHeader from '../../components/SubHeader.vue'
import SideMenu from '../../components/SideMenu.vue'
import Rating from '../../components/Rating.vue'
import { faAngleLeft} from '@fortawesome/free-solid-svg-icons'
import {  } from '@fortawesome/free-regular-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

import {Autoplay, Navigation, Pagination, Scrollbar, A11y } from 'swiper';
import { Swiper, SwiperSlide } from 'swiper/vue';
import 'swiper/css';
import 'swiper/css/pagination';
import 'swiper/css/scrollbar';
import 'swiper/css/autoplay';
import { useToast } from "vue-toastification";
library.add(faAngleLeft)
import { Stories } from "vue-insta-stories";
export default {
  name: "ShopHome",
  setup() {
    return {
      modules: [Autoplay,Navigation, Pagination, Scrollbar, A11y ],
    };
  },
  components: {
    Loading,SideMenu,HeaderShop,SubHeader,FooterShop,FontAwesomeIcon,Swiper, SwiperSlide,Rating,Stories
  },
  mounted() {
    this.homeData();
    window.scrollTo(0,0);
    this.total_basket=localStorage.getItem('total_basket');
  },
  updated() {

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
    goToCat(basecat=0,cat=0,subcat=0){
      if(basecat>0 && cat>0 && subcat>0){
        this.$router.push({ path: '/shop/subcat/'+basecat+'/'+cat+'/'+subcat });
      }
      else if(basecat>0 && cat>0){
        this.$router.push({ path: '/shop/cat/'+basecat+'/'+cat+'/'+subcat });
      }
      else if(basecat>0){
        this.$router.push({path: '/shop/basecat/'+basecat+'/'+cat+'/'+subcat });
      }
      // this.loadData(basecat,cat,subcat)
    },
    goToPage(page,pageref){
      if(pageref>0){
        // console.log(pageref.toString());
        this.$router.push({ path: page ,query:{ pageref: pageref } });
      }
      else {
        this.$router.push({path: page});
      }
    },
    goToProduct(type){
      this.$router.push({ path: '/shop/products' ,query:{ type: type } });
    },
    myToast(alert){
      useToast().warning(alert, {
        timeout: 2000,
        position:'top-center',
        rtl: this.$t('config.dir')==='rtl'?true:false
      });
    },
    homeData(){

      this.geted=1;
      const mydata = {
        action:'homeShop',
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
              this.sliders=response.data.sliders;
              this.data=response.data.data;
              if(response.data.cats!==null){
                this.cats=response.data.cats;
              }
               if(response.data.populars!==null){
                this.populars=response.data.populars;
              }
              if(response.data.specials!==null){
                this.specials=response.data.specials;
              }
              this.geted=2;
              this.home_pic=response.data.home_pic;
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
  data(){
    return{
      geted:0,
      openMenu:false,
      formatter : new Intl.NumberFormat('en', {
        maximumFractionDigits:0,
      }),
      cats:[],
      specials:[],
      populars:[],
      total_basket:0,
      home_pic:"",
    }
  }
};

</script>
<style>

.boxshop1{
  text-align: center;
  height: 6.5rem;

  margin-bottom: 6px;
  margin-top: 6px;
  border-radius: 15px;
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
.mycard_shop {
  /* Add shadows to create the "card" effect */
  box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
  transition: 0.3s;
  border-radius: 15px;
  background-color: white;
}
div.scrollmenu a:hover {
  background-color: #777;
}
</style>