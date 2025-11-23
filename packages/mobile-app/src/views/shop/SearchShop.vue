<template>
    <HeaderShop  @headeropenMenu="this.homeOpenMenu()"  :isHome="1"/>
    <SideMenu :openMenu="this.openMenu" @headercloseMenu="this.headerCloseMenu()" :group_ref="0"/>
  <div class="row divserach">

   <input ref='focusMe' class="searchinput" v-model="this.searchtext"  v-on:keyup="this.tout($event)" type="text"  placeholder="قسمتی از نام محصول را وارد کنید"/>
    <font-awesome-icon icon="fa-solid fa-magnifying-glass" style="text-align: center;padding-top: 5px" />
  </div>
  <Loading v-if="this.geted===1" />
  <div  v-if="this.geted===2 && this.products.length>0" style="margin: 0 3% 3% 3%">
    <div  v-for="item in this.products" :key="item.id"  class="mycard" style="height: 100px;width:100%;margin-top: 10px;cursor: pointer">
      <div v-if="item.is_product===1" @click="this.$router.push({ path: '/shop/detail/'+item.id })" class="rowshop" style="padding: unset">
        <div>
          <img v-if="item.pic!==''" :src="this.baseurl+'/images/shop/'+item.pic" style="height: 100px;border-radius: 15px;padding: 5px 5px 5px 5px;max-width:200px ">
          <div v-else style="height: 110px;display: flex; justify-content: center; align-items: center;">
            <font-awesome-icon  icon="fa-regular fa-images"  style="color:#868686;font-size:50px;"/>
          </div>
        </div>
        <div style="width:100%">
          <p style="height:auto;padding: 20px 2% 10px 0;font-size: 14px;color:#5d5d5d;font-weight: bold ">{{item.name}}</p>

          <div class="rowshop" style="padding-right: 0;margin: 18px 0 0 0">
            <div v-if="item.price_off_int>0" style="width: 45%;margin-right: 2%">
              <span style="font-size: 10px;color: white;background-color: #ff4977;padding: 3px 5px 2px 5px;border-radius: 10px">{{ item.discount }}</span>
            </div>
            <div v-if="item.price_off_int===0" style="width: 100%;padding: 0;margin: 1% 0 0 2%">
              <div class="rowshop" style="font-size: 14px;color:var(--va-greencolor);font-weight:bold;text-align: left;display: block;margin-left: 1%">{{item.price}}</div>
            </div>
            <div v-else style="width: 100%;padding: 0;margin: 1% 0 0 2%">
              <div class="rowshop" style="font-size: 14px;color:var(--va-greencolor);text-align: left;font-weight:bold;display: block;margin-left: 1%">{{item.price}}</div>
            </div>
          </div>
        </div>
      </div>
      <div v-else @click="this.goToCat(item.basecat,item.cat,item.subcat)" class="rowshop" style="padding: unset">
        <div style="width: 37%; display: flex; justify-content: center; align-items: center;">
          <img v-if="item.pic!==''" :src="this.baseurl+'/images/shop/'+item.pic" style="height: 100px;border-radius: 15px;padding: 5px 5px 5px 5px;max-width:200px ">
          <div v-else style="height: 110px;display: flex; justify-content: center; align-items: center;">
            <font-awesome-icon  icon="fa-regular fa-images"  style="color:#868686;font-size:50px;"/>
          </div>
        </div>
        <div style="width:60%;display: flex; justify-content: center; align-items: center;">
          <p style="height:110px;text-align: center;
              justify-content: center;
              display: contents;
              font-size: 14px;color: #5d5d5d;font-weight: bold ">{{item.name}}</p>
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
    <div class="row" style="width: 100%;text-align: center;">
      <p class="default" style="width: 100%;text-align: center">هیچ نتیجه ای یافت نشد</p>
    </div>
  </div>
  <FooterShop :selected_num="4" :shop_amount="this.total_basket"/>
</template>

<script>
import { library } from '@fortawesome/fontawesome-svg-core'
import Loading from '../../components/Loading.vue'
import HeaderShop from './HeaderShop.vue'
import FooterShop from './FooterShop.vue'
import SideMenu from '../../components/SideMenu.vue'
import { faBars,faBookOpenReader,faTv,faUserGroup,faCaretDown,faChartColumn} from '@fortawesome/free-solid-svg-icons'
import { faBell,faComments,faCircleCheck,faUser,faEye,faClock,faImages } from '@fortawesome/free-regular-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'


library.add(faBars,faBell,faBookOpenReader,faTv,faUserGroup,faComments,faCircleCheck,faUser,faEye,faCaretDown,faClock,faChartColumn,faImages)
export default {
  name: "Search",
  components: {
    Loading,SideMenu,HeaderShop,FooterShop,FontAwesomeIcon
  },
  mounted() {
    window.scrollTo(0,0);
    this.$refs.focusMe.focus()
    this.total_basket=localStorage.getItem('total_basket');
  },
  methods:{
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
    tout(event){
      clearTimeout(this.timeOut);
      this.timeOut = setTimeout(()=>{
        this.filtered(this.searchtext);
      }, 1000)
    },
    filtered(newtext){
      // console.log(newtext);
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
      this.products=[];
      this.geted=1;
      const mydata = {
        action:'searchShop',
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
               if(response.data.products!==null){
                 this.products=response.data.products;
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
      openMenu:false,
      formatter : new Intl.NumberFormat('en', {
        maximumFractionDigits:0,
      }),
      products:[],
      searchtext:"",
      timeOut:null,
      not_found:0,
      total_basket:0,
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
   margin: 5% 3% 3% 3%;
   border-left: unset;
   border-top: unset;
   border-right: unset;
   border-bottom: 1px red solid;
   background-color: white;
   height: 33px;
}
.rowshop{
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
</style>
