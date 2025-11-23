import {defineStore} from "pinia"

export const useTempStroe = defineStore("temp",{
  state:()=>({
    show_story:false,
    isHome:"0",
    homeOpenMenu:false,
    selected_num:3,
  }),
  persist: false,
})
