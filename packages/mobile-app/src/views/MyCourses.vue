<template>
    <Header  @headeropenMenu="this.homeOpenMenu()" :isHome="0"/>
    <SideMenu :openMenu="this.openMenu" @headercloseMenu="this.headerCloseMenu()" :group_ref="0"/>


  <div class="row" v-if="this.geted===2 || this.geted_f===1">
    <p style="font-size: 13px;width: 50%;padding: 3% 2% 3% 0">دوره های من</p>
    <p style="font-size: 13px;width: 50%;text-align: left;padding: 3% 3% 3% 2%">
      <font-awesome-icon icon="fa-solid fa-caret-down" style="font-size: 0.75rem;padding-left: 4px"/>
    </p>
  </div>

  <Loading v-if="this.geted===1 || this.geted_f===1" />
  <div  v-if="this.geted===2 && this.data.length>0" style="margin: 0 3% 3% 3%">
      <div  v-for="course in data" :key="course.ID" @click="this.goToMeets(course.ID)" class="mycard" style="height: 100px;width:100%;margin-top: 10px;cursor: pointer">
        <div class="row" style="padding: unset">
          <img :src="this.baseurl+'/images/course/'+course.Pic" style="height: 100px;border-radius: 15px;padding: 5px 5px 5px 5px;max-width:120px ">
          <div style="width:100%">
            <p style="height:44px;padding: 10px 2% 10px 0;font-size: 12px;color: var(--va-basecolor);font-weight: bold ">{{course.Name}}</p>
            <div class="row"  style="padding: unset;margin-left: 2%">
                <font-awesome-icon icon="fa-regular fa-clock" style="font-size: 0.75rem;margin:0 2% 0 2%;color: #5d5d5d"/>
                <span style="font-size: 12px;color:#5d5d5d;width: 28%;margin-top: 1px">{{ course.MeetCount }}</span>
                <font-awesome-icon icon="fa-solid fa-chart-column" style="font-size: 0.75rem;color: #5d5d5d;margin-left: 2%;"/>
                <span style="font-size: 12px;color:#5d5d5d;width: 30%;margin-top: 1px">{{course.Participants}}</span>
                <Rating :size="'0.55rem'" :rate="5" style="margin-left: 2%"/>
            </div>
            <div class="row" style="padding-right: 0;margin: 10px 0 0 0">
              <div style="width: 60%;margin-right: 2%">
                <span style="font-size: 12px;color: #5d5d5d">مدرس: {{ course.Teacher }}</span>
              </div>
            </div>
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
      <p class="default" style="width: 100%;text-align: center">شما تاکنون هیچ دوره ای خریداری نکرده اید</p>
    </div>
    <p class="default" style="width: 100%;text-align: center;margin: 20px 0 10px 0;font-size: 12px">شما با شماره زیر وارد اپلیکیشن شده اید</p>
    <p class="default" style="width: 100%;text-align: center">{{ this.mobile }}</p>
  </div>
  <Footer :selected_num="5" />
</template>

<script>
import { library } from '@fortawesome/fontawesome-svg-core'
import Loading from '../components/Loading.vue'
import Header from '../components/Header.vue'
import Footer from '../components/Footer.vue'
import SubHeader from '../components/SubHeader.vue'
import SideMenu from '../components/SideMenu.vue'
import Rating from '../components/Rating.vue'
import { faBars,faBookOpenReader,faTv,faUserGroup,faCaretDown,faChartColumn} from '@fortawesome/free-solid-svg-icons'
import { faBell,faComments,faCircleCheck,faUser,faEye,faClock } from '@fortawesome/free-regular-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

import {Autoplay, Navigation, Pagination, Scrollbar, A11y } from 'swiper';
import { Swiper, SwiperSlide } from 'swiper/vue';
// Import Swiper styles
import 'swiper/css';
// import 'swiper/css/navigation';
import 'swiper/css/pagination';
import 'swiper/css/scrollbar';
import 'swiper/css/autoplay';
import {mapWritableState} from 'pinia';
import {useTempStroe} from '@/stores/tempStore';
library.add(faBars,faBell,faBookOpenReader,faTv,faUserGroup,faComments,faCircleCheck,faUser,faEye,faCaretDown,faClock,faChartColumn)
export default {
  name: "MyCourses",
  computed: {
    ...mapWritableState(useTempStroe, ["selected_num"])
  },
  components: {
    Loading,SideMenu,Header,SubHeader,Footer,FontAwesomeIcon,Swiper, SwiperSlide,Rating
  },
  mounted() {
    this.selected_num=5
    this.getRow(0);
    window.scrollTo(0,0);
  },
  methods:{
    goToMeets(id){
      this.$router.push({ path: "/meets/"+id })
    },
    change_filter(type,cat){
      if(type===0){
        this.catref=cat;
      }
      else{
        this.filter=type;
      }
      if(type===1){ // all
        this.filter=1;
        this.catref=0;
      }
      this.getRow(1);
    },
    getRow(is_filter){
      this.geted=1;
      this.geted_f=is_filter;
      const mydata = {
        action:'courses',
        isMyCourse:1,
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
            this.geted_f=0;
            if(response.data.ok===1){
              this.data=[];
              if(response.data.data_cat!==null){
                this.data_cat=response.data.data_cat;
              }
               if(response.data.data!==null){
                 this.data=response.data.data;

              }
              this.mobile=response.data.mobile;

              // this.blogs=response.data.blogs;
              // this.teaser=response.data.teaser;
              // this.teaser_pic=response.data.teaser_pic;
              // var token = localStorage.getItem('access_token');
              // localStorage.removeItem('access_token');

              this.geted=2;
            }
            else if(response.data.ok===3){
              // localStorage.setItem('token', "");
              // this.$router.push({ path: '/login' })
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
      catref:0,
      openMenu:false,
      formatter : new Intl.NumberFormat('en', {
        maximumFractionDigits:0,
      }),
      data:[],
      data_cat:[],
      filter:1,
      mobile:"",
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
.filterbar{
  cursor: pointer;
  width: 25%;
  height:40px;
  border-radius: 25px;
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
  -webkit-transform: translateY(-50%);
  -ms-transform: translateY(-50%);
  transform: translateY(-50%);
}
</style>
