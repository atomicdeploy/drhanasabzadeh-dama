<template>

  <HeaderShop  @headeropenMenu="this.homeOpenMenu()"  :isHome="1"/>
  <SideMenu  :openMenu="this.openMenu" @headercloseMenu="this.headerCloseMenu()" :group_ref="0"/>
  <Loading v-if="this.geted===1 "/>
  <div v-if="this.geted===2 && this.cats.length>0" class="row justify--space-between" style=" padding:30px 0 0 0">
    <div class="flex md5 mr-3" style="font-size: 15px;text-align: right">دسته بندی محصولات</div>
  </div>
  <div v-if="this.geted===2 && this.cats.length>0" color="background-element" style="padding: 0 0.5rem 0.5rem 0.5rem;">
    <div class="myrow" style="text-align: center;">
      <div v-for="cat in this.cats" :key="cat.id"  @click="this.goToCat(cat.basecat,cat.cat,cat.subcat)" class="flex xs6 md4" >
        <div class="boxshop1" style="background: white;margin: 10px">
          <div v-if="cat.pic===''" style="height: 112px;display: flex; justify-content: center; align-items: center;">
            <font-awesome-icon  icon="fa-regular fa-images"  style="color:#a3a3a3;font-size:50px;"/>
          </div>
          <img v-else :src="this.baseurl+'/images/shop/'+cat.pic" style="height: 65px;max-width:65px;border-radius: 11px;margin-top: 7px; ">
          <p style="color: black;font-size: 13px;margin-top: 5px ">{{cat.name}}</p>
        </div>
      </div>

    </div>
  </div>

  <div v-if="this.geted===2 && this.products.length>0" class="row justify--space-between" style="padding: 0 0.2rem 0.1rem 0;margin-top: 1rem">
    <div class="flex md5 mr-3" style="font-size: 15px;text-align: right">محصولات این دسته</div>
  </div>
  <div  v-if="this.geted===2 && this.products.length>0" style="margin: 2% 3% 0 3%">
    <div  v-for="item in products" :key="item.id" @click="this.goToPage(item.id)" class="mycard" style="height: 100px;width:100%;margin-top: 10px;cursor: pointer">
      <div class="rowshop" style="padding: unset">
        <div>
          <img :src="this.baseurl+'/images/shop/'+item.pic" style="height: 100px;border-radius: 15px;padding: 5px 5px 5px 5px;max-width:200px ">
        </div>
        <div style="width: 100%">
          <p style="height:auto;padding: 20px 2% 10px 0;font-size: 14px;color: #5d5d5d;font-weight: bold ">{{item.name}}</p>

          <div class="rowshop" style="padding-right: 0;margin: 18px 0 0 0">
            <div v-if="item.price_off_int>0" style="width: 45%;margin-right: 2%">
              <span style="font-size: 10px;color: white;background-color: #ff4977;padding: 3px 5px 2px 5px;border-radius: 10px">{{ item.discount }}</span>
            </div>
            <div v-if="item.price_off_int===0" style="width: 100%;padding: 0;margin: 1% 0 0 2%">
              <div class="rowshop" style="font-size: 14px;color:var(--va-greencolor);font-weight:bold;text-align: left;display: block;margin-left: 1%">{{item.price}}</div>
            </div>
            <div v-else style="width: 53%;padding: 0;margin: 1% 0 0 2%">
              <div class="rowshop" style="font-size: 13px;color:#727272;text-align: left;display: block;margin-left: 1%"><strike>{{item.price_off}}</strike></div>
              <div class="rowshop" style="font-size: 14px;color:var(--va-greencolor);text-align: left;font-weight:bold;display: block;margin-left: 1%">{{item.price}}</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <FooterShop :selected_num="3" :total_basket="this.total_basket"/>
</template>

<script>
import { library } from '@fortawesome/fontawesome-svg-core'
import Loading from '../../components/Loading.vue'
import HeaderShop from './HeaderShop.vue'
import FooterShop from './FooterShop.vue'
import SubHeader from '../../components/SubHeader.vue'
import SideMenu from '../../components/SideMenu.vue'
import { faAngleLeft} from '@fortawesome/free-solid-svg-icons'
import { faImages } from '@fortawesome/free-regular-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import 'gitart-vue-dialog/dist/style.css'
import { useToast } from "vue-toastification";
library.add(faAngleLeft,faImages)
export default {
  name: "Basecat",
  components: {
    Loading,SideMenu,HeaderShop,SubHeader,FooterShop,FontAwesomeIcon
  },
  mounted() {

    this.loadData();
    window.scrollTo(0,0);
    this.total_basket=localStorage.getItem('total_basket');
    // if(this.$route.params.basecat!=null){
    //   this.basecat=this.$route.params.basecat;
    // }
    // if(this.$route.params.cat!=null){
    //   this.cat=this.$route.params.cat;
    // }
    // if(this.$route.params.subcat!=null){
    //   this.subcat=this.$route.params.subcat;
    // }
  },
  updated() {

  },
  methods:{
    inviteFriend(){
      this.$emit("headercloseMenu");
      let self = this;
      if (navigator.share){
        navigator.share({
          title: self.title,
          text: self.description,
        })
      }
    },
    goToCat(basecat=0,cat=0,subcat=0){
      // // this.$router.go(this.$router.currentRoute)
      // console.log(page+'?basecat='+basecat+'&cat='+cat+'&subcat='+subcat)
      // this.$router.pushe( page+'?basecat='+basecat+'&cat='+cat+'&subcat='+subcat );
      // this.$router.reload()

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
    goToPage(id){
      this.$router.push({ path: '/shop/detail/'+id });
    },
    myToast(alert){
      useToast().warning(alert, {
        timeout: 2000,
        position:'top-center',
        rtl: this.$t('config.dir')==='rtl'?true:false
      });
    },
    loadData(basecat=0,cat=0,subcat=0){
      this.geted=1;
      const mydata = {
        action:'productShop',
        lang:this.$i18n.locale,
      };

      if(this.$route.query.page!=='/shop/category'){
        mydata.basecat=this.$route.params.b
        mydata.cat=this.$route.params.c
        mydata.subcat=this.$route.params.s
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
              this.sliders=response.data.sliders;
              this.data=response.data.data;
              if(response.data.cats!==null){
                this.cats=response.data.cats;
              }
              if(response.data.products!==null){
                this.products=response.data.products;
              }
              this.geted=2;
            }
            else if(response.data.ok===3){
              localStorage.setItem('tk', "");
              this.$router.push({ path: '/mobile' })
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
    slider_click(v){
      console.log(v)
    },
    homeOpenMenu(){
      this.openMenu=true;
      console.log("homeOpenMenu");
    },
    headerCloseMenu(){
      this.openMenu=false;
      console.log("homeCloseMenu");
    },
  },
  data(){
    return{
      geted:0,
      openMenu:false,
      formatter : new Intl.NumberFormat('en', {
        maximumFractionDigits:0,
      }),
      cats:[],
      products:[],
      total_basket:0
    }
  }
};

</script>
<style>

.boxshop1{
  text-align: center;
  height: 6.5rem;

  margin-bottom: 6px;
  margin-top: 6px;
  border-radius: 10px;
  background-size: cover;
  cursor: pointer;
}
.box1{
  text-align: center;
  height: 6.5rem;
  width: 32%;
  margin-right: 2%;
  margin-left: 0;
  margin-bottom: 5px;
  border-radius: 10px;
  background-size: cover;
  cursor: pointer;
}
.awesome{
  margin: 15px 0 15px 0;
  font-size: 2.5rem;
}

.scrollrow{
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
.myrow{
  justify-content: space-around;
  padding:0 1% 0 1%;
  align-items: center;
  display: flex;
  flex-direction: row;
  flex-wrap: wrap;

}
.row::-webkit-scrollbar {
  display: none;
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
.rowshop::-webkit-scrollbar {
  display: none;
}


.card {
  /*float: left;*/
  max-width: 49%;
  margin-left: 2%;
  padding: 0.3rem;
  margin-bottom: 2rem;
  border: 0;
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
</style>