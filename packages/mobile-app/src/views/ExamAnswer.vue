<template>
    <Header  @headeropenMenu="this.homeOpenMenu()" :isHome="0"/>
    <SideMenu :openMenu="this.openMenu" @headercloseMenu="this.headerCloseMenu()" :group_ref="0"/>
  <div v-if="this.show_result===1 && this.exam_type===1">
    <div class="row">
      <p style="width: 100%;text-align: center">
        <img style="height: 170px;padding-top:25px;" src="../assets/images/okorder.png">
      </p>
    </div>
    <div  style="line-height: 1.7;width: 100%;text-align: center;justify-content: center;margin: 25px 0 20px 0;color: var(--va-basecolor);font-weight: bold">
      {{this.name}}
    </div>
    <p style="width: 100%;text-align: center;margin: 10px 0 45px 0">با تشکر از شما بابت شرکت در نظرسنجی</p>
    <button  @click="goToPage('/')" class="buybtn" type="button" >
       <span style="width: 20px;height: 20px">
       <font-awesome-icon icon="fa-arrow-left" size="large" :style="{ color: white,fontSize:'15px',margin:'0 4px 0 6px',position:'relative',top:'2px' }"/>بازگشت</span>
    </button>



  </div>

  <div v-if="this.show_result===1 && this.exam_type===0">
    <div class="row">
      <p style="width: 100%;text-align: center">
        <img style="height: 170px;padding-top:25px;" src="../assets/images/okorder.png">
      </p>
    </div>
    <div  style="line-height: 1.7;width: 100%;text-align: center;justify-content: center;margin: 15px 0 20px 0;color: var(--va-basecolor);font-weight: bold">
      نتایج {{this.name}}
    </div>
    <div class="row" style="justify-content: space-around;padding: 20px;background: #F4F4F4;">
      <p>تعداد کل سوالات:</p>
      <p>{{this.total_question}}</p>
    </div>
    <div class="row" style="justify-content: space-around;padding: 20px;">
      <p>تعدا پاسخ صحیح:</p>
      <p>{{this.right_answer}}</p>
    </div>
    <div class="row" style="justify-content: space-around;padding: 20px;background: #F4F4F4;">
      <p>امتیاز کلی آزمون:</p>
      <p>{{this.total_score}}</p>
    </div>
    <div class="row" style="justify-content: space-around;padding: 20px">
      <p>امتیاز کسب شده:</p>
      <p>{{this.geted_score}}</p>
    </div>
    <div class="row" v-if="this.passing_score>0" style="justify-content: space-around;padding: 20px;background: #F4F4F4;">
      <p>وضعیت قبولی:</p>
      <p v-if="this.passed===1" style="color: green;font-weight: bold">قبول</p>
      <p v-else style="color: red;font-weight: bold">مردود</p>
    </div>
    <div class="row" style="margin-top: 30px">
      <button  @click="this.goToPage('/exam_a/'+this.exam_ref)" class="buybtn" type="button" >
               <span style="width: 20px;height: 20px">
               <font-awesome-icon icon="fa-circle-check" size="large" :style="{ color: white,fontSize:'15px',margin:'0 4px 0 6px',position:'relative',top:'2px' }"/>پاسخ سوالات</span>
      </button>

      <button @click="this.goToPage('/')"  class="beforebtn" type="button" >
        <span style="width: 20px;height: 20px">بازگشت</span>
        <span style="font-size: 22px;position: relative;top:2px;margin-right: 2px">
                  <font-awesome-icon icon="fa-arrow-left" :style="{ color: white,fontSize:'15px',margin:'0 4px 0 4px',position:'relative',top:'0' }"/>
                </span>
      </button>
      <!--            <button v-else  style="width: 92%;background-color: transparent;height: 0;border: unset;" type="button" ></button>-->
    </div>
  </div>
  <Loading v-if="this.geted===1 " style="margin-top: 100px" />
  <div v-else-if="this.geted===2 && this.list.length>0 && this.show_result===0">
    <div  style="line-height: 1.7;width: 100%;text-align: center;justify-content: center;margin: 15px 0 20px 0;color: var(--va-basecolor);font-weight: bold">
      آزمون {{this.name}}
    </div>
    <transition >
      <div  v-if="this.show===1">
        <div class="col">
          <span style=" color: #8e8e8e;font-size: 12px;margin-right: 20px">سوال {{ this.current_index+1 }} از {{this.list.length}} سوال</span>
        </div>
        <div  class="mycard" style="height:auto;margin:2% 4% 8% 4%;font-size:14px;padding:8px 2px 8px 2px ;width: 92%;border-radius: 15px">
          <div  style="padding: 0;margin: 0">

            <div style="margin: 8px 5px 10px 5px">
              <span style="margin-right: 5px">{{this.list[this.current_index].question}}</span>
            </div>
            <hr style="margin: 20px 10px 20px 10px;border-top: 1px solid #dbdbdb;" />
            <div :class="{active_option:this.list[this.current_index].answer===1,user_option:this.list[this.current_index].user_answer === 1  && this.list[this.current_index].answer!==this.list[this.current_index].user_answer}">
              <p style="padding: 10px">
                <font-awesome-icon v-if="this.list[this.current_index].answer===1" icon="fa-solid fa-circle-check" size="18px" :style="{ color: '#049c46',margin:'0 0 0 2px',position:'relative',top:'3px',fontSize:'17px' }"/>
                <font-awesome-icon v-else-if="this.list[this.current_index].user_answer===1" icon="fa-solid fa-circle-check" size="18px" :style="{ color: '#fc3453',margin:'0 0 0 2px',position:'relative',top:'3px',fontSize:'17px' }"/>
                <font-awesome-icon v-else icon="fa-regular fa-circle" size="18px" :style="{ color: white,margin:'0 0 0 2px',position:'relative',top:'3px',fontSize:'17px' }"/>
                {{ this.list[this.current_index].option1 }}
              </p>
            </div>
            <div :class="{active_option:this.list[this.current_index].answer===2,user_option:this.list[this.current_index].user_answer === 2 && this.list[this.current_index].answer!==this.list[this.current_index].user_answer}">
              <p style="padding: 10px">
                <font-awesome-icon v-if="this.list[this.current_index].answer===2" icon="fa-solid fa-circle-check" size="18px" :style="{ color: '#049c46',margin:'0 0 0 2px',position:'relative',top:'3px',fontSize:'17px' }"/>
                <font-awesome-icon v-else-if="this.list[this.current_index].user_answer===2" icon="fa-solid fa-circle-check" size="18px" :style="{ color: '#fc3453',margin:'0 0 0 2px',position:'relative',top:'3px',fontSize:'17px' }"/>
                <font-awesome-icon v-else icon="fa-regular fa-circle" size="18px" :style="{ color: white,margin:'0 0 0 2px',position:'relative',top:'3px',fontSize:'17px' }"/>
                {{ this.list[this.current_index].option2 }}
              </p>
            </div>
            <div  v-if="this.list[this.current_index].option3!==''" :class="{active_option:this.list[this.current_index].answer===3,user_option:this.list[this.current_index].user_answer === 3 && this.list[this.current_index].answer!==this.list[this.current_index].user_answer}">
              <p style="padding: 10px">
                <font-awesome-icon v-if="this.list[this.current_index].answer===3" icon="fa-solid fa-circle-check" size="18px" :style="{ color: '#049c46',margin:'0 0 0 2px',position:'relative',top:'3px',fontSize:'17px' }"/>
                <font-awesome-icon v-else-if="this.list[this.current_index].user_answer===3" icon="fa-solid fa-circle-check" size="18px" :style="{ color: '#fc3453',margin:'0 0 0 2px',position:'relative',top:'3px',fontSize:'17px' }"/>
                <font-awesome-icon v-else icon="fa-regular fa-circle" size="18px" :style="{ color: white,margin:'0 0 0 2px',position:'relative',top:'3px',fontSize:'17px' }"/>
                {{ this.list[this.current_index].option3 }}
              </p>
            </div>
            <div v-if="this.list[this.current_index].option4!==''" :class="{active_option:this.list[this.current_index].answer===4,user_option:this.list[this.current_index].user_answer === 4 && this.list[this.current_index].answer!==this.list[this.current_index].user_answer }">
              <p style="padding: 10px">
                <font-awesome-icon v-if="this.list[this.current_index].answer===4" icon="fa-solid fa-circle-check" size="18px" :style="{ color: '#049c46',margin:'0 0 0 2px',position:'relative',top:'3px',fontSize:'17px' }"/>
                <font-awesome-icon v-else-if="this.list[this.current_index].user_answer===4" icon="fa-solid fa-circle-check" size="18px" :style="{ color: '#fc3453',margin:'0 0 0 2px',position:'relative',top:'3px',fontSize:'17px' }"/>
                <font-awesome-icon v-else icon="fa-regular fa-circle" size="18px" :style="{ color: white,margin:'0 0 0 2px',position:'relative',top:'3px',fontSize:'17px' }"/>
                {{ this.list[this.current_index].option4 }}
              </p>
            </div>
            <div v-if="this.list[this.current_index].option5!==''" :class="{active_option:this.list[this.current_index].answer===5,user_option:this.list[this.current_index].user_answer === 5 && this.list[this.current_index].answer!==this.list[this.current_index].user_answer}">
              <p style="padding: 10px">
                <font-awesome-icon v-if="this.list[this.current_index].answer===5" icon="fa-solid fa-circle-check" size="18px" :style="{ color: '#049c46',margin:'0 0 0 2px',position:'relative',top:'3px',fontSize:'17px' }"/>
                <font-awesome-icon v-else-if="this.list[this.current_index].user_answer===5" icon="fa-solid fa-circle-check" size="18px" :style="{ color: '#fc3453',margin:'0 0 0 2px',position:'relative',top:'3px',fontSize:'17px' }"/>
                <font-awesome-icon v-else icon="fa-regular fa-circle" size="18px" :style="{ color: white,margin:'0 0 0 2px',position:'relative',top:'3px',fontSize:'17px' }"/>
                {{ this.list[this.current_index].option5 }}
              </p>
            </div>

            <div class="row" style="margin-top: 30px">

              <button v-if="this.list[this.current_index].isLast!==1"  @click="this.answer(this.list[this.current_index].id)" class="buybtn" type="button" >
                <span style="width: 20px;height: 20px">
                <font-awesome-icon icon="fa-arrow-right" size="large" :style="{ color: white,fontSize:'15px',margin:'0 4px 0 6px',position:'relative',top:'2px' }"/>بعدی</span>
              </button>
              <button @click="before()" v-if="this.current_index>0"  class="beforebtn" type="button" >
                <span style="width: 20px;height: 20px">قبلی</span>
                <span style="font-size: 22px;position: relative;top:2px;margin-right: 2px">
                  <font-awesome-icon icon="fa-arrow-left" :style="{ color: white,fontSize:'15px',margin:'0 4px 0 4px',position:'relative',top:'0' }"/>
                </span>
              </button>
              <!--            <button v-else  style="width: 92%;background-color: transparent;height: 0;border: unset;" type="button" ></button>-->
            </div>
          </div>
        </div>
      </div>
    </transition>
  </div>

  <div v-else-if="this.geted===2 && this.list.length===0 && this.show_result===0">
   <div class="row" >
     <p style="width: 100%;text-align: center">
      <img style="height: 150px" src="../assets/notfound.png">
     </p>
   </div>
    <div class="row" style="width: 100%;text-align: center;">
      <p class="default" style="width: 100%;text-align: center">آزمون یافت نشد</p>
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

import {faCircleQuestion,faClock,faCircleCheck,faArrowLeft,faArrowRight } from '@fortawesome/free-solid-svg-icons'
import {faCircle } from '@fortawesome/free-regular-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { useToast } from "vue-toastification";
import {Autoplay, Navigation, Pagination, Scrollbar, A11y } from 'swiper';
import { Swiper, SwiperSlide } from 'swiper/vue';
// Import Swiper styles
import 'swiper/css';
// import 'swiper/css/navigation';
import 'swiper/css/pagination';
import 'swiper/css/scrollbar';
import 'swiper/css/autoplay';

library.add(faCircleQuestion,faClock,faCircleCheck,faCircle,faArrowLeft,faArrowRight)
export default {
  name: "ExamAnswer",
  components: {
    Loading,SideMenu,Header,SubHeader,Footer,FontAwesomeIcon
  },
  mounted() {
    this.exam_ref=this.$route.params.id;
    this.getRow();
    window.scrollTo(0,0);

  },
  methods:{
    goToPage(page){
      this.$router.push({ path: page})
    },
    answer(question_ref){

      this.answer_arr[question_ref]=this.selected
      this.selected=0
      if(this.current_index+1 >=this.list.length){
        // this.geted=1;
        //finish
        this.sendAnswer();
        return;
      }
      this.current_index++;

      this.show=0;
      setTimeout(function() {
        this.show=1;
      }.bind(this), 400);
    },
    before(){
      this.current_index--;
      this.selected=this.answer_arr[this.list[this.current_index].id]
      this.show=0;
      setTimeout(function() {
        this.show=1;
      }.bind(this), 400);
    },
    myToast(alert){
      useToast().warning(alert, {
        timeout: 2000,
        position:'top-center'
      });
    },

    getRow(){
      this.geted = 1;
      const mydata = {
        action:'examAnswer',
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
              if(response.data.data!==null){
                this.list=response.data.data;
              }
              console.log(this.list);

              // response.data.data.forEach((item, i) => {
              //   if(i===0){
              //     this.selected_ref=item.ID;
              //     this.payPrice=item.Price;
              //     if(this.payPrice<0){
              //       this.payPrice=0;
              //     }
              //   }
              // });

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
            console.log(error)
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
      duration:0,
      selected:0,
      current_index:0,
      list:[],
      answer_arr:[],
      show:1,
      exam_type:2,
      show_result:0,
      total_question:0,
      right_answer:0,
      total_score:0,
      geted_score:0,
      passed:0,
      passing_score:0,
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
.beforebtn{
  width: 92%;
  text-align: center;
  margin:3%;
  height: 45px;
  background-color: #aaaaaa;
  color:white;
  border-radius: 10px;
  border:unset;
  cursor: pointer;
}
.active_option{
  line-height: 1.7;
  width: 100%;
  direction: rtl;
  margin: 10px 0 0 0;
  background: #aaffd0;
  border-radius: 17px;
}
.user_option{
  line-height: 1.7;
  width: 100%;
  direction: rtl;
  margin: 10px 0 0 0;
  background: #ff90a1;
  border-radius: 17px;
}
.option{
  line-height: 1.7;
  width: 100%;
  direction: rtl;
  margin: 10px 0 0 0;
}

.v-enter-active,
.v-leave-active {
  transition: opacity 0.5s ease;
}

.v-enter-from,
.v-leave-to {
  opacity: 0;
}
</style>
