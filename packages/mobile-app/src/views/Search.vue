<template>
    <Header  @headeropenMenu="this.homeOpenMenu()" :isHome="0"/>
    <SideMenu :openMenu="this.openMenu" @headercloseMenu="this.headerCloseMenu()" :group_ref="0"/>


  <div class="row divserach">

   <input class="searchinput" v-model="this.searchtext"  v-on:keyup="this.tout($event)" type="text"  :placeholder="this.$t('Search.partName')"/>
    <font-awesome-icon icon="fa-solid fa-magnifying-glass" style="text-align: center;padding-top: 5px" />
  </div>

  <Loading v-if="this.geted===1" />
  <div  v-if="this.geted===2 && this.data.length>0" style="margin: 0 3% 3% 3%">
      <div  v-for="course in data" :key="course.ID" @click="this.goToMeets(course.ID)" class="mycard" style="height: 100px;width:100%;margin-top: 10px;cursor: pointer">
        <div class="row" style="padding: unset">
          <img :src="this.baseurl+'/images/course/'+course.Pic" style="height: 100px;border-radius: 15px;padding: 5px 5px 5px 5px;max-width:120px ">
          <div style="width:100%">
            <p style="height:44px;padding: 10px 2% 10px 2%;font-size: 12px;color: var(--va-basecolor);font-weight: bold ">{{course.Name}}</p>
            <div class="row"  style="padding: unset;margin-left: 2%">
                <font-awesome-icon icon="fa-regular fa-clock" style="font-size: 0.75rem;margin:0 2% 0 2%;color: #5d5d5d"/>
                <span style="font-size: 12px;color:#5d5d5d;width: 28%;margin-top: 1px">{{ course.MeetCount }}</span>
                <font-awesome-icon icon="fa-solid fa-chart-column" style="font-size: 0.75rem;color: #5d5d5d;margin-left: 2%;"/>
                <span style="font-size: 12px;color:#5d5d5d;width: 30%;margin-top: 1px">{{course.Participants}}</span>
                <Rating :size="'0.55rem'" :rate="5" style="margin-left: 2%"/>
            </div>
            <div class="row" style="padding-right: 0;margin: 10px 0 0 0">
              <div style="width: 60%;margin-right: 2%">
                <span style="font-size: 12px;color: #5d5d5d"> {{ course.Teacher }}</span>
              </div>
              <div v-if="course.PriceOffInt===0" style="width: 40%;padding: 0;margin: 1% 0 0 0">
                <div class="row" style="font-size: 12px;color:var(--va-greencolor);text-align: left;display: block;margin-left: 1%">{{course.Price}}</div>
              </div>
              <div v-else style="width: 40%;padding: 0;margin: 1% 0 0 0">
                <div class="row" style="font-size: 12px;color:#5d5d5d;text-align: left;display: block;margin-left: 1%"><strike>{{course.PriceOff}}</strike></div>
                <div class="row" style="font-size: 12px;color:var(--va-greencolor);text-align: left;display: block;margin-left: 1%">{{course.Price}}</div>
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
      <p class="default" style="width: 100%;text-align: center">{{$t('Search.noCourses')}}</p>
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

library.add(faBars,faBell,faBookOpenReader,faTv,faUserGroup,faComments,faCircleCheck,faUser,faEye,faCaretDown,faClock,faChartColumn)
export default {
  name: "Search",
  components: {
    Loading,SideMenu,Header,SubHeader,Footer,FontAwesomeIcon,Swiper, SwiperSlide,Rating
  },
  mounted() {
    this.getRow("");
    window.scrollTo(0,0);
  },
  methods:{
    tout(event){
      clearTimeout(this.timeOut);
      this.timeOut = setTimeout(()=>{
        this.filtered(this.searchtext);
      }, 1000)
    },
    filtered(newtext){
      console.log(newtext);
      // this.blogs=[];
      // if(newcat>0){
      //   this.catref=newcat
      // }
      // else if(newcat===-1){
      //   this.catref=0;
      // }
      this.getRow(newtext);
    },
    goToMeets(id){
      this.$router.push({ path: "/meets/"+id })
    },

    getRow(stext){
      this.data=[];
      this.geted=1;
      const mydata = {
        action:'courses',
        lang:this.$i18n.locale,
      };
      if(stext!==""){
        mydata.search=stext.toString();
      }
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
              this.data=[];
               if(response.data.data!==null){
                 this.data=response.data.data;
              }


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
      catref:0,
      openMenu:false,
      formatter : new Intl.NumberFormat('en', {
        maximumFractionDigits:0,
      }),
      data:[],
      data_cat:[],
      filter:1,
      searchtext:"",
      timeOut:null,
    }
  }
};

</script>
<style>


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
textarea:focus, input:focus{
  outline: none;
}
.searchinput{
  border-color: inherit;
  -webkit-box-shadow: none;
  box-shadow: none;
  border-left: unset;
  border-top: unset;
  border-right: unset;
  border-bottom: unset;
  width: 94%;
  outline: none;
  font-size: 14px
}.divserach{
   width: 94%;
   margin: 3% 3% 3% 3%;
   border-left: unset;
   border-top: unset;
   border-right: unset;
   border-bottom: 1px red solid;
   background-color: white;
   height: 33px;
}
</style>
