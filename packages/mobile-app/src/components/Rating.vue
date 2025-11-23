<template>
  <div v-if="this.rate===5" class="row" style="padding: 0;margin: 0 0 0 2%;direction:ltr">
    <font-awesome-icon icon="fa-solid fa-star" :style="{fontSize: this.size,color:'#ffdd02'}"/>
    <font-awesome-icon icon="fa-solid fa-star" :style="{fontSize: this.size,color:'#ffdd02'}"/>
    <font-awesome-icon icon="fa-solid fa-star" :style="{fontSize: this.size,color:'#ffdd02'}"/>
    <font-awesome-icon icon="fa-solid fa-star" :style="{fontSize: this.size,color:'#ffdd02'}"/>
    <font-awesome-icon icon="fa-solid fa-star" :style="{fontSize: this.size,color:'#ffdd02'}"/>
<!--    <font-awesome-icon icon="fa-regular fa-star" />-->
<!--    <font-awesome-icon icon="fa-solid fa-star-half-stroke" />-->
  </div>

  <div v-if="this.rate===4" class="row" style="padding: 0;margin: 0;direction:ltr">

    <font-awesome-icon icon="fa-solid fa-star" :style="{fontSize: this.size,color:'#ffdd02'}"/>
    <font-awesome-icon icon="fa-solid fa-star" :style="{fontSize: this.size,color:'#ffdd02'}"/>
    <font-awesome-icon icon="fa-solid fa-star" :style="{fontSize: this.size,color:'#ffdd02'}"/>
    <font-awesome-icon icon="fa-solid fa-star" :style="{fontSize: this.size,color:'#ffdd02'}"/>
    <font-awesome-icon icon="fa-regular fa-star" :style="{fontSize: this.size,color:'#ffdd02'}"/>
    <!--    <font-awesome-icon icon="fa-regular fa-star" />-->
    <!--    <font-awesome-icon icon="fa-solid fa-star-half-stroke" />-->
  </div>

  <div v-if="this.rate===3" class="row" style="padding: 0;margin: 0;direction:ltr">

    <font-awesome-icon icon="fa-solid fa-star" :style="{fontSize: this.size,color:'#ffdd02'}"/>
    <font-awesome-icon icon="fa-solid fa-star" :style="{fontSize: this.size,color:'#ffdd02'}"/>
    <font-awesome-icon icon="fa-solid fa-star" :style="{fontSize: this.size,color:'#ffdd02'}"/>
    <font-awesome-icon icon="fa-regular fa-star" :style="{fontSize: this.size,color:'#ffdd02'}"/>
    <font-awesome-icon icon="fa-regular fa-star" :style="{fontSize: this.size,color:'#ffdd02'}"/>
    <!--    <font-awesome-icon icon="fa-regular fa-star" />-->
    <!--    <font-awesome-icon icon="fa-solid fa-star-half-stroke" />-->
  </div>

  <div v-if="this.rate===2" class="row" style="padding: 0;margin: 0;direction:ltr">

    <font-awesome-icon icon="fa-solid fa-star" :style="{fontSize: this.size,color:'#ffdd02'}"/>
    <font-awesome-icon icon="fa-solid fa-star" :style="{fontSize: this.size,color:'#ffdd02'}"/>
    <font-awesome-icon icon="fa-regular fa-star" :style="{fontSize: this.size,color:'#ffdd02'}"/>
    <font-awesome-icon icon="fa-regular fa-star" :style="{fontSize: this.size,color:'#ffdd02'}"/>
    <font-awesome-icon icon="fa-regular fa-star" :style="{fontSize: this.size,color:'#ffdd02'}"/>
    <!--    <font-awesome-icon icon="fa-regular fa-star" />-->
    <!--    <font-awesome-icon icon="fa-solid fa-star-half-stroke" />-->
  </div>

  <div v-if="this.rate===1" class="row" style="padding: 0;margin: 0;direction:ltr">
    <font-awesome-icon icon="fa-solid fa-star" :style="{fontSize: this.size,color:'#ffdd02'}"/>
    <font-awesome-icon icon="fa-regular fa-star" :style="{fontSize: this.size,color:'#ffdd02'}"/>
    <font-awesome-icon icon="fa-regular fa-star" :style="{fontSize: this.size,color:'#ffdd02'}"/>
    <font-awesome-icon icon="fa-regular fa-star" :style="{fontSize: this.size,color:'#ffdd02'}"/>
    <font-awesome-icon icon="fa-regular fa-star" :style="{fontSize: this.size,color:'#ffdd02'}"/>
  </div>
  <div v-if="this.rate===0" class="row" style="padding: 0;margin: 0;direction:ltr">
    <font-awesome-icon icon="fa-regular fa-star" :style="{fontSize: this.size,color:'#ffdd02'}"/>
    <font-awesome-icon icon="fa-regular fa-star" :style="{fontSize: this.size,color:'#ffdd02'}"/>
    <font-awesome-icon icon="fa-regular fa-star" :style="{fontSize: this.size,color:'#ffdd02'}"/>
    <font-awesome-icon icon="fa-regular fa-star" :style="{fontSize: this.size,color:'#ffdd02'}"/>
    <font-awesome-icon icon="fa-regular fa-star" :style="{fontSize: this.size,color:'#ffdd02'}"/>
  </div>

</template>
<script>
import { library } from '@fortawesome/fontawesome-svg-core'
import {faStar,faStarHalfStroke} from '@fortawesome/free-solid-svg-icons'
import { faStar as faStarR} from '@fortawesome/free-regular-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import "bottom-navigation-vue/dist/style.css";
library.add(faStar,faStarR,faStarHalfStroke)
export default {
name: "Rating",
  props: ['rate','size'],
  components: {
   FontAwesomeIcon
  },
}
</script>
<style>
</style>