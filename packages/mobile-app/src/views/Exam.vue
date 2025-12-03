<template>
    <Header  @headeropenMenu="this.homeOpenMenu()" :isHome="0"/>
    <SideMenu :openMenu="this.openMenu" @headercloseMenu="this.headerCloseMenu()" :group_ref="0"/>

  <Loading v-if="this.geted===1 " style="margin-top: 100px" />
    <div v-else-if="this.geted===2">
      <div style="width: 100%;justify-content: center;text-align: center">
        <img src="../assets/images/exam.png" style="height: 200px;margin-top: 30px">
      </div>

      <div  class="mycard" style="height:auto;margin:8% 4% 8% 4%;font-size:14px;padding:8px ;width: 92%;border-radius: 15px">
        <div  style="padding: 0;margin: 0">
              <div  style="line-height: 1.7;width: 100%;text-align: center;justify-content: center;margin-bottom: 15px;color: var(--va-basecolor);font-weight: bold">
                 {{this.name}}
              </div>
              <div class="row" style="justify-content: space-between;margin-bottom: 10px  ">
                <div class="col">
                  <font-awesome-icon class="awesome" icon="fa-circle-question"  :style="{ color: this.basecolor,position:'relative',top:'2px' }"/>
                  <span style="margin-right: 5px">تعداد سوالات:</span>
                  <span style="margin-right: 5px">{{this.qusetion_count}} سوال</span>
                </div>
<!--                <div class="col" >-->
<!--                  <font-awesome-icon class="awesome" icon="fa-clock"  :style="{ color: this.basecolor,position:'relative',top:'2px' }"/>-->
<!--                  <span style="margin-right: 5px">زمان پاسخگویی:</span>-->
<!--                  <span style="margin-right: 5px">{{this.qusetion_count}} دقیقه</span>-->
<!--                </div>-->
              </div>
              <div v-if="this.comment!==''"  style="line-height: 1.7;width: 100% ;direction: rtl;margin: 20px 0 0 0">
                <pre style="padding: 10px">{{this.comment}}</pre>
              </div>

        </div>
      </div>
      <div v-if="this.done===1 && this.exam_type===1"  class="row" style="background-color: #b4ffce;border-radius: 15px;margin: 20px">
        <p style="padding: 10px;width: 100%;text-align: center">شما قبلا در این نظرسنجی شرکت کرده اید</p>
      </div>
      <div class="row">
        <button v-if="this.done===0 || this.exam_type===0" @click="this.goToQuestion()" class="buybtn" type="button" >
          <span v-if="this.done===0 && this.exam_type===0" style="width: 20px;height: 20px">
            <font-awesome-icon  icon="fa-circle-question" size="large" :style="{ color: white,margin:'0 4px 0 4px',position:'relative',top:'2px' }"/>شروع </span>
          <span v-else-if="this.done===0 && this.exam_type===1" style="width: 20px;height: 20px">
            <font-awesome-icon  icon="fa-circle-question" size="large" :style="{ color: white,margin:'0 4px 0 4px',position:'relative',top:'2px' }"/>شروع </span>
          <span v-else-if="this.exam_type===0" style="width: 20px;height: 20px">
            <font-awesome-icon  icon="fa-circle-question" size="large" :style="{ color: white,margin:'0 4px 0 4px',position:'relative',top:'2px' }"/>نتیجه </span>
        </button>
        <button @click="this.$router.back()" class="cancelbtn" type="button" >
          <span style="font-size: 22px;position: relative;top:2px;margin-left: 2px">⨯</span>
          <span style="width: 20px;height: 20px">بازگشت</span>

        </button>


      </div>
    </div>

  <div v-else-if="this.geted===2 && this.data.length===0">
   <div class="row" >
     <p style="width: 100%;text-align: center">
      <img style="height: 150px" src="../assets/notfound.png">
     </p>
   </div>
    <div class="row" style="width: 100%;text-align: center;">
      <p class="default" style="width: 100%;text-align: center"> یافت نشد</p>
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
import {faCircleQuestion,faClock } from '@fortawesome/free-solid-svg-icons'
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

library.add(faCircleQuestion,faClock)
export default {
  name: "Exam",
  components: {
    Loading,SideMenu,Header,SubHeader,Footer,FontAwesomeIcon
  },
  mounted() {
    this.exam_ref=this.$route.params.id;
    this.getRow();
    window.scrollTo(0,0);

  },
  methods:{
    goToQuestion(){
      this.$router.push({ path: "/exam_q/"+this.exam_ref })
    },
    getRow(){
      this.geted = 1;
      const mydata = {
        action:'examDetail',
        exam_ref:this.exam_ref,
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
            if(response.data.ok===1){
              this.name=response.data.name;
              this.alias=response.data.alias;
              this.qusetion_count=response.data.qusetion_count;
              this.comment=response.data.comment;
              this.done=response.data.done;
              this.exam_type=response.data.exam_type;
              this.geted=2;
            }
            else if(response.data.ok===3){
              localStorage.setItem('token', "");
              this.$router.push({ path: '/login' })
            }
            else{
              this.geted = 3;
              this.$swal({
                title: 'خطا !',
                text: response.data.msg,
                icon: 'error',
                confirmButtonText:'قبول',
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
                this.errTitle = "خطا در دریافت اطلاعات";
                this.errMsg = "مجددا تلاش کنید";
                // timed out
              } else {
                this.errTitle = "خطا";
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
      openMenu:false,
      formatter : new Intl.NumberFormat('en', {
        maximumFractionDigits:0,
      }),
      data:[],
      exam_ref:0,
      name:"",
      alias:"",
      comment:"",
      qusetion_count:0,
      done:0,
      exam_type:0,
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
.cancelbtn{
  width: 92%;
  text-align: center;
  margin:3%;
  height: 45px;
  background-color: #ff6f6f;
  color:white;
  border-radius: 10px;
  border:unset;
  cursor: pointer;
}
</style>
