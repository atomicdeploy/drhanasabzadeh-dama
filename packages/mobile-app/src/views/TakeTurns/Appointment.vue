<template>
  <GDialog v-model="this.loginDialog" max-width="500" >
    <div class="wrapper" style="">
      <div class="content">
        <div style="width: 100%;text-align: center">
          <img style="width:85px " src="../../assets/images/needlogin.png">
        </div>
        <div style="width: 100%;text-align: center;font-size: 18px;font-weight: bold;padding: 10px">ورود به اپلیکیشن</div>

        <p style="width: 100%;text-align: center;font-size: 14px;padding: 10px 0 10px 0">
        جهت استفاده از این قسمت ابتدا وارد اپلیکیشن شوید
        </p>
      </div>
    </div>
    <div class="row" style="padding: unset;margin-top: 15px ">
      <div @click="this.$router.push({ path: '/mobile' });" style="width: 50%;text-align: center;background: green;padding: 10px 0 10px 0;color:white"> ورود به اپلیکیشن</div>
      <div @click="this.loginDialog=false" style="width: 50%;text-align: center;background: #dddddd;padding: 10px 0 10px 0">انصراف</div>
    </div>
  </GDialog>
  <Header style="z-index: 1111111111 !important;" @headeropenMenu="this.headerOpenMenu()" :isHome="0" />
  <SideMenu
      :openMenu="this.openMenu"
      @headercloseMenu="this.headerCloseMenu()"
      :group_ref="0"
  />
  <Loading v-if="this.geted === 1" style="margin-top: 80px" />

  <div class="bodyPart" >
    <div  style="width: 100%; padding: 0 20px 0 20px">
      <div class="row justify-center" @click="this.goToPage('/branches', 0, 0)" style="background: white;margin-top: 30px; border-radius: 20px;padding: 10px">
        <img style="width: 80px;padding: 10px" src="../../assets/images/taskSolidNotesEditCheck.png"/>
         <div style="display: flex;flex-direction: column;justify-content: center;">
           <p style=" color: black;font-size: 17px;font-weight: bold; margin-right: 5px;">  رزرو نوبت </p>
         </div>
      </div>
      <div class="row boxContainer" style="margin-top: 15px;padding: unset">
        <div @click="this.goToPage('/my-comments', 0, 1)" class="generalBox box2" style="background: white;margin-left: 8px" >
          <img style="width: 65px" src="../../assets/images/homeCommentIcon.png"/>
          <p style="  color: black;font-size: 16px;font-weight: bold;margin-top: 30px;" >
            نظرات من
          </p>
        </div>
        <div  @click="this.goToPage('/favorites', 0, 1)" style="background: white;margin-right: 8px" class="generalBox box2" >
          <img style="width: 65px" src="../../assets/images/homeHeartIcon.png" />
          <p  style=" color: black; font-size: 16px;font-weight: bold; margin-top: 30px;" >
            علاقه مندی ها
          </p>
        </div>
      </div>
      <div class="row justify-center" @click="this.goToPage('/my-appointments', 0, 1)" style="background: white;margin-top: 15px; border-radius: 20px;padding: 10px">
        <img style="width: 80px;padding: 10px" src="../../assets/images/homeAppointmentIcon.png"/>
        <div style="display: flex;flex-direction: column;justify-content: center;">
          <p style=" color: black;font-size: 16px; margin-right: 5px;font-weight: bold">  نوبت های من</p>
        </div>
      </div>
    </div>


  </div>

  <Footer :selected_num="3" />
</template>

<script>
import { library } from "@fortawesome/fontawesome-svg-core";
import Loading from "../../components/Loading.vue";
import Header from "../../components/Header.vue";
import Footer from "../../components/Footer.vue";
import SubHeader from "../../components/SubHeader.vue";
import SideMenu from "../../components/SideMenu.vue";
import LoadingButton from "../../components/LoadingButton.vue";
import { GDialog } from 'gitart-vue-dialog'
import {
  faClock,
  faBookmark,
  faCommenting,
} from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import "swiper/css";
import "swiper/css/pagination";
import "swiper/css/scrollbar";
import "swiper/css/autoplay";
library.add(faClock, faBookmark, faCommenting);

export default {
  name: "appointment",
  components: {
    Loading,
    SideMenu,
    Header,
    SubHeader,
    Footer,
    FontAwesomeIcon,
    LoadingButton,
    GDialog
  },
  mounted() {
    this.geted = 2;
    console.log(this.loginDialog)
  },
  methods: {
    //header menu funcs
    headerOpenMenu() {
      this.openMenu = true;
      console.log("homeOpenMenu");
    },
    headerCloseMenu() {
      this.openMenu = false;
      console.log("homeCloseMenu");
    },
    //header menu funcs

    //going to next page func
    goToPage(page, pageref, needLogin) {
      if ((localStorage.getItem("tk") === null || localStorage.getItem("tk") === undefined || localStorage.getItem("tk") === '') && needLogin===1) {
        this.loginDialog = true;
      } else {
        if (pageref > 0) {
          this.$router.push({ path: page, query: { pageref: pageref } });
        } else {
          this.$router.push({ path: page });
        }
      }
    },
    //going to next page func
  },
  data() {
    return {
      geted: 1,
      openMenu: false,
      loginDialog: false,
    };
  },
};
</script>

<style scoped>
.bodyPart22 {
  display: flex;
  flex-flow: column;
  justify-content: center !important;
  align-items: center !important;
  background: url("../../assets/images/takeTurnBackground.png");
  min-height: 500px;
  background-size: 539px 100%;
  background-repeat: no-repeat;
}
.bodyPart {
  background: url("../../assets/images/takeTurnBackground.png");
  background-attachment: fixed;
  background-size: cover;
  background-repeat: no-repeat;
  height: 85vh;
  justify-content: center;
  align-items: center;
}
.row {
  padding: 0 2% 0 2%;
  align-items: stretch;
  display: flex;
  flex-direction: row;
  flex-wrap: nowrap;
  overflow-x: auto;
  overflow-y: hidden;
  -ms-overflow-style: none; /* IE and Edge */
  scrollbar-width: none; /* Firefox */
}
.row::-webkit-scrollbar {
  display: none;
}
.generalBox {
  display: flex;
  flex-flow: column;
  align-items: center;
  justify-content: center;
  text-align: center;
}
.takeAppointmentBtn {
  display: flex;
  align-items: center;
  justify-content: center;
  text-align: center;
  width: 100%;
  height: 64px;
  margin-right: 1%;
  margin-top: 20px;
  margin-left: 1%;
  border-radius: 10px;
  background-color: var(--va-basecolor) !important;
  background-size: cover;
  cursor: pointer;
}
.boxContainer {
  display: flex;
  justify-content: center !important;
  align-items: center !important;
}
.box1 {
  text-align: center;
  height: 180px;
  width: 94%;
  margin-right: 1%;
  margin-left: 1%;
  margin-bottom: 5px;
  border-radius: 10px;
  background-size: cover;
  cursor: pointer;
}.box2 {
  text-align: center;
  height: 160px;
  width: 50%;
  margin-right: 1%;
  margin-left: 1%;
  margin-bottom: 5px;
  border-radius: 20px;
  background-size: cover;
  cursor: pointer;
}
@media only screen and (min-width: 1023px) {
  .bodyPart {
    /*min-height: 930px;*/
    /*background-size: 539px 930px;*/
  }
}
@media only screen and (max-width: 436px) {
    .bodyPart {
        /*min-height: 750px;*/
    }
}
@media only screen and (max-width: 321px) {
  .box2 {
    height: 200px;
  }
  .bodyPart {
    /*min-height: 500px;*/
    /*background-size: 539px 100%;*/
  }
}
</style>