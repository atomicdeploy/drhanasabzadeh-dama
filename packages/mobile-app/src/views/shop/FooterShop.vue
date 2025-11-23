<template>
  <div class="footer">
    <CurvedBottomNavigation
        style="position: absolute !important;"
        :foreground-color="this.basecolor"
        badge-color='#FBC02D'
        background-color='#FFFFFF'
        icon-color='#0000008A'
        replaceRoute="true"
        :options="options" v-model="selected" @click="this.footerAction(this.selected)">
      <template @click="this.footerAction(this.selected)" #icon="{ props }" style="margin-bottom: 20px">
        <font-awesome-icon   :icon="props.icon" size="xl"  :style="{ color: '#868686' }"/>
      </template>
      <template #title="{ props }">
        <p>{{ props.title }}</p>
      </template>
    </CurvedBottomNavigation>
  </div>
  <div class="row" style="width: 100%;height: 65px"></div>
</template>
<script>




import { library } from '@fortawesome/fontawesome-svg-core'
import {faShop,faLeftLong,faBasketShopping,faLayerGroup,faArrowRightFromBracket} from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { CurvedBottomNavigation, } from "bottom-navigation-vue";
import "bottom-navigation-vue/dist/style.css";
library.add(faShop,faLeftLong,faBasketShopping,faLayerGroup,faArrowRightFromBracket)
import { useToast } from 'vuestic-ui'
export default {
name: "FooterShop",
  components: {
   FontAwesomeIcon,CurvedBottomNavigation,useToast
  },
  mounted() {
    var parentTag = document.querySelector('.btn-item-1');
    var newTag = document.createElement('p'); // جایگزین کلمه tagname با نام تگ مورد نظر خودتان
    parentTag.appendChild(newTag);
    newTag.classList.add('basket_count');
    newTag.setAttribute('id','basket_count');
  },
  updated() {
    var amount=localStorage.getItem('total_basket');
    if((amount!=null && amount>0) || this.total_basket>0){
      var am=0;
      if(this.total_basket>0){
        am=this.total_basket;
      }
      else{
        am=amount;
      }
      console.log(am.toString()+"_______")
      if(am>0){
         document.getElementById("basket_count").innerText=am;
        // newTag.innerText=amount;
         // جایگزین کلمه class-name با نام کلاس مورد نظر خودتان

      }

    }
  },
  methods: {
    goToPath(ii){
      if(ii===1){
        this.$router.push({ path: '/' });
      }
      else if(ii===2){
        this.$router.push({ path: '/shop/basket' })
      }
      else if(ii===3){
        // this.goToPath();
        this.$router.push({ path: '/shop/category' });
      }
      else if(ii===4){
        this.$router.push({ path: '/shop/home' })
      }

      return true;
    },
    footerAction(ii) {
      var self = this;
      setTimeout(function () { self.goToPath(ii) } , 300)
      // setTimeout(this.chch(ii), 950);
    },
  },
  props: ['selected_num','shop_amount'],
  data(){
    return{
      selected: this.selected_num,
      shop_amount: this.shop_amount,
      options: [
        {
          id: 1,
          icon: "ffa-solid fa-arrow-right-from-bracket",
          title: "خروج از فروشگاه",
        },
        {
          id: 2,
          icon: "fa-solid fa-basket-shopping",
          title: "سبد خرید"
        },
        {
          id: 3,
          icon: "fa-solid fa-layer-group",
          title: "دسته بندی",
        },
        {
          id: 4,
          icon: "fa-solid fa-shop",
          title: "فروشگاه"
        },

      ],
    }
  }
}
</script>
<style>
.unchecked{
  position: unset !important;
}
.checked > .btn-title{
  visibility: unset !important;
  top: 42px;
  color: #636363 !important;
  font-weight: bold !important;
  font-size: 10px;
}.unchecked > .btn-title{
  visibility: unset !important;
  top: 42px;
  font-size: 9px;
  font-weight: lighter !important;
  color: #a3a3a3 !important;
}
.btn-item-0 > .active-label > .fa-arrow-right-from-bracket{
  transform: scaleX(-1);
  -moz-transform: scaleX(-1);
  -webkit-transform: scaleX(-1);
  -ms-transform: scaleX(-1);
}
.basket_count {
  position: relative;
  top: 0;
  left: 16px;
  background: red;
  border-radius: 10px;
  color: white;
  padding: 2px;
}
</style>