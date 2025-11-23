<template>
  <div class="header3">
    <div class="row" :class="{ltr_lang:$t('config.dir')==='ltr',rtl_lang:$t('config.dir')==='rtl'}" style="width: 100%;text-align: center;">
      <div class="flex xs2" >
        <font-awesome-icon id="menu_sidebar_3" @click="this.HeaderOpenMenu()" style="margin-top:10px;" icon="fa-solid fa-bars" size="xl"  :style="{ color: this.gray }"/>
      </div>
      <div class="flex xs8" >
        <img v-if="isHome!==2" style="height: 40px;padding-top:10px;" :src="this.baseurl+'/images/apps/'+this.logo">
      </div>
      <div class="flex xs2" v-if="isHome===1" >
        <font-awesome-icon style="margin-top:12px;" icon="fa-regular fa-bell" size="xl"  :style="{ color: this.gray }"/>
      </div>
      <div  v-else @click="$router.go(-1)" class="flex xs2">
        <font-awesome-icon id="menu_arrow_3" style="margin-top:12px;" :icon="this.arrow_icon" size="xl"  :style="{ color: this.gray }"/>
      </div>
    </div>
  </div>
  <div style="width: 100%;height: 50px"></div>
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
  props: ['isHome'],
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
    }
  },
}
</script>
<style>
div{
  font-family: IRANYekan !important;
}
.header3 {
  /*height: 45px;*/
  /*position: absolute;*/
  /*left: 0;*/
  top: 0;
  /*width: 100%;*/
  /*max-width: 540px;*/
  background-color: white;
  /*text-align: center;*/

  position: fixed;
  text-align: center;
  /*color: white;*/
  width: 100% !important;
  max-width: 540px !important;
  right: unset !important;
  left: unset !important;
  z-index: 100;
}
</style>