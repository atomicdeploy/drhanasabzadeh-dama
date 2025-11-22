<template>
<!--  <router-view v-if="1===1"/>-->

  <div style="height: 240px;width: 100%;background: linear-gradient(90deg, var(--va-basecolor) 0%, var(--va-seccolor) 100%);">
    <div style="text-align: center;">
      <img style="height:40px !important;margin-top:30px " src="../assets/logo.png">
    </div>
    <p style="padding: 50px 5% 0 6%;color: white;font-size: 18px">Choose the Language</p>
  </div>
  <Loading v-if="this.geted===1" />
  <div v-else class="mycard" style="width: 90%;margin: 0 5% 0 5%;position: relative;bottom: 82px">

    <div v-for="(item, i) in this.data" :key="item.id" >
      <hr v-if="i>0" style="margin: 0 20px 0 20px" />
      <div @click="this.changeLang(item.id,item.nick)" class="row" style="padding: 20px 0 15px 0; " :class="{active_lang:item.id===this.lang_ref,deactive_lang:item.id!==item.lang_ref}">
        <div>
          <img style="width:45px; margin-left: 20px;"  :src="this.baseurl+'/images/languages/'+item.nick+'.png'" >
        </div>
        <div style="padding: 15px 0 0 15px"><span>{{ item.name }}</span></div>
      </div>

    </div>

  </div>
  <div class="footer">
    <button @click="this.goToPage('/mobile')"  class="insbtn " type="button" style="font-size:18px;margin: 5px 4% 10% 4%;width:90% !important;text-align: center">
      ok
    </button>
  </div>

</template>
<script>
import Loading from "./Loading.vue";
export default {
  name: "Languages",
  components: {
    Loading
  },
  mounted() {
  this.getList();
 },
  data(){
    return{
      iswebapp:false,
      geted:0,
      lang_ref:1,
      nick:'fa',
      data:[]
    }
  },
  methods:{
    changeLang(id,nick){
      this.lang_ref=id
      this.nick=nick
      // this.$i18n.locale = nick;
    },
    getList(){
      this.geted=1;
      const mydata = {
        action:'languages',
      };
      this.$http(
          {
            method: "post",
            url: this.apiurl,
            timeout: 1000 * 12, // Wait for 12 seconds
            data: mydata,
            headers: {
              "Content-Type": "application/json",
              "Authorization": `Bearer ${localStorage.getItem('tk')}`
            },
          })
          .then((response) => {
            if(response.data.ok===1){
              if(response.data.data!==null){
                this.data=response.data.data;
              }
              this.geted=2;
            }
            else{
              if(response.data.ok===4){
                localStorage.setItem('tk', "");
              }
              this.geted=3;
              this.$swal({
                title: this.$t('General.error'),
                text: response.data.msg,
                icon: 'error',
                confirmButtonText:this.$t('General.ok'),
                customClass: {
                  confirmButton: 'btn btn-primary'
                },
                buttonsStyling: false
              });
            }
          })
          .catch(error => {
            this.geted = 3;
            if(error.response.status===401){
              // localStorage.setItem('token', "");
              this.$router.push({ path: '/login' })
            }
            else {

              if (error.code === 'ECONNABORTED') {
                this.errTitle = this.$t('General.receivingError');
                this.errMsg = this.$t('General.tryAgain');
                // timed out
              } else {
                this.errTitle = this.$t('General.error');
                this.errMsg = error.message;
              }
            }
          });

    },
    goToPage(page){
      this.$i18n.locale = this.nick;
      this.$router.push({ path: page })
    },
    isInStandaloneMode(){
      if((window.matchMedia('(display-mode: standalone)').matches) || (window.navigator.standalone) || document.referrer.includes('android-app://')){
        this.iswebapp=true;
        return true;
      }
      else{
        this.iswebapp=false;
        return false;
      }
    },
  }
}

</script>
<style>

html{
  background-color: #c7c7c7 !important;
}
.mycard {
  /* Add shadows to create the "card" effect */
  box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
  transition: 0.3s;
  border-radius: 10px;
  background-color: white;
}

.insbtn{
  width: 92%;
  text-align: center;
  margin:3%;
  height: 45px;
  background-color:var(--va-basecolor);
  color:white;
  border-radius: 10px;
  border:unset;
  cursor: pointer;
}
.active_lang{
  background-color: #dedede !important;
}
.deactive_lang{
  background-color: unset;
}
</style>

