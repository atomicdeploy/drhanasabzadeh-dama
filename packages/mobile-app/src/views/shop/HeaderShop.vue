<template>
  <div class="headershop">
    <div class="row" style="width: 100%;text-align: center">
      <div class="flex xs2" >
        <font-awesome-icon  @click="this.HeaderOpenMenu()" style="margin-top:10px;" icon="fa-solid fa-bars" size="xl"  :style="{ color: this.gray }"/>
      </div>
      <div class="flex xs8" >
        <div v-if="this.isSearch===1" style="display: flex; justify-content: center; align-items: center;height: 48px;">
          <p >جستجوی محصولات</p>
        </div>
        <div v-else class="row" style="background-color: #eeeeee;height: 42px;border-radius: 10px;margin-top: 4px;margin-right: 10px;margin-left: 10px">
          <div class="flex xs2 " >
            <font-awesome-icon style="margin-top:11px;" icon="fa-solid fa-magnifying-glass" size="lg"   :style="{ color: '#8b8b8b' }"/>
          </div>
          <div @click="this.$router.push({ path: '/shop/search' })" class="flex xs8 " style="display: flex;align-items: center;justify-content: center;" >
            <span style="color: #8b8b8b">جستجو در محصولات</span>
          </div>

        </div>
      </div>
      <div  v-if="this.isHome===1" @click="this.goBack()" class="flex xs2 icon-flipped">
        <font-awesome-icon  style="margin-top:11px;" icon="fa-solid fa-arrow-right-from-bracket" size="xl"  :style="{ color: this.gray }"/>
      </div>
      <div v-else @click="this.goBack()" class="flex xs2">
        <font-awesome-icon style="margin-top:12px;" icon="fa-solid fa-angle-left" size="xl"  :style="{ color: this.gray }"/>
      </div>

    </div>
  </div>
  <div style="height: 40px;"></div>
</template>

<script>
import { library } from '@fortawesome/fontawesome-svg-core'
import Loading from '../../components/Loading.vue'

import { faBars,faAngleLeft,faMagnifyingGlass,faArrowRightFromBracket } from '@fortawesome/free-solid-svg-icons'
import { faBell } from '@fortawesome/free-regular-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import {mapWritableState} from 'pinia';
import {useTempStroe} from '@/stores/tempStore';
library.add(faBars,faBell,faAngleLeft,faMagnifyingGlass,faArrowRightFromBracket)
export default {
  name: "HeaderShop",
  data(){
    return{
      isHome:0,
      isSearch:0,
    }
  },
  props: ['isShopHome'],
  computed: {
    ...mapWritableState(useTempStroe, ["homeOpenMenu"])
  },
  components: {
    FontAwesomeIcon
  },
  mounted() {
    var currentUrl = window.location.pathname;
    if(currentUrl==='/shop/home'){
      this.isHome=1;
    }
    if(currentUrl==='/shop/search'){
      this.isSearch=1;
    }

  },
  methods:{
    HeaderOpenMenu(){
      // this.$emit('headeropenMenu')
      this.homeOpenMenu=true
    },
    goBack(){
      if(this.isShopHome===1){
        this.$router.push({ path: '/' })
      }
      else{
        this.$router.go(-1);
      }
    }
  },
}
</script>
<style>
div{
  font-family: IRANYekan !important;
}
.headershop {
  height: 50px;
  background-color: white;
  position: fixed;
  text-align: center;
  width: 100% !important;
  max-width: 540px !important;
  right: unset !important;
  left: unset !important;
}
.icon-flipped {
  transform: scaleX(-1);
  -moz-transform: scaleX(-1);
  -webkit-transform: scaleX(-1);
  -ms-transform: scaleX(-1);
}
</style>