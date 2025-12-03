<template>
  <Home1 v-if="this.ui_theme==='1'" />
  <Home3 v-else-if="this.ui_theme==='3'" />
  <Home2 v-else />
</template>
<script>
import Home1 from './Home1.vue'
import Home2 from './Home2.vue'
import Home3 from './Home3.vue'
import {mapWritableState} from 'pinia';
import {usePermStroe} from '@/stores/permStore';
export default {
  name: "Home",
  computed: {
    ...mapWritableState(usePermStroe, ["ui_theme"]),
  },
  components: {
    Home1,Home2,Home3
  },
  methods:{
  },
};
</script>
