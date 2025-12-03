<template>
    <Header  @headeropenMenu="this.homeOpenMenu()" :isHome="0"/>
    <SideMenu :openMenu="this.openMenu" @headercloseMenu="this.headerCloseMenu()" :group_ref="0"/>


  <div class="row" v-if="this.geted===2 || this.geted_f===1">
    <p style="font-size: 13px;width: 50%;padding: 3% 2% 3% 0">دسته بندی چالش ها</p>
    <p style="font-size: 13px;width: 50%;text-align: left;padding: 3% 3% 3% 2%">
      <font-awesome-icon icon="fa-solid fa-caret-down" style="font-size: 0.75rem;padding-left: 4px"/>
    </p>
  </div>
  <div  v-if="this.geted===2 || this.geted_f===1" class="container" style="padding: 0">
    <div class="row" style="margin: 3% 3% 0 3%">
      <div  class="card" v-for="cat in data_cat" :key="cat.ID" :class="{ active_card: cat.ID === this.catref,deactive_card:cat.ID !== this.catref }" style="height: 150px;margin-left: 4%"  @click="this.change_filter(cat.ID)">
        <img :src="this.baseurl+'/images/cat/'+cat.Pic" style="height: 110px;border-radius: 10px 10px 0 0">
        <p style="font-size: 13px;height: 23px;text-align: center;padding-top: 5px" class="card-text">{{cat.Name}}</p>
      </div>
    </div>
  </div>
  <Loading v-if="this.geted===1 || this.geted_f===1"/>
  <div  v-else-if="this.geted===2 && this.data.length>0" style="margin: 0 3% 3% 3%">
    <div  v-for="challenge in data" :key="challenge.ID" @click="this.goToChallenge(challenge.ID)" class="mycard" style="height: 100px;width:100%;margin-top: 10px;cursor: pointer">
      <div class="row" style="padding: unset">
        <img :src="this.baseurl+'/images/course/'+challenge.Pic" style="height: 100px;border-radius: 15px;padding: 5px 5px 5px 5px;max-width:120px ">
        <div style="width:100%">
          <p style="height:55px;padding: 10px 2% 10px 0;font-size: 12px;color: #636363;font-weight: bold ">{{challenge.Name}}</p>
          <div class="row" style="height:20px;padding: 0 2% 0 0;font-size: 12px;color: #636363;">

          </div>
          <hr style="margin: 0 10px 0 10px"/>
          <p style="height:14px;padding: 7px 0 0 10px;font-size: 10px;color:#8a8a8a;text-align: left">{{challenge.Date}}</p>
        </div>
      </div>
    </div>
    </div>
  <div v-else-if="this.geted===2 && this.data.length===0">
   <div class="row" >
     <p style="width: 100%;text-align: center">
      <img style="height: 150px" src="../assets/notfound.png">
     </p>
   </div>
    <div class="row" style="width: 100%;text-align: center;">
      <p class="default" style="width: 100%;text-align: center">هیچ چالشی یافت نشد</p>
    </div>
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
import { } from '@fortawesome/free-solid-svg-icons'
import { } from '@fortawesome/free-regular-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

import {Autoplay, Navigation, Pagination, Scrollbar, A11y } from 'swiper';
import { Swiper, SwiperSlide } from 'swiper/vue';
// Import Swiper styles
import 'swiper/css';
// import 'swiper/css/navigation';
import 'swiper/css/pagination';
import 'swiper/css/scrollbar';
import 'swiper/css/autoplay';

library.add()
export default {
  name: "Challeng",
  components: {
    Loading,SideMenu,Header,SubHeader,Footer,FontAwesomeIcon
  },
  mounted() {
    this.getRow(0);
    window.scrollTo(0,0);
  },
  methods:{
    change_filter(cat){
      this.catref=cat;
      this.getRow(1);
    },
     goToChallenge(id){
      this.$router.push({ path: "/challenge/"+id })
    },

    getRow(is_filter){
      this.geted_f=is_filter;
      this.geted = 1;

      const mydata = {
        action:'challenge',
        cat_ref:this.catref,
        lang:this.$i18n.locale,
      };
      this.$http(
          {
            method: "post",
            url: this.apiurl,
            timeout: 1000 * 20, // Wait for 5 seconds
            data: mydata,
            headers: {
              "Content-Type": "application/json",
              "Authorization": `Bearer ${localStorage.getItem('tk')}`
            },
          })
          .then((response) => {
            this.geted_f=0;
            if(response.data.ok===1){
              if(response.data.data_cat!==null){
                this.data_cat=response.data.data_cat;
              }
              this.data=[];
              if(response.data.data!==null){
                 this.data=response.data.data;
              }
              this.geted=2;
            }
            else if(response.data.ok===3){
              localStorage.setItem('token', "");
              this.$router.push({ path: '/login' })
            }
            else{
              if(response.data.ok===4){
                localStorage.setItem('tk', "");
              }
              this.geted = 3;
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
            this.geted_f = 0;
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
    homeOpenMenu(){
      this.openMenu=true;
      console.log("homeOpenMenu");
    },
    headerCloseMenu(){
      this.openMenu=false;
      console.log("homeCloseMenu");
    },
    onSwiper(){
    },
    onSlideChange(){
    },
  },

  data(){
    return{
      geted:0,
      geted_f:0,
      openMenu:false,
      formatter : new Intl.NumberFormat('en', {
        maximumFractionDigits:0,
      }),
      data:[],
      data_cat:[],
      catref:0
    }
  }
};

</script>
<style>
.deactive_card {
  /* Add shadows to create the "card" effect */
  box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
  transition: 0.3s;
  border-radius: 10px;
  background-color: white;
}
.active_card {
  /* Add shadows to create the "card" effect */
  box-shadow: 0 4px 8px 0 rgba(238, 12, 12, 0.8);
  transition: 0.3s;
  border-radius: 10px;
  background-color: white;
}

.row{
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
.row::-webkit-scrollbar {
  display: none;
}
.card {
  /*float: left;*/
  max-width: 49%;
  margin-left: 2%;
  padding: 0;
  margin-bottom: 2rem;
  border: 0;
  flex-basis: 49%;
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
.active{
  background-color: var(--va-basecolor);
  color:white
}
.deactive{
  background-color: white;
  color:black
}
</style>
