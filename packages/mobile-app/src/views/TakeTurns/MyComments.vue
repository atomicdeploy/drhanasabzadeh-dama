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
    <Header style="z-index: 1111111111 !important;" @headeropenMenu="this.headerOpenMenu()" :isHome="0" />
    <SideMenu
        :openMenu="this.openMenu"
        @headercloseMenu="this.headerCloseMenu()"
        :group_ref="0"
    />
    <Loading  v-if="this.geted === 1" style="margin-top: 80px;" />

    <div v-else class="bodyPart">
        <div class="operatorDetailsContainer">
            <!-- top page text -->
            <div v-if="this.geted===2" class="textStyle">
                <img
                src="../../assets/images/Ellipse.png"
                style="width: 10px; margin: 10px 10px 0 5px"
                />
                <h2 style="margin: 10px 0 0 5px">نظرات من:</h2>
            </div>
            <!-- top page text -->
            <!-- comments List -->
            <div id="comments" class="allCommentsClass" v-if="myComments">
                <div class="generalColumnFlex commentContainer mb-2" v-for="comment in myComments" :key="comment.id">
                    <div class="showComment" >
                        <div class="rightPartComment">
                            <div>
                              <font-awesome-icon v-if="comment.pic == null || comment.pic == ''" icon="fa-solid fa-circle-user" :style="{ color: '#a5a4a4',position:'relative',top:'2px',fontSize:'28px' }"/>
                                <img
                                    v-else
                                    :src="this.baseurl+'/images/take_turns/'+comment.pic"
                                    class="commentPic"
                                />
                            </div>
                            <div class="mr-2">
                                <p>{{ comment.operator_name }}</p>
                                <div class="commentDetails">
                                    <img src="../../assets/images/watch.png" style="bottom: 2px;position: relative;"

                                    class="iconClass"
                                    />
                                    <!-- {{ comment.date }} -->
                                    1402/07/08
                                </div>
                            </div>
                        </div>
                        
                        <div class="generalColumnFlex mr-2">
                            <div class="dateRate">
                                <va-rating
                                    v-if="comment.rating"
                                    readonly
                                    v-model="comment.rating"
                                    class="ratingStar"
                                    color="warning"
                                    size="small"
                                />
                                <p v-else>رتبه‌ای برای این اپراتور ثبت نشده است!</p>
                            </div>
                        </div>
                    </div>
                    <h2 class="commentDescription mb-2">
                        {{ comment.skill_name }}
                    </h2>
                    <div class="commentDescriptionPic">
                        <img
                            v-if="comment.pic != null && comment.pic !== ''"
                            :src="this.baseurl+'/images/take_turns/'+comment.pic"
                            class="commentPic"
                        />

                    </div>
                    <div class="commentDescription mb-2">
                        {{ comment.comment }}
                    </div>
                </div>
            </div>
            <div v-else class="noComments">
                <img
                src="../../assets/images/nopic.png"
                />
                <h1>شما هیچ کامنتی ننوشته‌اید!</h1>
            </div>
            <!-- comments List -->
        </div>
    </div>

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

import { library } from '@fortawesome/fontawesome-svg-core'
import { faUser,faCircleUser} from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
library.add(faUser,faCircleUser)

export default {
    name: "my-comments",
    components: {
        Loading,
        SideMenu,
        Header,
        SubHeader,
        Footer,
        LoadingButton,
        GDialog,FontAwesomeIcon
    },
    mounted() {
        this.getMyCommentsList();
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

        //getting my comments func
        getMyCommentsList() {
            const mydata = {
                action: "tt_mycomment",
            };
            this.$http({
                method: "post",
                url: this.apiurl,
                timeout: 1000 * 30, // Wait for 5 seconds
                data: mydata,
                headers: {
                "Content-Type": "application/json",
                Authorization: `Bearer ${localStorage.getItem("tk")}`,
                },
            })
            .then((response) => {
                if (response.data.ok === 1) {
                    this.geted = 2;
                    if (response.data.data === null || response.data.data === ' ' || response.data.data === '' || response.data.data === undefined) {
                        this.$swal({
                            title: "جزئیاتی یافت نشد!",
                            text: "متأسفانه برای اپراتور مورد نظر شما، جزئیاتی درج نشده است!",
                            icon: "warning",
                            confirmButtonText: "بسیار خب",
                            customClass: {
                                confirmButton: "btn btn-warning",
                            },
                            buttonsStyling: true,
                        });
                    } else {
                        this.myComments = response.data.data;
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
        },
        //getting my comments func
    },
    data() {
        return {
            myComments: [],
            geted: 1,
            openMenu: false,
            loginDialog: false,
            operatorDetails: null,
            be_fav: null,
            // borderColor: '#000000',
        }
    },
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
.operatorDetailsContainer {
    width: 98%;
    border-radius: 15px;
    display: flex;
    flex-flow: column;
    justify-content: center;
    align-items: center;
}
.textStyle {
    width: 100%;
    display: flex;
    justify-content: flex-start;
    align-items: center;
    padding: 5px 5px 0 0;
}
.allCommentsClass {
    width: 100%;
    height:100%;
    overflow-y: hidden;
    padding: 10px;
    margin-top: 10px;
    border-radius: 15px;
}
.noComments {
    display: flex;
    flex-flow: column;
    justify-content: center;
    align-items: center;
    height: 480px !important;
}
.generalColumnFlex {
    display: flex;
    flex-flow: column;
    justify-content: center;
    align-items: center;
}
.commentContainer {
    width: 100%;
    box-shadow: 0px 0px 4px rgb(188, 187, 187);
    background-color: white;
    border-radius: 15px;
}
.showComment {
    display: flex;
    justify-content: space-between;
    width: 100%;
    padding: 10px;
}
.rightPartComment {
    display: flex;
    align-items: center;
}
.commentPic {
    width: 40px;
    height: 40px;
    border-radius: 10px;
}
.commentDetails {
    display: flex;
    margin-top: 10px;
}
.iconClass {
    width: 15px;
    margin-left: 5px;
}
.commentDescription {
    width: 100%;
    padding: 10px;
    text-align: right;
}
@media only screen and (max-width: 436px) {
    .commentPic {
        width: 50px;
        height: 50px;
    }
    .iconClass {
        width: 15px;
        height: 15px;
    }
    .commentDetails {
        font-size: 15px;
    }
    .ratingStar {
        margin-left: 20px;
    }
}
@media only screen and (max-width: 436px) {
    .bodyPart {
        min-height: 750px;
    }
}
</style>