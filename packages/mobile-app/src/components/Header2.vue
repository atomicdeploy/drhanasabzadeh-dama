<template>
  <div class="header2">
    <div class="row" :class="{ltr_lang:$t('config.dir')==='ltr',rtl_lang:$t('config.dir')==='rtl'}" style="width: 100%;">
      <div class="flex xs7" >
        <img v-if="this.isHome!=='2'" style="height: 60px;padding:6px 18px 12px 0;" :src="this.baseurl+'/images/apps/'+this.logo">
      </div>
      <div class="xs5 row jus" style="padding-top: 11px;justify-content: space-evenly;">
        <div @click="this.goToPage('/search')">
           <div style="background: linear-gradient(90deg, var(--va-basecolor) 0%, var(--va-seccolor) 100%);border-radius: 20px;width: 32px;  height: 32px;text-align: center">
             <img v-if="this.isHome!=='2'" style="height: 25px;padding-top: 6px;" src="../assets/images/search.png">
           </div>
        </div>
        <div @click="this.HeaderOpenMenu()">
          <div style="background: linear-gradient(90deg, var(--va-basecolor) 0%, var(--va-seccolor) 100%);;border-radius: 20px;width: 32px;  height: 32px;text-align: center">
            <img v-if="this.isHome!=='2'" style="height: 25px;padding: 10px 2px 2px 2px;" src="../assets/images/menu.png">
          </div>
        </div>
        <div @click="$router.go(-1)" v-if="this.$route.name!=='Home'">
          <div style="background: linear-gradient(90deg, var(--va-basecolor) 0%, var(--va-seccolor) 100%);;border-radius: 20px;width: 32px;  height: 32px;text-align: center">
            <img v-if="this.isHome!=='2'" style="height: 25px;padding: 10px 2px 2px 2px;" src="../assets/images/back.png">
          </div>
        </div>

      </div>
    </div>
  </div>
  <div style="width: 100%;height: 60px">
  </div>

</template>

<script>
import { library } from '@fortawesome/fontawesome-svg-core'
import Loading from '../components/Loading.vue'
import { faBars,faAngleLeft,faAngleRight } from '@fortawesome/free-solid-svg-icons'
import { faBell } from '@fortawesome/free-regular-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import {mapWritableState} from 'pinia';
import {usePermStroe} from '@/stores/permStore';
import {useTempStroe} from '@/stores/tempStore';
library.add(faBars,faBell,faAngleLeft,faAngleRight)
export default {
  name: "Header.vue",
  computed: {
    ...mapWritableState(usePermStroe, ["ui_header","ui_slider","ui_story","ui_order_item","ui_menu","ui_footer"]),
    ...mapWritableState(useTempStroe, ["show_story","isHome","homeOpenMenu"])
  },
  components: {
    FontAwesomeIcon
  },
  data () {
    return {
      logo:"",
      arrow_icon:'fa-solid fa-angle-left',
    }
  },
  mounted() {

    this.logo=localStorage.getItem('logo')
    if(this.$t('config.dir')==='ltr'){
      this.arrow_icon="fa-solid fa-angle-right"
    }
    else{
      this.arrow_icon="fa-solid fa-angle-left"
    }
  },
  // props: ['group_ref'],
  // computed: {
  //   // computed property that auto-updates when the prop changes
  //   dashboardPath() {
  //     if(this.group_ref===0){
  //       return "/";
  //     }
  //     else if(this.group_ref===1){
  //       return "/admin/dashboard";
  //     }
  //    else if(this.group_ref===2){
  //       return "/support/dashboard";
  //     }
  //     else if(this.group_ref===3){
  //       return "/kooshayar/dashboard";
  //     }
  //     else if(this.group_ref===4){
  //       return "/student/dashboard";
  //     }
  //      else if(this.group_ref===5){
  //       return "/agent/dashboard";
  //     }
  //     else{
  //       return false;
  //     }
  //   }
  // },

  methods:{
    HeaderOpenMenu(){
      // this.$emit('headeropenMenu')
      this.homeOpenMenu=true
    },
    goToPage(page){
      this.$router.push({ path: page})
    },
  },
}
</script>
<style>
div{
  font-family: IRANYekan !important;
}
.header2{
  height: 55px;
  top: 0;
  background-color: white;
  position: fixed;
  text-align: center;
  width: 100% !important;
  max-width: 540px !important;
  z-index: 10;
}
</style>