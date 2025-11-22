<template>
  <Header @headeropenMenu="this.headerOpenMenu()" :isHome="0" />
  <SideMenu
    :openMenu="this.openMenu"
    @headercloseMenu="this.headerCloseMenu()"
    :group_ref="0"
  />
  <Loading v-if="this.geted === 1" style="margin-top: 80px" />

  <div v-else class="bodyPart" >
    <!-- top page texts -->
    <div v-if="this.geted === 2" class="topTexts">
      <p style="margin:0 10px 0 0;">نام شعبه: {{ getBranchName() }}</p>
      <div class="textStyle">
        <img
          src="../../assets/images/Ellipse.png"
          style="width: 10px; margin-left: 10px;"
          
          />
          <p>تخصص مورد نظرتان را انتخاب نمایید:</p>
      </div>
    </div>
    <!-- top page texts -->

    <!-- skill list -->
    <div v-if="this.geted === 2" class="myRow" style="padding: 10px ;">
      <div v-for="skill in skillsList" :key="skill.id"
        class="generalCard"
        @click="this.goToPage('/operators', 0, this.branchId, skill.id, skill.name)"
      >
        <!-- <div class="operatorNumClass">۴ نفر</div> -->
        <img
        v-if="skill.pic == null || skill.pic === ''"
        src="../../assets/images/nopic.png"
        class="skillPic"
        />
        <img
        v-else
        :src="this.baseurl+'/images/take_turns/'+skill.pic"
        class="skillPic"
        />
        <va-divider class="dividerClass" dashed />
        <div class="getMargin" style="font-weight: bold;">{{ skill.name }}</div>
        <div v-if="skill.price != null" style="padding: 10px;">قیمت از: {{ skill.price }} تومان</div>
        <div style="font-size: 13px; padding: 10px;" v-else>قیمت درج نشده است!</div>
      </div>

    </div>
    <!-- skill list -->

  </div>

  <Footer :selected_num="3" />
</template>

<script>
import Loading from "../../components/Loading.vue";
import Header from "../../components/Header.vue";
import Footer from "../../components/Footer.vue";
import SubHeader from "../../components/SubHeader.vue";
import SideMenu from "../../components/SideMenu.vue";
import LoadingButton from "../../components/LoadingButton.vue";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import "swiper/css";
import "swiper/css/pagination";
import "swiper/css/scrollbar";
import "swiper/css/autoplay";

export default {
  name: "services",
  components: {
    Loading,
    SideMenu,
    Header,
    SubHeader,
    Footer,
    FontAwesomeIcon,
    LoadingButton,
  },
  mounted() {
    //getting request infoes from localStorage
    this.branchId = JSON.parse(localStorage.getItem("branchId"));
    //getting request infoes from localStorage

    //calling getting skill list function
    this.getSkills(this.branchId);
    //calling getting skill list function
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

    //geeting branch name func for showing at the top of the page
    getBranchName() {
      this.branchName = JSON.parse(localStorage.getItem("branchName"));
      return this.branchName;
    },
    //geeting branch name func for showing at the top of the page

    //getting skill list func
    getSkills(branchId) {
      const mydata = {
        action: "tt_skills",
        branch_ref: branchId,
      };
      this.$http({
        method: "post",
        url: this.apiurl,
        timeout: 1000 * 30, // Wait for 5 seconds
        data: mydata,
        headers: {
          "Content-Type": "application/json",
          Authorization: `Bearer ${localStorage.getItem("tk")}`,
        },
      })
        .then((response) => {
          if (response.data.ok === 1) {
            this.geted = 2;
            this.skillsList = response.data.data;
            console.log(this.skillsList);
          } else {
            this.geted = 3;
            this.$swal({
              title: "خطا !",
              text: response.data.msg,
              icon: "error",
              confirmButtonText: "قبول",
              customClass: {
                confirmButton: "btn btn-primary",
              },
              buttonsStyling: false,
            });
          }
        })
        .catch((error) => {
          this.geted = 3;
          if (error.response.status === 401) {
            this.$router.push({ path: "/login" });
          } else {
            if (error.code === "ECONNABORTED") {
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
    //getting skill list func

    //going to next page func
    goToPage(page, pageref, branchId, skillId, skillName) {
      localStorage.setItem("branchId", JSON.stringify(branchId));
      localStorage.setItem("skillId", JSON.stringify(skillId));
      localStorage.setItem("skillName", JSON.stringify(skillName));
      if(pageref>0){
          this.$router.push({ path: page ,query:{ pageref: pageref } });
      }
      else {
          this.$router.push({path: page});
      }
    },
    //going to next page func
  },
  data() {
    return {
      geted: 1,
      openMenu: false,
      skillsList: [],
      branchName: null,
      branchId: null,
    };
  },
};
</script>

<style scoped>
.bodyPart {
  background: url("../../assets/images/takeTurnBackground.png");
  background-attachment: fixed;
  background-size: cover;
  background-repeat: no-repeat;
  justify-content: center;
  align-items: center;
}
.topTexts {
  padding: 15px 15px 0 0;
}
.textStyle {
    display: flex;
    justify-content: flex-start;
    align-items: center;
    padding: 10px;
    margin-top: 10px
}
.generalCard {
  width: 46%;
  height: 280px !important;
  display: flex;
  flex-flow: column;
  justify-content: space-around;
  align-items: center;
  margin:  5px 2% 20px 2%;
  background: white;
  border-radius: 15px;
}
.generalCard:hover {
    cursor: pointer;
    background-color: rgba(13, 0, 255, 0.663) !important;
    color: white !important;
}
/*.operatorNumClass {
  position: absolute;
  display: flex;
  justify-content: center;
  align-items: center;
  width: 50px;
  height: 25px;
  background: #D50C0C;
  color: white;
  border-radius: 5px 0px 5px 0px;
  bottom: 72px;
  right: 25.5px;
}*/
.skillPic {
  width: 98%;
  /*margin: 1%;*/
  border-radius: 15px 15px 0 0;
  
}
.dividerClass {
  width: 200px;
  border-color: #E5E5E5 !important;
}
.myRow {
    width: 100%;
    padding:0 2% 0 2%;
    align-items: stretch;
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
    overflow-x: auto;
    overflow-y: hidden;
    -ms-overflow-style: none;  /* IE and Edge */
    scrollbar-width: none;  /* Firefox */
}

@media only screen and (max-width: 425px) {
  .skillPic {
    width: 98%;
  }
  .getMargin {
    margin-top: -15px;
  }
  .bodyPart {
        min-height: 750px;
    }
}
@media only screen and (max-width: 376px) {
  .skillPic {
    width: 98%;

  }
  .getMargin {
    margin-top: -15px;
  }
}
@media only screen and (max-width: 321px) {
  .skillPic {
    width: 98%;

  }
  .getMargin {
    margin-top: -15px;
  }
}
</style>