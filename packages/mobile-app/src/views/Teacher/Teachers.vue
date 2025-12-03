<template>
    <Header  @headeropenMenu="this.homeOpenMenu()" :isHome="0"/>
    <SideMenu :openMenu="this.openMenu" @headercloseMenu="this.headerCloseMenu()" :group_ref="0"/>
 <div class="row">
   <div @click="this.orderDialog=true" class="divicon" >
     <font-awesome-icon icon="fa-solid fa-arrow-down-short-wide" style="text-align: center;" />
   </div>
   <div class="divserach1">
     <input class="searchinput" v-model="this.searchtext"  v-on:keyup="this.tout($event)" type="text"  :placeholder="this.$t('Teacher.searchText')"/>
   </div>
   <div @click="this.filterDialog=true" class="divicon">
     <font-awesome-icon icon="fa-solid fa-filter" style="text-align: center;" />
   </div>

 </div>
  <Loading v-if="this.geted===1"  />
  <div  v-if="this.geted===2 && this.data.length>0" style="margin: 10px 3% 0 3%">
      <div  v-for="teacher in data" :key="teacher.ID" @click="this.goToPage('/teacher/'+teacher.id)" class="mycard" style="height: 100px;width:100%;margin-top: 10px;cursor: pointer">
        <div class="row" style="padding: unset">
          <img :src="this.baseurl+'/images/profile/'+teacher.pic" style="height: 100px;border-radius: 15px;padding: 5px 5px 5px 5px;max-width:120px ">
          <div style="width:100%">
            <p style="height:44px;padding: 44px 10px 10px 2%;font-size: 12px;color: var(--va-basecolor);font-weight: bold ">{{teacher.name}}</p>
         </div>
        </div>
      </div>
    </div>

  <div v-else-if="this.geted===2 && this.data.length===0">
   <div class="row" >
     <p style="width: 100%;text-align: center">
      <img style="height: 150px" src="../../assets/notfound.png">
     </p>
   </div>
    <div class="row" style="width: 100%;text-align: center">
      <p class="default" style="width: 100%;text-align: center">هیچ مدرسی یافت نشد</p>
    </div>
  </div>
  <Footer :selected_num="3" />
  <GDialog v-model="this.filterDialog" max-width="500">
    <div class="row" style="padding: 15px 0 20px 0">
      <p style="font-weight: bold;text-align: center;width: 10%"></p>
      <p style="font-weight: bold;text-align: center;width: 90%;margin-top: 5px">فیلتر مدرسین</p>
      <div @click="this.filterDialog=false" class="divclose" >
        <font-awesome-icon icon="fa-solid fa-xmark" style="text-align: center;" />
      </div>
    </div>
    <div style="margin: 15px 10px 0 10px">
      <p style="margin: 0 2px 5px 2px">استان: </p>
      <Select2 dir="rtl" dropdownCssClass="msel" v-model="this.province_ref" :options="this.province_list" :settings="{ settingOption: value, settingOption: value }"   @select="mySelectEvent($event)"/>
    </div>
    <div style="margin: 15px 10px 0 10px">
      <p style="margin: 0 2px 5px 2px">شهر: </p>
      <va-progress-circle v-if="this.geted_city===1" size="1.5rem" style="margin-top: 15px" indeterminate color="var(--va-basecolor)" thickness="0.15" />
      <Select2 v-else dir="rtl" dropdownCssClass="msel" v-model="this.city_ref" :options="this.city_list" :settings="{ settingOption: value, settingOption: value }"  @select="citySelectEvent($event)"/>
    </div>
    <div class="row" style="padding: unset;margin: 40px 10px 10px 10px  ">
      <div @click="this.doFilter(1)" style="color:white;width: 100%;height:50px;text-align: center;background:var(--va-basecolor);padding-top: 16px;border-radius: 15px">مشاهده نتایج</div>
    </div>
  </GDialog>
  <GDialog v-model="this.orderDialog" max-width="500" >
    <div class="row" style="padding: 15px 0 20px 0">
      <p style="font-weight: bold;text-align: center;width: 10%"></p>
      <p style="font-weight: bold;text-align: center;width: 90%;margin-top: 5px">ترتیب نمایش</p>
      <div @click="this.orderDialog=false" class="divclose" >
        <font-awesome-icon icon="fa-solid fa-xmark" style="text-align: center;" />
      </div>
    </div>
    <div class="row" @click="this.order='all'" :class="{active_order:this.order==='all',deactive_order:this.order!=='all'}"><p style="width: 100%;text-align: center;">همه</p></div>
    <div class="row" @click="this.order='newest'" :class="{active_order:this.order==='newest',deactive_order:this.order!=='newest'}"><p style="width: 100%;text-align: center;">جدید ترین ها</p></div>
    <div class="row" @click="this.order='oldest'" :class="{active_order:this.order==='oldest',deactive_order:this.order!=='oldest'}"><p style="width: 100%;text-align: center;">قدیمی ترین ها</p></div>
    <div class="row" style="padding: unset;margin: 40px 10px 10px 10px  ">
      <div @click="this.doFilter(0)" style="color:white;width: 100%;height:50px;text-align: center;background:var(--va-basecolor);padding-top: 16px;border-radius: 15px">مشاهده نتایج</div>
    </div>
  </GDialog>
</template>

<script>
import { library } from '@fortawesome/fontawesome-svg-core'
import Loading from '../../components/Loading.vue'
import Header from '../../components/Header.vue'
import Footer from '../../components/Footer.vue'
import SubHeader from '../../components/SubHeader.vue'
import SideMenu from '../../components/SideMenu.vue'
import Rating from '../../components/Rating.vue'
import { faBars,faBookOpenReader,faTv,faUserGroup,faCaretDown,faChartColumn,faArrowDownShortWide,faFilter,faXmark} from '@fortawesome/free-solid-svg-icons'
import { faBell,faComments,faCircleCheck,faUser,faEye,faClock } from '@fortawesome/free-regular-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

import 'gitart-vue-dialog/dist/style.css'
import { GDialog } from 'gitart-vue-dialog'
import Select2 from 'vue3-select2-component';
library.add(faBars,faBell,faBookOpenReader,faTv,faUserGroup,faComments,faCircleCheck,faUser,faEye,faCaretDown,faClock,faChartColumn,faArrowDownShortWide,faFilter,faXmark)
export default {
  name: "Teachers",
  components: {
    Loading,SideMenu,Header,SubHeader,Footer,FontAwesomeIcon,Rating,GDialog,Select2
  },
  mounted() {
    this.pageref=this.$route.query.pageref;
    this.getRow('');
    window.scrollTo(0,0);
  },
  methods:{
    doFilter(type){
      if(type===1){
        this.searchtext=''
      }

      this.filterDialog=false
      this.orderDialog=false
      this.getRow('');
    },
    mySelectEvent({id, text}){
      this.province_ref=id
      this.getCity();
    },
    citySelectEvent({id, text}){
      this.city_ref=id
    },
    tout(event){
      clearTimeout(this.timeOut);
      this.timeOut = setTimeout(()=>{
        this.filtered(this.searchtext);
      }, 1000)
    },
    filtered(newtext){
      this.getRow(newtext);
    },
    goToPage(page){
      this.$router.push({ path: page})
    },
    getRow(stext){
      this.geted=1;
      const mydata = {
        action:'teachers',
        searchtext:this.searchtext,
        province_ref:this.province_ref,
        city_ref:this.city_ref,
        order:this.order,
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

              response.data.provinces.forEach(object => {
                this.province_list.push({id: object.id, text: object.name})
              });
              this.geted=2;
            }
            else if(response.data.ok===3){
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
    getCity(stext){
      this.geted_city=1;
      const mydata = {
        action:'getCity',
        province_ref:this.province_ref,
        lang:this.$i18n.locale,

      };
      this.$http(
          {
            method: "post",
            url: this.apiurl,
            timeout: 1000 * 10, // Wait for 5 seconds
            data: mydata,
            headers: {
              "Content-Type": "application/json",
              "Authorization": `Bearer ${localStorage.getItem('tk')}`
            },
          })
          .then((response) => {
            if(response.data.ok===1){
              this.city_list=[];
              response.data.data.forEach(object => {
                this.city_list.push({id: object.id, text: object.name})
              });
              this.city_ref=0;
              this.geted_city=2;
            }
            else if(response.data.ok===3){
            }
            else{
              if(response.data.ok===4){
                localStorage.setItem('tk', "");
              }
              this.geted_city=3;
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
            this.geted_city = 3;
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
      filterDialog:false,
      orderDialog:false,
      geted:0,
      geted_city:0,
      catref:0,
      openMenu:false,
      formatter : new Intl.NumberFormat('en', {
        maximumFractionDigits:0,
      }),
      data:[],
      data_cat:[],
      filter:1,
      pageref:0,
      searchtext:"",
      province_ref:0,
      city_ref:0,
      order:'all',
      province_list:[],
      city_list:[{id: 0, text: "ابتدا استان را انتخاب کنید"}]
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
}.divserach1{
  border-radius: 10px;
   width: 94%;
   margin: 10px 5px 5px 10px;
   /*border: 1px var(--va-basecolor) solid;*/
   height: 45px;
  padding: 13px 15px 0 15px;
  background: #eceeef;
 }
 .divicon{
   border-radius: 10px;
   background: #eceeef;
   padding: 13px 15px 0 15px;
   height: 45px;
   margin: 10px 0 5px 5px;
 }
.divclose{
   border-radius: 10px;
   background: #eceeef;
   padding: 13px 15px 0 15px;
   height: 45px;
    position: relative;
    top: -7px;
    left: 10px;
 }
.select2-container--default .select2-selection--single {
  background-color: #fff;
  border: 1px solid #aaa;
  border-radius: 15px;
  padding: 8px;
  height: 50px;
}
.select2-container--default[dir="rtl"] .select2-selection--single .select2-selection__arrow {
  left: 20px;
  right: auto;
  top: 12px;
  padding-top: 3px;

}
.select2-container{
  width: 100% !important;
}
.active_order{
  padding:15px;
  border-bottom: 1px solid #EEEEEE;
  margin: 0 20px 0 20px;
  background: #d2d2d2;
  border-radius: 10px
}
.deactive_order{
  padding:15px;
  border-bottom: 1px solid #EEEEEE;
  margin: 0 20px 0 20px;
  background: #ffffff;
  border-radius: 10px
}
</style>
