<template>
<!--  <Mobile1 v-if="this.ui_theme==='1'" />-->
<!--  <Mobile2 v-else-if="this.ui_theme==='2' || this.ui_theme==='3'" />-->
  <Mobile2/>
</template>

<script>
import Mobile1 from './Mobile1.vue'
import Mobile2 from './Mobile2.vue'
import {mapWritableState} from 'pinia';
import {usePermStroe} from '@/stores/permStore';
export default {
  name: 'Mobile',
  computed: {
    ...mapWritableState(usePermStroe, ["ui_theme"]),
  },
  components: {
    Mobile1,Mobile2
  },
}
</script>