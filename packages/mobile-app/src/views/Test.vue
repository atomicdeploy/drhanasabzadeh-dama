<template>
  <div class="container show-controls">
    <p style="height: 50px;text-align:center;background: red;color: white" @click="this.send()">SEND</p>
  </div>
</template>

<script>

export default {
  mounted() {
    },
  data(){
    return{

    }
  },
  methods:{
    send(){
      this.$http(
          {
            method: "post",
            url: "https://tarapod.ir/api/sendmobile",
            timeout: 1000 * 15, // Wait for 5 seconds
            headers: {
              "Content-Type": "application/json",
            },
            data: {
              mobile: "09131231231",
            }
          })
          .then((response) => {
            console.log(response.data)
            if(response.data.ok===1){

            }
            else{

            }
          })
          .catch(error => {
            console.log(error.toString())
            if(error.response.status===401){
            }
            else{
            }
          });

    },

  }
}
</script>