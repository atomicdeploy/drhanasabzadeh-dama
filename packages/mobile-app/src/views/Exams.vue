<template>
    <Header  @headeropenMenu="this.homeOpenMenu()"  :isHome="0"/>
    <SideMenu :openMenu="this.openMenu" @headercloseMenu="this.headerCloseMenu()" :group_ref="0"/>
  <Loading v-if="this.geted===1"  />
  <div class="center" style="width: 100%;" >
    <div class="row" v-if="this.geted===2" style="margin: 4% 4% 1% 4%">
      <p  style="font-size: 13px;width: 50%;padding: 3% 2% 3% 0;font-weight: bold">آزمون / نظرسنجی</p>
      <p style="font-size: 13px;width: 50%;text-align: left;padding: 3% 3% 3% 2%">
        <font-awesome-icon icon="fa-solid fa-caret-down" style="font-size: 0.75rem;padding-left: 4px"/>
      </p>
    </div>
   </div>
  <div  v-if="this.geted===2 && this.data.length>0" style="margin: 5px 3% 0 3%">
    <div  v-for="item in data" :key="item.id" @click="this.goToPage('/exam/'+item.id,item.participated)" class="mycard" style="height: 100px;width:100%;margin-top: 10px;cursor: pointer">
      <div class="row" style="padding: unset;height: 55px;">
        <div style="width: 60%;margin: 20px 5% 0 0">{{item.name}}</div>
        <div v-if="item.type===0" style="width: 30%;text-align: end;margin: 20px 0 0 5%;">
          <span style="border-radius: 20px;background: #ef3a4f;padding: 5px 8px 5px 8px;color: white">آزمون</span>
        </div>
        <div v-else-if="item.type===1" style="width: 30%;text-align: end;margin: 20px 0 0 5%;">
          <span style="border-radius: 20px;background: #5db1ff;padding: 5px 8px 5px 8px;color: white">نظرسنجی</span>
        </div>
        <div v-else style="width: 30%;text-align: end;margin: 20px 0 0 5%;">
          <span style="border-radius: 20px;background: #ffcc5d;padding: 5px 8px 5px 8px;color: white">تمرین</span>
        </div>
      </div>
      <div class="row" style="padding: unset;height: 40px;">
        <div style="width: 55%;margin: 10px 5% 0 0;color: #8d8c8c">تعداد سوالات: {{item.qusetion_count}}</div>
        <div v-if="item.participated===0" style="width: 45%;text-align: end;margin: 5px 0 0 5%;">
          <span style="border-radius: 20px;background: var(--va-greencolor);padding: 5px 8px 5px 8px;color: white">پاسخ به سوالات
          <font-awesome-icon icon="fa-solid fa-angle-left" style="position: relative;top: 2px"></font-awesome-icon></span>
        </div>
        <div v-else style="width: 45%;text-align: end;margin: 5px 0 0 5%;">
          <span style="border-radius: 20px;background: #b8b8b8;padding: 5px 8px 5px 8px;color: white">قبلا شرکت کرده اید</span>
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
      <p class="default" style="width: 100%;text-align: center">به زودی...</p>
    </div>
  </div>



  <Footer :selected_num="3"/>
</template>

<script>
import { library } from '@fortawesome/fontawesome-svg-core'
import Loading from '../components/Loading.vue'
import Header from '../components/Header.vue'
import Footer from '../components/Footer.vue'
import SubHeader from '../components/SubHeader.vue'
import SideMenu from '../components/SideMenu.vue'
import { faCaretDown,faAngleLeft} from '@fortawesome/free-solid-svg-icons'
import { } from '@fortawesome/free-regular-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import LoadingButton from '../components/LoadingButton.vue'
import { useToast } from "vue-toastification";

library.add(faCaretDown,faAngleLeft)
export default {
  name: "Invoice",
  components: {
    Loading,SideMenu,Header,SubHeader,Footer,FontAwesomeIcon,LoadingButton
  },
  mounted() {
    this.getRow();
    window.scrollTo(0,0);
  },
  methods:{
    myToast(alert,type){
      if(type===1){
        useToast().success(alert, {
          timeout: 2000,
          position:'top-center'
        });
      }
      else if(type===2){
        useToast().warning(alert, {
          timeout: 2000,
          position:'top-center'
        });
      }
      else if(type===3){
        useToast().error(alert, {
          timeout: 2000,
          position:'top-center'
        });
      }
    },
    goToPage(page,participated){
      if(participated===1){
        this.myToast("شما قبلا در این پرسشنامه شرکت کرده اید",2);
      }
      else{
        this.$router.push({ path: page })
      }

    },
    homeOpenMenu(){
      this.openMenu=true;
      console.log("homeOpenMenu");
    },
    headerCloseMenu(){
      this.openMenu=false;
      console.log("homeCloseMenu");
    },
    getRow(){
      if(localStorage.getItem('tk')===null){
        this.$router.push({ path: '/mobile' });
        return;
      }
      this.geted=1;
      const mydata = {
        action:'exams',
      };
      this.$http(
          {
            method: "post",
            url: this.apiurl,
            timeout: 1000 * 8, // Wait for 5 seconds
            data: mydata,
            headers: {
              "Content-Type": "application/json",
              "Authorization": `Bearer ${localStorage.getItem('tk')}`
            },
          })
          .then((response) => {
            if(response.data.ok===1){
              this.data=response.data.data;
              this.geted=2;
            }
            else if(response.data.ok===3){
              localStorage.setItem('tk', "");
              this.$router.push({ path: '/mobile' })
            }
            else{
              this.geted=3;
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
            if (error.code === 'ECONNABORTED') {
              this.errTitle = "خطا در دریافت اطلاعات";
              this.errMsg = "مجددا تلاش کنید";
              // timed out
            } else {
              this.errTitle = "خطا";
              this.errMsg = error.message;
            }
          });
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
    }
  }
};

</script>
<style>
.img-contact{
  width: 60px;
  object-fit: contain;
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
.imagediv{
  justify-content: center;
  align-items: center;
  display: flex;
}
</style>
