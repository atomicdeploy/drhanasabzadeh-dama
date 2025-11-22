<template>
    <Header  @headeropenMenu="this.headerOpenMenu()"  :isHome="0"/>
    <SideMenu :openMenu="this.openMenu" @headercloseMenu="this.headerCloseMenu()" :group_ref="0"/>
    <Loading v-if="this.geted===1" style="margin-top: 80px" />

    <div v-else class="bodyPart">
        <!-- top page text -->
        <div v-if="this.geted===2" class="textStyle">
            <img
            src="../../assets/images/Ellipse.png"
            style="width: 15px; margin: 10px 10px 0 0;"
            />
            <p style=" margin:10px 8px 0 0;">شعبه مورد نظر خود را انتخاب کنید:</p>
        </div>
        <!-- top page text -->

        <!-- branchs list -->
        <div v-if="this.geted===2" v-for="branch in branchList" :key="branch.id" style="padding: 10px;">
            <div class="generalCard" @click="this.goToPage('/skills', 0, branch.id, branch.name,branch.operator_num)">
                <div style="display: flex; align-items: center; padding: 5px;">
                    <img
                    :src="this.baseurl+'/images/take_turns/'+branch.pic"
                    class="branchPic"
                    />
                    <va-divider class="dividerClass" vertical dashed />
                    <div class="titles generalColumn">
                        <div class="textStyle" style="font-weight: bold;">{{ branch.name }}</div>
                        <div class="textStyle">
                            <img
                            src="../../assets/images/cityAddress.png"
                            style="width: 15px; margin-left: 10px;"
                            />
                            <p>{{ branch.city }} / {{ branch.address }}</p>
                        </div>

                        <div class="textStyle">
                            <img
                            src="../../assets/images/branchNum.png"
                            style="width: 15px; margin-left: 10px;"
                            />
                            <p>تعداد: {{branch.operator_num}} مورد</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- branchs list -->
    </div>

    <Footer :selected_num="3"/>
</template>
<script>
import Loading from '../../components/Loading.vue'
import Header from '../../components/Header.vue'
import Footer from '../../components/Footer.vue'
import SubHeader from '../../components/SubHeader.vue'
import SideMenu from '../../components/SideMenu.vue'
import LoadingButton from '../../components/LoadingButton.vue'
import {useToast} from "vue-toastification";
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import 'swiper/css';
import 'swiper/css/pagination';
import 'swiper/css/scrollbar';
import 'swiper/css/autoplay';

export default {
    name: "branches",
    components: {
        Loading,SideMenu,Header,SubHeader,Footer,FontAwesomeIcon,LoadingButton
    },
    mounted() {
        //calling getting branches list function
        this.getBranches();
        //calling getting branches list function
    },
    methods: {
        //header menu funcs
        headerOpenMenu(){
            this.openMenu=true;
            console.log("homeOpenMenu");
        },
        headerCloseMenu(){
            this.openMenu=false;
            console.log("homeCloseMenu");
        },
        //header menu funcs

        //getting branches list func
        getBranches() {
            const mydata = {
                action:'tt_branchs'
            };
            this.$http(
                {
                    method: "post",
                    url: this.apiurl,
                    timeout: 1000 * 30, // Wait for 5 seconds
                    data: mydata,
                    headers: {
                    "Content-Type": "application/json",
                    "Authorization": `Bearer ${localStorage.getItem('tk')}`
                    },
                })
                .then((response) => {
                    
                    if(response.data.ok===1){
                        this.geted = 2;
                        this.branchList = response.data.data;
                        console.log(this.branchList)
                    }
                    else{
                    this.geted=3;
                        this.$swal({
                            title: 'خطا !',
                            text: response.data.msg,
                            icon: 'error',
                            confirmButtonText:'قبول',
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
                    this.$router.push({ path: '/login' })
                    }
                    else {

                    if (error.code === 'ECONNABORTED') {
                        this.errTitle = "خطا در دریافت اطلاعات";
                        this.errMsg = "مجددا تلاش کنید";
                        // timed out
                    } else {
                        this.errTitle = "خطا";
                        this.errMsg = error.message;
                    }
                    }
                });
        },
        //getting branches list func

        //going to next page func
        goToPage(page, pageref, branchId, branchName,numberOfSkill) {
          if(numberOfSkill=='0'){
            this.myToast("در حال حاضر خدماتی در این شعبه ارائه نمی شود");
            return
          }
          else{
            localStorage.setItem("branchId", JSON.stringify(branchId));
            localStorage.setItem("branchName", JSON.stringify(branchName));
            if(pageref>0){
              this.$router.push({ path: page ,query:{ pageref: pageref } });
            }
            else {
              this.$router.push({path: page});
            }
          }

        },
        //going to next page func
      myToast(alert){
          useToast().warning(alert, {
            timeout: 2000,
            position:'top-center'
          });
      },
    },
    data() {
        return {
            geted: 1,
            openMenu: false,
            branchList: [],
        }
    }
}
</script>
<style scoped>
.bodyPart {
  background: url("../../assets/images/takeTurnBackground.png");
  background-attachment: fixed;
  background-size: cover;
  background-repeat: no-repeat;
  height: 100vh;
  justify-content: center;
  align-items: center;

}
.textStyle {
    display: flex;
    justify-content: flex-start;
    align-items: center;
    padding: 5px;
}
.generalCard {
    display: flex;
    align-items: center;
    text-align: center;
    background-color: white;
    border-radius: 15px;
    height: 120px;
}
.generalCard:hover {
    cursor: pointer;
    background-color: rgba(13, 0, 255, 0.663) !important;
    color: white !important;
}
.generalColumn {
    display: flex;
    flex-flow: column;
    align-items: flex-start;
}
.branchPic {

    height: 110px;
    border-radius: 15px;
}
.dividerClass {
    vertical-align: top !important;
    height: 130px;
    border-color: #E5E5E5 !important;
    margin-right: 15px;
}
.titles {
    margin-right: 10px;
}
@media only screen and (max-width: 426px) {
    .branchPic {
        width: 120px;
    }
    .bodyPart {
        min-height: 750px;
    }
}
@media only screen and (max-width: 321px) {
    .branchPic {
        width: 120px;
    }
}
</style>