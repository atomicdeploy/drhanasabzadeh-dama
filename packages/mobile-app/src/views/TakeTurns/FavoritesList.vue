<template>
    <GDialog v-model="this.loginDialog" max-width="500" >
        <div class="wrapper" style="">
            <div class="content">
                <div style="width: 100%;text-align: center">
                    <img style="width:85px " src="../../assets/images/needlogin.png">
                </div>
                <div style="width: 100%;text-align: center;font-size: 18px;font-weight: bold;padding: 10px">ورود به اپلیکیشن</div>

                <p style="width: 100%;text-align: center;font-size: 14px;padding: 10px 0 10px 0">
                جهت استفاده از این قسمت ابتدا وارد اپلیکیشن شوید
                </p>
            </div>
        </div>
        <div class="row" style="padding: unset;margin-top: 15px ">
            <div @click="this.$router.push({ path: '/mobile' });" style="width: 50%;text-align: center;background: green;padding: 10px 0 10px 0;color:white"> ورود به اپلیکیشن</div>
            <div @click="this.loginDialog=false" style="width: 50%;text-align: center;background: #dddddd;padding: 10px 0 10px 0">انصراف</div>
        </div>
    </GDialog>
    <Header @headeropenMenu="this.headerOpenMenu()" :isHome="0" />
    <SideMenu
        :openMenu="this.openMenu"
        @headercloseMenu="this.headerCloseMenu()"
        :group_ref="0"
    />
    <Loading v-if="this.geted === 1" style="margin-top: 80px" />

    <!-- operators list -->
    <div class="noOperatorPic" v-if="(favoritesList == null || favoritesList == [] || favoritesList == '' || favoritesList == undefined) && this.geted === 2">
        <img
        src="../../assets/images/nopic.png"
        />
    </div>
    <div class="bodyPart" style="padding: 10px;" v-else-if="this.geted === 2" v-for="fav in favoritesList" :key="fav.id">
        <div class="generalCard" >
            <div class="operatorCard">
                <img
                v-if="fav.pic == null || fav.pic == ''"
                src="../../assets/images/nopic.png"
                class="operatorPic"
                />
                <img
                v-else
                :src="this.baseurl+'/images/take_turns/'+fav.pic"
                class="operatorPic"
                />
                <div class="generalColumn">
                    <div>{{ fav.name }}</div>
                </div>
            </div>
        </div>
    </div>
    <!-- operators list -->

    <Footer :selected_num="3" />
</template>
<script>
import Loading from "../../components/Loading.vue";
import Header from "../../components/Header.vue";
import Footer from "../../components/Footer.vue";
import SubHeader from "../../components/SubHeader.vue";
import SideMenu from "../../components/SideMenu.vue";
import LoadingButton from "../../components/LoadingButton.vue";
import { GDialog } from 'gitart-vue-dialog'
import "swiper/css";
import "swiper/css/pagination";
import "swiper/css/scrollbar";
import "swiper/css/autoplay";

export default {
    name: "favorites",
    components: {
        Loading,
        SideMenu,
        Header,
        SubHeader,
        Footer,
        LoadingButton,
        GDialog
    },
    created() {
        this.getFavoritesList();
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
        //getting favorites list func
        getFavoritesList() {
            if (localStorage.getItem("tk") == null || localStorage.getItem("tk") == undefined || localStorage.getItem("tk") == '') {
                this.loginDialog = true;
            } else {
                const mydata = {
                    action: "tt_fav",
                };
                this.$http({
                    method: "post",
                    url: this.apiurl,
                    timeout: 1000 * 30, // Wait for 3 seconds
                    data: mydata,
                    headers: {
                    "Content-Type": "application/json",
                    Authorization: `Bearer ${localStorage.getItem("tk")}`,
                    },
                })
                    .then((response) => {
                    if (response.data.ok === 1) {
                        if (response.data == null || response.data == ' ' || response.data == '' || response.data == undefined) {
                            this.$swal({
                                title: "جزئیاتی یافت نشد!",
                                text: "هیچ اپراتوری را به عنوان مورد علاقه، انتخاب نکرده‌اید!",
                                icon: "warning",
                                confirmButtonText: "بسیار خب",
                                customClass: {
                                    confirmButton: "btn btn-warning",
                                },
                                buttonsStyling: true,
                            });
                        } else {
                            this.favoritesList = response.data.data;
                            console.log(this.favoritesList)
                            this.geted = 2;
                        }
                    } else {
                        this.geted = 3;
                        this.$swal({
                        title: "خطا !",
                        text: response.data.msg,
                        icon: "error",
                        confirmButtonText: "قبول",
                        customClass: {
                            confirmButton: "btn btn-primary",
                        },
                        buttonsStyling: false,
                        });
                    }
                    })
                    .catch((error) => {
                        this.geted = 3;
                        if (error.response.status === 401) {
                            this.$router.push({ path: "/login" });
                        } else {
                            if (error.code === "ECONNABORTED") {
                                this.errTitle = "خطا در دریافت اطلاعات";
                                this.errMsg = "مجددا تلاش کنید";
                                // timed out
                            } else {
                                this.errTitle = "خطا";
                                this.errMsg = error.message;
                            }
                        }
                    });
            }
        },
        //getting favorites list func
    },
    data() {
        return {
            geted: 1,
            openMenu: false,
            loginDialog: false,
            favoritesList: null,
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
  height: 85vh;
  justify-content: center;
  align-items: center;
}
.noOperatorPic {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 70px !important;
}
.generalCard {
  height: 75px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px;
    background: white;
    border-radius: 15px;
}
.generalColumn {
    display: flex;
    flex-flow: column;
    align-items: flex-start;
    justify-content: space-around;
    margin-right: 20px;
}
.operatorCard {
    display: flex;
    margin-right: -4px;
}
.operatorPic {
    height: 70px;
    border-top-right-radius: 5px;
    border-bottom-right-radius: 5px;
}
</style>