<template>
  <div>
    <vue-pdf-app style="height: 100vh;" :pdf="this.dl+this.filename"></vue-pdf-app>
    <!--    <PDFViewer-->
    <!--        source="https://dama-app.com/hakwolQ8zcx/tebelahiii/1688540019vfJQuRvg.pdf"-->
    <!--        style="height: 100vh; width: 100vw"-->
    <!--        @download="handleDownload"-->
    <!--    />-->
    <!--    <vue-pdf-embed source="https://dama-app.com/hakwolQ8zcx/tebelahiii/1688540019vfJQuRvg.pdf" />-->
    <Header  @headeropenMenu="this.homeOpenMenu()" :isHome="0" style="position: fixed !important;
      top: 25px !important;color: white;width: 100% !important; max-width: 540px !important;right: unset !important;left: unset !important;"/>

    <SideMenu :openMenu="this.openMenu" @headercloseMenu="this.headerCloseMenu()" :group_ref="0"/>
    <Footer :selected_num="3" />
  </div>
</template>

<script>
import VuePdfApp from "vue3-pdf-app";
import "vue3-pdf-app/dist/icons/main.css";

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
  name:"Pdfviewer",
  components: {
    VuePdfApp,Loading,SideMenu,Header,SubHeader,Footer,FontAwesomeIcon
  },
  mounted() {
    this.filename=this.$route.params.id.replace('aqNz9nz','/');
  },
  data() {
    return {
      filename:"" ,
    }
  },
}
</script>
<style>
#download{
  display: none;
}
</style>