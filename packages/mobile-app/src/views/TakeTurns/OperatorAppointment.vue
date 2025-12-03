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
    <Loading v-if="this.geted === 1" style="margin-top: 80px" />
    
    <div v-if="this.geted === 2" class="bodyPart generalColumnFlex">
        <!-- operator details -->
        <div class="operatorDetailsContainer">
            <div class="noOperatorPic generalNormalFlex" v-if="!this.operatorDetails">
                <img
                src="../../assets/images/nopic.png"
                />
            </div>
            <div class="generalCard generalColumnFlex" v-else>
                <div class="operatorCard">
                    <img
                    v-if="this.operatorDetails.cover_pic == null || this.operatorDetails.cover_pic == ''"
                    src="../../assets/images/nopic.png"
                    class="operatorPic mb-3"
                    />
                    <img
                    v-else
                    :src="this.baseurl+'/images/take_turns/'+this.operatorDetails.cover_pic"
                    class="operatorPic mb-3"
                    />
                    <!-- <div class="row_details"> -->
                    <p class="mb-3" style="font-size: 25px; font-weight: bold;">{{ this.operatorDetails.name }}</p>
                        <!-- <va-button
                        round
                        icon="favorite"
                        :icon-color='iconColor'
                        class="iconClass1"
                        @click="favoriteToggle(this.operatorDetails.id)"
                        /> -->
                    <!-- </div> -->
                    <!-- <div class="row_details"> -->
                        <!-- <p>{{ this.operatorDetails.desc }}</p> -->
                    <va-rating
                        v-if="this.operatorDetails.rating"
                        v-model="this.operatorDetails.rating"
                        readonly
                        class="ratingStar mb-3"
                        color="warning"
                    />
                    <p v-else>رتبه‌ای برای این اپراتور ثبت نشده است!</p>
                    <div class="priceClass" style="font-weight: bold; font-size: 18px;">
                        <span style="margin-left: 5px"> از </span><p class="ml-2 mb-3" style="color: red;">{{this.operatorDetails.skill_price}}</p>تومان
                    </div>
                    <!-- </div> -->
                </div>
                <!-- <va-divider style="width: 98%; color: rgba(128, 128, 128, 0.4);" /> -->
                <div class="btnContainer">
                    <div class="takeAppointmentBtn" @click="this.goToPage('/choose-day-hour',0, this.operatorDetails)" :style="{ background: 'white' }" >
                        <img style="width:24px " src="../../assets/images/taskSolidNotesEditCheck2.png">
                        <p style="color:white; font-size:14px; margin-right: 5px;">رزرو نوبت {{this.operatorDetails.skill_name}}</p>
                    </div>
                    <div class="favoriteBtn" @click="favoriteToggle(this.operatorDetails.id)" :style="{ background: 'white' }" >
                        <img v-if="this.isFavorite === false" style="width:24px " src="../../assets/images/favorite.png">
                        <img v-else style="width:24px " src="../../assets/images/redFavoritepng.png">
<!--                        <p v-if="this.isFavorite === false" class="fav_text" style="color:white; font-size:18px; margin-right: 5px;">ذخیره</p>-->
<!--                        <p v-else class="fav_text" style="color:white; font-size:18px; margin-right: 5px;"></p>-->
                    </div>
                </div>

                <div class="operatorDtailsContainer">
                    <div class="detailCard" >
                        <div class="cardTitle">
                            شعبه:
                        </div>
                        <p>{{ this.operatorDetails.branch_name }}</p>
                    </div>
                    <div class="detailCard" >
                        <div class="cardTitle">
                            خدمات:
                        </div>
                        <p style="text-align: justify;">{{ this.operatorDetails.all_skill }}</p>
                    </div>
                    <div class="detailCard" >
                        <div class="cardTitle">
                            اپراتور:
                        </div>
                        <p>{{ this.operatorDetails.name }}</p>
                    </div>
                    <div>
                        <div class="detailCard">
                            <div class="cardTitle">
                                آدرس:
                            </div>
                            <p>{{ this.operatorDetails.address }}</p>
                        </div>
<!--                        <iframe-->
<!--                            :src="this.mapSrc"-->
<!--                            width="100%"-->
<!--                            style="border:0; border-radius: 10px;"-->
<!--                            allowfullscreen=""-->
<!--                            loading="lazy"-->
<!--                            referrerpolicy="no-referrer-when-downgrade">-->
<!--                        </iframe>-->
                    </div>
                </div>
                
                <div v-if="this.operatorDetails.desc!==null" class="descriptionPart">
                    <p style="font-size: 18px; font-weight: 500;margin-top: 10px">درباره من</p>
                    <div class="mt-2" >
                        {{ this.operatorDetails.desc }}
                    </div>
                </div>

<!--                <div class="myWorkPart">-->
<!--                    <p style="font-size: 25px; font-weight: 500; align-self: flex-start;">عکس نمونه کارهای من</p>-->
<!--                    <div v-if="myWorksList.length === 0">-->
<!--                        <img-->
<!--                        src="../../assets/images/nopic.png"-->
<!--                        />-->
<!--                    </div>-->
<!--                    <div v-else class="myResume">-->
<!--                        <div v-for="myWork in myWorksList" :key="myWork.id"-->
<!--                        class="generalCard"-->
<!--                        >-->
<!--                            <img-->
<!--                            :src="this.baseurl+'/images/take_turns/'+myWork.pic"-->
<!--                            class="myWorkPic"-->
<!--                            />-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->

                <div class="operatorDetailsContainer mt-5">
                    <p style="font-size: 18px; font-weight: 500; align-self: flex-start;margin-right: 8px">نظرات کاربران</p>
                    <div v-if="this.noComment!==''" style="background: white;border-radius: 15px;width: 100%;padding: 20px;margin-top: 10px">
                      {{this.noComment}}
                    </div>
                    <div v-else id="comments" class="allCommentsClass">
                        <div v-for="comment in operatorComments" :key="comment.id" class="generalColumnFlex commentContainer mb-3" >
                            <div class="showComment" >
                                <div class="rightPartComment">
                                    <div>
                                      <font-awesome-icon v-if="comment.pic == null || comment.pic == ''" icon="fa-solid fa-circle-user" :style="{ color: '#a5a4a4',position:'relative',top:'2px',fontSize:'28px' }"/>
<!--                                      <font-awesome-icon v-if="comment.pic == null || comment.pic == ''" class="awesome" icon="fa-user"  :style="{ color: 'black',position:'relative',top:'2px' }"/>-->
                                        <img
                                            v-else
                                            :src="this.baseurl+'/images/take_turns/'+comment.pic"
                                            class="commentPic"
                                        />
                                    </div>
                                    <div class="mr-2">
                                        <p style="text-align:right">{{ comment.name }}</p>
                                        <div class="commentDetails">
                                            <img
                                            src="../../assets/images/watch.png"
                                            class="iconClass"
                                            />
                                            <p class="dateText">{{ comment.date }}</p>
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
                            <div class="commentDescription mb-2" style="width: 100%;">
                               {{comment.comment}}
                            </div>
                        </div>
                    </div>
                    <!-- <div v-if="this.showAllComments == false" class="oneComment" @click="showHideComments()">
                        <font-awesome-icon class="awesome ml-2" icon="fa-solid fa-chevron-down" :style="{ color:this.basecolor }"/>
                        <p :style="{ color:this.basecolor}">مشاهده همه نظرات</p>
                    </div>
                    <div v-else class="oneComment" @click="showHideComments()">
                        <font-awesome-icon class="awesome ml-2" icon="fa-solid fa-chevron-up" :style="{ color:this.basecolor }"/>
                        <p :style="{ color:this.basecolor}">عدم نمایش نظرات</p>
                    </div> -->
                </div>
            </div>
        </div>
        <!-- operator details -->
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
    name: "operator-appointment",
    components: {
        Loading,
        SideMenu,
        Header,
        SubHeader,
        Footer,
        LoadingButton,
        GDialog,
        FontAwesomeIcon,
    },
    mounted() {
        //getting operator ref from localstorage
        var operatorId = JSON.parse(localStorage.getItem("operatorId"));
        this.branchId = JSON.parse(localStorage.getItem("branchId"));
        this.skillId = JSON.parse(localStorage.getItem("skillId"));
        //getting operator ref from localstorage

        //calling function for getting operator details
        this.getOperatorDetail(operatorId);
        //calling function for getting operator details
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
        
        //getting operator details func
        getOperatorDetail(operatorId) {
            const mydata = {
                action: "tt_operator_detail",
                operator_ref: operatorId,
                skill_ref: this.skillId,
                branch_ref: this.branchId,
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
                    if (response.data == null || response.data == ' ' || response.data == '' || response.data == undefined) {
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
                        this.operatorDetails = response.data;
                        this.mapSrc = `https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d8285.067272756532!2d${this.operatorDetails.longi}!3d${this.operatorDetails.langi}!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3fbc3744d5f475b3%3A0x583af57c114dcf80!2z2KLYsdin2YXar9in2Ycg2K_Yp9ix2KfYqCDYp9mB2LPYsSDYqNiu2KrbjNin2LHbjA!5e0!3m2!1sen!2s!4v1695033766839!5m2!1sen!2s`
                        if (response.data.comments === null) {
                            this.noComment = 'هیچ نظری ثبت نشده';
                        } else {
                            this.operatorComments = response.data.comments;

                        }
                        console.log(this.operatorDetails)
                        if (this.operatorDetails.is_fav == 1) {
                            this.isFavorite = true;
                        }
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
        //getting operator details func

        //add or remove operator from user favorite list func
        favoriteToggle(operatorId) {
            if (localStorage.getItem("tk") === null || localStorage.getItem("tk") === undefined || localStorage.getItem("tk") === '') {
                this.loginDialog = true;
            } else {
                if (this.isFavorite === false) {
                    this.isFavorite = true;
                    this.be_fav = 1;
                } else {
                    this.isFavorite = false;
                    this.be_fav = 0;
                }
                console.log(operatorId)
                const favdata = {
                    action: "tt_set_fav",
                    operator_ref: operatorId,
                    set_fav: this.be_fav
                };
                this.$http({
                method: "post",
                url: this.apiurl,
                timeout: 1000 * 30, // Wait for 5 seconds
                data: favdata,
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
                                text: "متأسفانه برای اپراتور مورد نظر شما، جزئیاتی درج نشده است!",
                                icon: "warning",
                                confirmButtonText: "بسیار خب",
                                customClass: {
                                    confirmButton: "btn btn-warning",
                                },
                                buttonsStyling: true,
                            });
                        } else {
                            console.log(response.data)
                        }
                    } else if(response.data.ok===3){
                      localStorage.setItem('token', "");
                      this.$router.push({ path: '/login' })
                    }
                    else{
                        if(response.data.ok===4){
                            localStorage.setItem('tk', "");
                        }
                        this.geted = 3;
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
        //add or remove operator from user favorite list func

        //show or hide comments func
        // showHideComments(event) {
        //     if (this.showAllComments == false) {
        //         this.showAllComments = true;
        //         document.getElementById('comments').classList.remove('allCommentsClass');
        //     } else {
        //         this.showAllComments = false;
        //         document.getElementById('comments').classList.add('allCommentsClass');
        //     }
        // },
        //show or hide comments func

        //going to next page func
        goToPage(page, pageref, operatorDetails) {
            if (localStorage.getItem("tk") == null || localStorage.getItem("tk") == undefined || localStorage.getItem("tk") == '') {
                this.loginDialog = true;
            } else {
                localStorage.setItem("operatorDetails", JSON.stringify(operatorDetails));
                if (pageref > 0) {
                    this.$router.push({ path: page ,query:{ pageref: pageref } });
                } else {
                    this.$router.push({path: page});
                }
            }
        },
        //going to next page func
    },
    data() {
        return {
            myWorksList: [],
            geted: 1,
            openMenu: false,
            isFavorite: false,
            loginDialog: false,
            showAllComments: false,
            mapSrc: null,
            operatorDetails: "",
            operatorComments: null,
            noComment: "",
            be_fav: null,
            branchId: null,
            skillId: null,
            // borderColor: '#000000',
        }
    },
}
</script>

<style scoped>
.bodyPart {
    background: url("../../assets/images/takeTurnBackground.png");
    min-height: 915px;
    background-size: 539px 100%;
    background-repeat: no-repeat;
}
.operatorDetailsContainer {
    width: 98%;
    border-radius: 5px;
    display: flex;
    flex-flow: column;
    justify-content: center;
    align-items: center;
}
.allCommentsClass {
    width: 100%;
    height:100%;
    overflow-y: hidden;
    margin-top: 10px;
    border-radius: 10px;
}
.oneComment {
    display: flex;
    padding: 5px;
    cursor: pointer;
    background-color: white;
    box-shadow: 0px 0px 4px rgb(188, 187, 187);
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
}
.iconClass {
    width: 15px;
    margin-left: 5px;
}
.operatorPic {
    height: 200px;
    border-radius: 5px;
}
.priceClass {
    display: flex;
    justify-content: center;
    font-weight: bold;
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
.commentDescription {
    padding: 10px 13px 10px 10px;
    width: 100%;
    text-align: right;
}
.generalNormalFlex {
    display: flex;
    justify-content: center;
    align-items: center;
}
.generalCard {
    text-align: center;
    padding: 10px;
    width: 100%;
}
.myWorkPic {
    width: 80%;
    border-radius: 5px;
}
.operatorCard {
    width: 100%;
    display: flex;
    flex-flow: column;
    justify-content: space-evenly;
    align-items: center;
}
.noOperatorPic {
    height: 280px !important;
}
.row_details {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 5px;
}
.iconClass1 {
    background: transparent !important;
}
.iconClass2 {
    background: transparent !important;
    border: 1px solid red !important;
}
.appointment_button {
    width: 98%;
    height: 40px;
    background-color: green;
    color: white;
    margin-bottom: 15px;
    border-radius: 10px;
    align-self: center !important;
    cursor: pointer;
}
.btnContainer {
    display: flex;
    width: 100%;
  margin-bottom: 10px;
}
.takeAppointmentBtn {
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    width: 100%;
    height: 54px;
    margin-right: 1%;
    margin-left: 1%;
    border-radius: 10px;
    background-color: #3B0056 !important;
    background-size: cover;
    cursor: pointer;
}
.favoriteBtn {
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    width: 20%;
    height: 54px;
    margin-right: 1%;
    margin-left: 1%;
    border-radius: 10px;
    background-color: #B88E68 !important;
    background-size: cover;
    cursor: pointer;
}
.operatorDtailsContainer {
    width: 100%;
    margin-top: 10px;
}
.detailCard {
    display: flex;
    align-items: center;
    padding: 10px;
    margin-bottom: 10px;
    background-color: white;
    border-radius: 10px;
}
.cardTitle {
    padding: 10px;
    background-color: #F8FAFB;
    border-radius: 10px;
    margin-left: 10px;
}
.descriptionPart {
    width: 100%;
    padding: 10px;
    text-align: right;
}
.myWorkPart {
    display: flex;
    flex-flow: column;
    justify-content: center;
    align-items: center;
    width: 100%;
}
@media only screen and (max-width: 436px) {
    .commentPic {
        width: 50px;
        height: 50px;
    }
    .iconClass {
        width: 15px;
        height: 15px;
        margin-top: 6px;
    }
    .dateText {
        font-size: 11px;
        margin-top: 10px;
    }
    .commentDetails {
        font-size: 15px;
    }
    .fav_text {
        font-size: 14px !important;
    }
}
</style>