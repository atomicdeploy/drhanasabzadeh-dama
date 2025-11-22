<template>
<!--  <Code1 v-if="this.ui_theme==='1'" />-->
<!--  <Code2 v-else-if="this.ui_theme==='2' || this.ui_theme==='3'" />-->
  <Code2/>
</template>
<script>
import Code1 from './Code1.vue'
import Code2 from './Code2.vue'
import {mapWritableState} from 'pinia';
import {usePermStroe} from '@/stores/permStore';
export default {
  name: "Code",
  computed: {
    ...mapWritableState(usePermStroe, ["ui_theme"]),
  },
  components: {
    Code1,Code2
  },
};
</script>