<template>
  <Header1 v-if="this.ui_theme==='1' && this.show_story===false" />
  <Header2 v-else-if="this.ui_theme==='2' && this.show_story===false" />
  <Header1 v-else-if="this.show_story===false" />
</template>

<script>
import { library } from '@fortawesome/fontawesome-svg-core'
import { faBars,faAngleLeft,faAngleRight } from '@fortawesome/free-solid-svg-icons'
import { faBell } from '@fortawesome/free-regular-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import Header from '../components/Header.vue'
import Header1 from '../components/Header1.vue'
import Header2 from '../components/Header2.vue'
import {mapWritableState} from 'pinia';
import {usePermStroe} from '@/stores/permStore';
import {useTempStroe} from '@/stores/tempStore';
library.add(faBars,faBell,faAngleLeft,faAngleRight)
export default {
  name: "Header.vue",
  computed: {
    ...mapWritableState(usePermStroe, ["ui_theme"]),
    ...mapWritableState(useTempStroe, ["show_story","isHome"])
  },
  components: {
    FontAwesomeIcon,Header,Header1,Header2
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

  methods:{
    HeaderOpenMenu(){
      this.$emit('headeropenMenu')
    }
  },
}
</script>
<style>
div{
  font-family: IRANYekan !important;
}
</style>