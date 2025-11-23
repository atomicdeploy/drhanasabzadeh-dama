<template>
    <Header  @headeropenMenu="this.homeOpenMenu()" :isHome="0"/>
    <SideMenu :openMenu="this.openMenu" @headercloseMenu="this.headerCloseMenu()" :group_ref="0"/>


  <div class="row" v-if="this.geted===2">
    <p style="font-size: 13px;width: 50%;padding: 3% 2% 3% 0">{{ $t('Live.live')}}</p>
    <p style="font-size: 13px;width: 50%;text-align: left;padding: 3% 3% 3% 2%">
      <font-awesome-icon icon="fa-solid fa-caret-down" style="font-size: 0.75rem;padding-left: 4px"/>
    </p>
  </div>

  <Loading v-if="this.geted===1"  />
  <div  v-else-if="this.geted===2 && this.data.length>0" style="margin: 0 3% 3% 3%">
    <div  v-for="live in data" :key="live.ID" @click="this.goToLive(live.ID)" class="mycard" style="height: 100px;width:100%;margin-top: 10px;cursor: pointer">
      <div class="row" style="padding: unset">
        <img :src="this.baseurl+'/images/live/'+live.Pic" style="height: 100px;border-radius: 15px;padding: 5px 5px 5px 5px;max-width:120px ">
        <div style="width:100%">
          <p style="height:40px;padding: 10px 2% 10px 0;font-size: 12px;color: #636363;font-weight: bold ">{{live.Name}}</p>
          <div class="row"  style="padding: unset;margin-left: 2%">
            <font-awesome-icon icon="fa-regular fa-clock" style="font-size: 0.75rem;margin:0 2% 0 2%;color: #5d5d5d"/>
            <span style="font-size: 12px;color:#5d5d5d;width: 60%;margin-top: 1px">{{ live.Duration }}</span>
            <div style="width:30%;text-align: left">
              <va-badge v-if="live.status===0" :text="this.$t('Live.willHeld')" color="danger"  text-color="white" style=" padding-bottom: 2px;color: white"/>
              <va-badge v-else-if="live.status===1" :text="this.$t('Live.playing')" color="warning" text-color="white"  style="padding-bottom: 2px;color: white"/>
              <va-badge v-else-if="live.status===2" :text="this.$t('Live.held')" color="success" text-color="white"  style="padding-bottom: 2px;color: white"/>
            </div>
          </div>
          <div class="row" style="padding-right: 0;margin: 10px 0 0 0">
            <div style="width: 60%;margin-right: 2%">
              <span style="font-size: 12px;color: #5d5d5d">{{ $t('Live.start')}}: {{ live.started_time+" "+live.started_date }}</span>
            </div>
            <div v-if="live.PriceInt===0" style="width: 40%;padding: 0;margin: 1% 0 0 0">
              <div class="row" style="font-size: 12px;color:var(--va-greencolor);text-align: left;display: block;margin-left: 1%">{{ $t('Live.free')}}</div>
            </div>
             <div v-else-if="live.PriceOffInt===0" style="width: 40%;padding: 0;margin: 1% 0 0 0">
              <div class="row" style="font-size: 12px;color:var(--va-greencolor);text-align: left;display: block;margin-left: 1%">{{live.Price}}</div>
            </div>
            <div v-else style="width: 40%;padding: 0;margin: 1% 0 0 0">
              <div class="row" style="font-size: 12px;color:#5d5d5d;text-align: left;display: block;margin-left: 1%"><strike>{{live.PriceOff}}</strike></div>
              <div class="row" style="font-size: 12px;color:var(--va-greencolor);text-align: left;display: block;margin-left: 1%">{{live.Price}}</div>
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
      <p class="default" style="width: 100%;text-align: center">{{ $t('Live.noLive')}}</p>
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
import { faBars,faBookOpenReader,faTv,faUserGroup,faCaretDown,faChartColumn} from '@fortawesome/free-solid-svg-icons'
import { faBell,faComments,faCircleCheck,faUser,faEye,faClock } from '@fortawesome/free-regular-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

library.add(faBars,faBell,faBookOpenReader,faTv,faUserGroup,faComments,faCircleCheck,faUser,faEye,faCaretDown,faClock,faChartColumn)
export default {
  name: "Live",
  components: {
    Loading,SideMenu,Header,SubHeader,Footer,FontAwesomeIcon
  },
  mounted() {
    this.getRow(0);
    window.scrollTo(0,0);
  },
  methods:{
     goToLive(id){
      this.$router.push({ path: "/live/"+id })
    },

    getRow(is_filter){
      this.geted=1;
      const mydata = {
        action:'live',
        lang:this.$i18n.locale,
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
              this.data=[];
               if(response.data.data!==null){
                 this.data=response.data.data;
              }
               console.log(response.data.data);
              this.geted=2;
            }
            else if(response.data.ok===3){
              localStorage.setItem('token', "");
              this.$router.push({ path: '/login' })
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
      data:[],
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
</style>
