import {defineStore} from "pinia"

export const usePermStroe = defineStore("perm",{
  state:()=>({
    android_link:"",
    ui_header:"1",
    ui_slider:"1",
    ui_story:"1",
    ui_order_item:"1",
    ui_theme:"1",
    ui_footer:"1",
    forced_profile:0,
  }),
  persist: true,
})
