<template>
    <Header @headeropenMenu="this.headerOpenMenu()" :isHome="0" />
     <SideMenu
        :openMenu="this.openMenu"
        @headercloseMenu="this.headerCloseMenu()"
        :group_ref="0"
    />
    <Loading v-if="this.geted === 1" style="margin-top: 80px" />

    <!-- body -->
    <div v-if="this.geted === 2" class="mainColumn">
        <div class="generalColumnFlex">
            <div class="generalColumnFlex">
                <img
                src="../../assets/images/okorder.png"
                class="okPaymentPic"
                />
                <p class="mt-3">نوبت شما با موفقیت رزرو شد.</p>
            </div>
            <div class="mt-5">
                <p>زمان نوبت: {{ this.dayDateFs }} ساعت {{ this.chosenHour }} {{ this.timeOfDay }}</p>
                <p class="mt-3">اپراتور: {{ this.operatorName }}</p>
                <p class="mt-3">حرفه: {{ this.skillName }}</p>
            </div>
        </div>
        <div class="generalNormalFlex">
            <!-- payment Button -->
            <div class="payment_button generalNormalFlex" @click="this.goToPage('/appointment', 0)">
                <p>بازگشت</p>
            </div>
            <!-- payment Button -->
        </div>
    </div>
    <!-- body -->

    <Footer :selected_num="3" />
</template>
<script>
import Loading from "../../components/Loading.vue";
import Header from "../../components/Header.vue";
import Footer from "../../components/Footer.vue";
import SubHeader from "../../components/SubHeader.vue";
import SideMenu from "../../components/SideMenu.vue";
import "swiper/css";
import "swiper/css/pagination";
import "swiper/css/scrollbar";
import "swiper/css/autoplay";

export default {
    name: "successful-payment",
    components: {
        Loading,
        SideMenu,
        Header,
        SubHeader,
        Footer,
    },
    created() {
        this.dayDateFs = JSON.parse(localStorage.getItem("dayDateFs"));
        this.chosenHour = JSON.parse(localStorage.getItem("appointmentHour"));
        this.timeOfDay = JSON.parse(localStorage.getItem("timeOfDay"));
        this.operatorName = JSON.parse(localStorage.getItem("operatorName"));
        this.skillName = JSON.parse(localStorage.getItem("skillName"));
    },
    mounted() {
      this.geted = 2;
    },
    methods: {
        //header menu funcs
        headerOpenMenu() {
            this.openMenu = true;
            console.log("homeOpenMenu");
        },
        headerCloseMenu() {
            this.openMenu = false;
            console.log("homeCloseMenu");
        },
        //header menu funcs
        //going to next page func
        goToPage(page, pageref) {
            if (localStorage.getItem("tk") == null || localStorage.getItem("tk") == undefined || localStorage.getItem("tk") == '') {
                this.loginDialog = true;
            } else {
                if (pageref > 0) {
                this.$router.push({ path: page ,query:{ pageref: pageref } });
                }
                else {
                    this.$router.push({path: page});
                }
            }
        },
        //going to next page func
    },
    data() {
        return {
            geted: 1,
            openMenu: false,
        }
    }
}
</script>
<style scoped>
.mainColumn {
    display: flex;
    flex-flow: column;
    justify-content: space-between;
    align-items: center;
    width: 100%;
    height: 550px;
}
.okPaymentPic {
    width: 100%;
    border-top-right-radius: 5px;
    border-bottom-right-radius: 5px;
}
.payment_button {
    width: 70%;
    height: 40px;
    margin-bottom: 40px !important;
    background-color: green;
    color: white;
    border-radius: 10px;
    align-self: center !important;
    cursor: pointer;
}
.generalNormalFlex {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 90%;
}
.generalColumnFlex {
    display: flex;
    flex-flow: column;
    justify-content: center;
    align-items: center;
    padding: 10px;
}
</style>