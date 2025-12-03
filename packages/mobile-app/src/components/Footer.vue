<template>
  <Footer2 v-if="this.ui_theme==='2' || this.ui_theme==='3'" />
  <Footer1 v-else />
  <div v-if="this.ui_theme==='3'" style="width: 100%;height: 90px"></div>
</template>
<script>
import Footer1 from '../components/Footer1.vue'
import Footer2 from '../components/Footer2.vue'
import {mapWritableState} from 'pinia';
import {usePermStroe} from '@/stores/permStore';
import {useTempStroe} from '@/stores/tempStore';
export default {
name: "Footer.vue",
  components: {
    Footer1,Footer2
  },
  computed: {
    ...mapWritableState(usePermStroe, ["ui_theme"]),
    ...mapWritableState(useTempStroe, ["selected_num"])
  },
}
</script>