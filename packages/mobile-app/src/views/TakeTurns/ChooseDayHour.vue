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
    <!-- <Loading v-if="this.geted === 1" style="margin-top: 200px" /> -->

    <div class="bodyPart">
        <!-- operator card -->
        <div class="generalCard operatorCardBackground">
            <div class="operatorCard" >
                <img
                v-if="this.operator.cover_pic == null || this.operator.cover_pic == ''"
                src="../../assets/images/nopic.png"
                class="operatorPic"
                />
                <img
                v-else
                :src="this.baseurl+'/images/take_turns/'+this.operator.cover_pic"
                class="operatorPic"
                />
                <div class="generalColumn mr-2 mt-2">
                    <div style="font-weight: bold;">{{ this.operator.name }}</div>
                    <div class="mt-2" style="display: flex; color: #484B57;">
                        <img style="width:14px; margin-left: 10px;" src="../../assets/images/cityAddress.png">
                        {{ this.operator.address }}
                    </div>
                </div>
            </div>
        </div>
        <!-- operator card -->

        <!-- day choose -->
        <div class="textPart">
            <div class="turnBackground"></div>
            <h3 class="mt-3">انتخاب زمان نوبت‌دهی</h3>
        </div>
        <div id="dayListContainer" class="dayList" >
            <div v-for="(day, index) in daysList" :key="day.id">
                <va-card id="dayCardId" class="dayCard selectedDayMode" 
                v-if="index === 0"
                @click="getOtherDays(day.id, index, day.date, day.day)"
                color="white">
                    <va-card-content class="dayName" >{{ day.day }}</va-card-content>
                    <va-card-content class="dayDate">{{ day.date }}</va-card-content>
                </va-card>
                <va-card id="dayCardId" class="dayCard" 
                v-else
                @click="getOtherDays(day.id, index, day.date, day.day)"
                color="white">
                    <va-card-content v-if="day.day === 'جمعه'" class="dayName" style="color: red !important;">{{ day.day }}</va-card-content>
                    <va-card-content v-else class="dayName" >{{ day.day }}</va-card-content>
                    <va-card-content v-if="day.day === 'جمعه'" class="dayDate" style="color: red !important;">{{ day.date }}</va-card-content>
                    <va-card-content v-else class="dayDate">{{ day.date }}</va-card-content>
                </va-card>
            </div>
        </div>
        <!-- day choose -->

        <!-- hour choose -->
        <div style="display: flex; padding: 10px; margin-top: 30px;">
            <img style="width:14px; margin-left: 10px;" src="../../assets/images/hourChoose.png">
            <p class="textMobileSize" style="margin: 0; padding: 0; color: #15192A;">انتخاب ساعت</p>
            <p style="height: 18px; margin-right: 10px; color: #DBDBDB; font-weight: bold; overflow: hidden;">
                : : : : : : : : : : : : : : : : : : : : : : : : : : : : : : : : : : : : : : : : : : : : : : : :
            </p>
        </div>
        <div class="hourListContainer">
            <div v-if="this.todayHours" id="hourListId" class="myRow">
                <Loading v-if="this.geted === 1" style="margin-top: 0 !important; margin-right: 80%" />
                <div
                v-else
                v-for="(hour, index) in this.todayHours" :key="index"
                class="hoursLoopContainer">
                    <va-radio
                        v-if="hour[2] == 0"
                        id="radioHourId"
                        class="chosableHourStyle"
                        v-model="hourValue"
                        :option="hour[0]"
                        @click="changeChosenHourBack(index)"
                    >
                        <va-divider class="dividerClass mt-1" vertical dashed />
                        <p class="mr-2 mt-1">{{ hour[0] }}</p>
                    </va-radio>
                    <va-radio
                        v-else
                        class="chosableHourStyle"
                        v-model="hourValue"
                        disabled
                        :option="hour[0]"
                    >
                        <va-divider class="dividerClass mt-1" vertical dashed />
                        <p class="mr-2 mt-1">{{ hour[0] }}</p>
                        <img style="width:20px; margin-right: 10px;" src="../../assets/images/dashedBack.png">
                    </va-radio>
                </div>
            </div>
            <div v-else class="dayModeHours" style="padding: 10px;">
                <Loading v-if="this.geted === 1" style="margin-top: 0 !important; margin-right: 80%" />
                <p v-else>نوبتی برای این روز وجود ندارد.</p>
            </div>
            <div class="appointment_button generalNormalFlex" @click="this.checkInfo()">
                <p>ادامه</p>
            </div>
        </div>
        <!-- hour choose -->
    </div>

    <Footer :selected_num="3" />

    <div id="myModalll" class="modal" style="position: absolute !important;max-width: 540px">
        <!-- name and family name Modal content -->
        <div  class="modal-content" style="max-width: 540px; border-radius: 20px;">
            <div class="titleStyle">
                <div class="row">
                    <p style="width: 80%; padding:5% 5% 0 0; font-size: 25px;">رزرو نوبت</p>
                    <div style="width: 15%;margin:15px 0 10px 0;text-align: left">
                        <va-avatar square style="cursor: pointer; border-radius: 10px; border: 1px solid #D9DFE8;" size="small"  @click="this.close()" class="mr-4" color="white" text-color="#42526E"><span style="font-size: 25px; margin-top: 5px;">&times;</span></va-avatar>
                    </div>
                </div>
                <p style="width: 80%; padding:2% 10% 5% 0px; font-size: 12px; color: #70737D;">برای رزرو این تاریخ لطقا اسم خود را وارد کنید و روی دکمه رزور کلیک کنید</p>
            </div>
            <div class="showChosenDetails">
                <div class="pa-1 modalDetails">
                    <div class="topPart">
                        <img style="width:14px; margin-left: 10px;" src="../../assets/images/calendar.png">
                        <p>تاریخ:</p>
                    </div>
                    <div class="bottomPart">
                        {{ this.dayDateVar }}
                    </div>
                </div>
                <div class="pa-1 mr-2 modalDetails">
                    <div class="topPart">
                        <img style="width:14px; margin-left: 10px;" src="../../assets/images/hourChoose.png">
                        <p>روز و ساعت:</p>
                    </div>
                    <div class="bottomPart">
                        {{ this.dayNameVar }} - {{ this.hourValue }}
                    </div>
                </div>
            </div>
            <div style="width:96%; margin: 0 2% 0 2%; padding:5px 10px 10px 10px ; cursor: pointer; border-radius: 15px;">
                <div class="row" style="margin-bottom:5px;margin-top: 15px">
                    <p style="width: 100%">نام و نام خانوادگی:</p>
                </div>
                <div class="row" style="margin-bottom: 5px">
                    <input v-model="this.modalInputValue" type="text" class="comment">
                </div>
                <div class="comment_btn" style="margin: 15px 0 15px 0;text-align: center;" @click="this.goToPage('/approve-chosen-appointment',0, this.modalInputValue)">
                    <img style="width:24px " src="../../assets/images/taskSolidNotesEditCheck2.png">
                    <p style="color:white; font-size:18px; margin-right: 5px;">رزرو نوبت</p>
                </div>
            </div>
        </div>
        <!-- name and family name Modal content -->
    </div>
</template>

<script>
import Loading from "../../components/Loading.vue";
import Header from "../../components/Header.vue";
import Footer from "../../components/Footer.vue";
import SubHeader from "../../components/SubHeader.vue";
import SideMenu from "../../components/SideMenu.vue";
import LoadingButton from "../../components/LoadingButton.vue";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { GDialog } from 'gitart-vue-dialog'
import "swiper/css";
import "swiper/css/pagination";
import "swiper/css/scrollbar";
import "swiper/css/autoplay";

export default {
    name: "choose-day-hour",
    components: {
        Loading,
        SideMenu,
        Header,
        SubHeader,
        Footer,
        FontAwesomeIcon,
        LoadingButton,
        GDialog
    },
    created() {
        //getting operator and brancName from localStorage
        this.branchName = JSON.parse(localStorage.getItem("branchName"));
        this.operator = JSON.parse(localStorage.getItem("operatorDetails"));
        //getting operator and brancName from localStorage
        
    },
    mounted() {

        //getting request infoes from localStorage
        this.operatorId = JSON.parse(localStorage.getItem("operatorId"));
        this.skillId = JSON.parse(localStorage.getItem("skillId"));
        this.branchId = JSON.parse(localStorage.getItem("branchId"));
        //getting request infoes from localStorage

        //calling function for getting days and today hours
        this.getTodayDays(this.operatorId, this.branchId, this.skillId);
        //calling function for getting days and today hours
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

        //getting days and today hours func
        getTodayDays(operator, branchId, skillId) {
            this.geted = 1;
            const mydata = {
                action: "tt_reserve_info",
                operator_ref: operator,
                branch_ref: branchId,
                skill_ref: skillId
                
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
                    this.geted = 2;
                    if (response.data == null || response.data == ' ' || response.data == '' || response.data == undefined) {
                        this.$swal({
                            title: "جزئیاتی یافت نشد!",
                            text: "متأسفانه در این روز، برای اپراتور مورد نظر شما، نوبتی درج نشده است!",
                            icon: "warning",
                            confirmButtonText: "بسیار خب",
                            customClass: {
                                confirmButton: "btn btn-warning",
                            },
                            buttonsStyling: true,
                        });
                    } else {
                        console.log(response)
                        this.daysList = response.data.days;
                        this.dayDateVar = this.daysList[0].date;
                        this.dayNameVar = this.daysList[0].day;
                        localStorage.setItem("dayDateFs", JSON.stringify(this.daysList[0].date));
                        this.chosenDay = this.daysList[0].id;
                        this.todayHours = response.data.take_all;
                        console.log(this.todayHours)
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
        //getting days and today hours func

        //getting other days func
        getOtherDays(dateId, dayIndex, dayDateFs, dayName) {
            this.geted = 1;
            this.dayDateVar = dayDateFs;
            this.dayNameVar = dayName;
            localStorage.setItem("dayDateFs", JSON.stringify(dayDateFs));
            this.chosenDay = dateId;
            //change background color of chosen day card
            var dayElement = document.getElementById('dayListContainer');
            dayElement.children[0].children[0].classList.remove('selectedDayMode');
            for (let i = 1; i < dayElement.children.length; i++) {
                dayElement.children[i].children[0].classList.remove('selectedDayMode');
            }
            dayElement.children[dayIndex].children[0].classList.add('selectedDayMode');
            //change background color of chosen day card

            //request for chosen day hours
            const mydata = {
                action: "tt_day_info",
                operator_ref: this.operatorId,
                branch_ref: this.branchId,
                skill_ref: this.skillId,
                date_ref: dateId
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
                    console.log(response)
                if (response.data.ok === 1) {
                    this.geted = 2;
                    if (response.data == null || response.data == ' ' || response.data == '' || response.data == undefined) {
                        this.$swal({
                            title: "جزئیاتی یافت نشد!",
                            text: "متأسفانه در این روز، برای اپراتور مورد نظر شما، نوبتی درج نشده است!",
                            icon: "warning",
                            confirmButtonText: "بسیار خب",
                            customClass: {
                                confirmButton: "btn btn-warning",
                            },
                            buttonsStyling: true,
                        });
                    } else {
                        this.todayHours = response.data.take_all;
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
                //request for chosen day hours
        },
        //getting other days func

        //getting chosen hour and changing chosen hour background funcs
        changeChosenHourBack(index) {
            // console.log(document.getElementById("hourListId").children[index].children[0].classList)
            var hourListVar = document.getElementById("hourListId").children;
            for (var i = 0; i < hourListVar.length; i++) {
                console.log(hourListVar[i].children[0].classList)
                hourListVar[i].children[0].classList.remove('chosenHourStyle');
                hourListVar[i].children[0].classList.add('chosableHourStyle');
            }
            document.getElementById("hourListId").children[index].children[0].classList.remove('chosableHourStyle');
            document.getElementById("hourListId").children[index].children[0].classList.add('chosenHourStyle');
        },
        //getting chosen hour and changing chosen hour background funcs

        //checking necessary infoes before going to next page
        checkInfo() {
            if (this.hourValue) {
                var modal = document.getElementById("myModalll");
                modal.style.display = "block";
            } else {
                this.$swal({
                    title: "هشدار!",
                    text: 'لطفا ابتدا ساعت مورد نظرتان را انتخاب نمایید!',
                    icon: "warning",
                    confirmButtonText: "باشه",
                    customClass: {
                        confirmButton: "btn btn-warning",
                    },
                    buttonsStyling: true,
                });
            }
        },
        //checking necessary infoes before going to next page

        //closing modal func
        close(){
            var modal = document.getElementById("myModalll");
            modal.style.display = "none";
        },
        //closing modal func

        //going to next page func
        goToPage(page, pageref, userName) {
            console.log(localStorage.getItem("tk"))
            if (localStorage.getItem("tk") === null || localStorage.getItem("tk") === undefined || localStorage.getItem("tk") === '') {
                    this.loginDialog = true;
            } else {
                if (userName) {
                    localStorage.setItem("userName", JSON.stringify(userName));
                    localStorage.setItem("appointmentDay", JSON.stringify(this.chosenDay));
                    localStorage.setItem("appointmentHour", JSON.stringify(this.hourValue));
                    localStorage.setItem("timeOfDay", JSON.stringify(this.timeOfDay));
                    localStorage.setItem("dayNameVar", JSON.stringify(this.dayNameVar));
                    if (pageref > 0) {
                        this.$router.push({ path: page ,query:{ pageref: pageref } });
                    } else {
                        this.$router.push({path: page});
                    }
                } else {
                    this.$swal({
                    title: "هشدار!",
                    text: 'وارد نمودن نام و نام خانوادگی الزامی است!',
                    icon: "warning",
                    confirmButtonText: "باشه",
                    customClass: {
                        confirmButton: "btn btn-warning",
                    },
                    buttonsStyling: true,
                });
                }
                
                    
            }
        },
        //going to next page func
    },
    data() {
        return {
            geted: 1,
            hourValue: false,
            openMenu: false,
            loginDialog: false,
            operator: null,
            branchName: null,
            todayResponse: null,
            chosenDay: null,
            dayDateVar: null,
            dayNameVar: null,
            operatorId: null,
            skillId: null,
            branchId: null,
            modalInputValue: null,
            timeOfDay: null,
            daysList: [],
            todayHours: [],
        }
    },
}
</script>

<style scoped>
.bodyPart {
    min-height: 560px;
}
.generalCard {
    text-align: center;
    padding: 10px;
}
.operatorCardBackground {
    background: url("../../assets/images/operatorCardBack.png");
    background-size: cover;
    background-repeat: no-repeat;
}
.operatorCard {
    display: flex;
    flex-flow: column;
    align-items: center;
    margin-top: 27px;
    margin-right: -4px;
    border-radius: 5px;
}
.generalColumn {
    display: flex;
    flex-flow: column;
    align-items: center;
    justify-content: space-around;
}
.operatorPic {
    width: 180px;
    height: 180px;
    border-radius: 15px;
}
.textPart {
    position: relative;
    padding: 10px;
    text-align: center;
    margin-top: 30px;
}
.turnBackground {
    position: absolute;
    width: 200px;
    height: 200px;
    background: url("../../assets/images/hoursBack.png");
    background-size: 150px 100px;
    background-repeat: no-repeat;
    margin-top: -40px;
    margin-right: 135px;
}
.dayList {
    display: flex;
    justify-content: flex-start;
    align-items: center;
    overflow: scroll;
    margin-top: 30px;
    height: 100px;
    /*-ms-overflow-style: none;  IE and Edge */
    /*scrollbar-width: none;   Firefox */
}
/*.dayList::-webkit-scrollbar {
    display: none;
}*/
.hourListContainer {
    padding: 10px;
    display: flex;
    flex-flow: column;
    justify-content: center;
    align-items: center;
}
.selectedDayMode {
    background: #3B0056 !important;
    color: white !important;
}
.selectedDayMode .dayName {
    color: white;
}
.selectedDayMode .dayDate {
    color: white;
}
.hoursLoopContainer {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 45%;
}
.chosableHourStyle {
    background-color: white;
    border-radius: 8px;
    padding: 5px;
    cursor: pointer;
}
.chosenHourStyle {
    background-color: #B88E68;
    border-radius: 8px;
    padding: 5px;
    cursor: pointer;
}
.dividerClass {
    vertical-align: top !important;
    height: 18px;
    border-color: #CBCBCB !important;
    margin-right: 15px;
}
.dayCard {
    display: flex;
    flex-flow: column;
    justify-content: center !important;
    align-items: center !important;
    color: white !important;
    margin-right: 5px;
    width: 100px !important;
    cursor: pointer;
  background: white;
}
.dayName {
    width: 100px;
    text-align: center !important;
    color: #484B57;
}
.dayDate {
    width: 100px;
    text-align: center !important;
    font-size: 12px;
    color: #484B57;
}
.generalNormalFlex {
    display: flex;
    justify-content: center;
    align-items: center;
}
.appointment_button {
    width: 90%;
    height: 40px;
    background-color: #3B0056;
    color: white;
    margin: 35px 0 25px 0;
    border-radius: 10px;
    align-self: center !important;
    cursor: pointer;
}
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
    -webkit-animation-name: fadeIn; /* Fade in the background */
    -webkit-animation-duration: 0.4s;
    animation-name: fadeIn;
    animation-duration: 0.4s
}
.titleStyle {
    display: flex;
    flex-flow: column;
    background-color: #F6F6F6;
    border-top-left-radius: 20px;
    border-top-right-radius: 20px;
}
.showChosenDetails {
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 10px;
}
.modalDetails {
    width: 100%;
    height: 60px;
    border: 1px solid #EFF2F1;
    border-radius: 10px;
}
.topPart {
    display: flex;
    padding: 5px;
    background-color: #F8FAFB;
    border-top-right-radius: 20px;
    border-top-left-radius: 20px;
}
.bottomPart {
    padding: 5px;
}
.modal-content {
    position: fixed;
    bottom: 30%;
    background-color: #fefefe;
    width: 100%;
    -webkit-animation-name: slideIn;
    -webkit-animation-duration: 0.4s;
    animation-name: slideIn;
    animation-duration: 0.4s
}
.row{
    padding:0 2% 0 2%;
    align-items: stretch;
    display: flex;
    flex-direction: row;
    flex-wrap: nowrap;
    overflow-x: auto;
    overflow-y: hidden;
    -ms-overflow-style: none;  /* IE and Edge */
    scrollbar-width: none;  /* Firefox */
}
.myRow {
    width: 100%;
    padding:0 2% 0 2%;
    align-items: stretch;
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
    overflow-x: auto;
    overflow-y: hidden;
    -ms-overflow-style: none;  /* IE and Edge */
    scrollbar-width: none;  /* Firefox */
}
.row::-webkit-scrollbar {
    display: none;
}
.comment_btn{
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
    margin:3%;
    height: 45px;
    background-color: #3B0056;
    color:white;
    border-radius: 10px;
    border:unset;
    cursor: pointer;
}
.comment{
    width: 96%;
    height: 40px;
    text-align: right;
    direction: rtl;
    outline: none !important;
    border:1px solid #8a8a8a;
    border-radius: 10px;
    padding: 10px;
}
@media only screen and (max-width: 535px) {
    .textMobileSize {
        font-size: 11px;
    }
    .dayModeHours {
        grid-template-columns: repeat(2, 1fr);
        grid-template-rows: repeat(2, 40px);
    }
    .hourListContainer {
        padding: 0px;
    }
    .hoursLoopContainer {
        width: 42%;
        margin-right: 3%;
    }
    .myRow {
        padding: 0;
    }
}
@media only screen and (max-width: 436px) {
    .bodyPart {
        min-height: 750px;
    }
}
@media only screen and (max-width: 426px) {
    .turnBackground {
        margin-right: 75px;
    }
}
@media only screen and (max-width: 376px) {
    .turnBackground {
        margin-right: 55px;
    }
}
@media only screen and (max-width: 321px) {
    .turnBackground {
        margin-right: 25px;
    }
}
</style>
<style>
.va-input-wrapper__container {
    display: flex;
    border: 1px solid black;
    border-radius: 5px;
    align-items: center;
}
</style>
<style>
.va-radio__icon__background {
    background-color: white !important; 
}
.va-radio__text {
    width: 200px;
}
.va-radio:hover .va-radio__icon__background, .va-radio__input:focus+.va-radio__icon .va-radio__icon__background {
    opacity: 0; 
}
@media only screen and (max-width: 426px) {
    .va-radio__text {
        width: 130px;
    }
}
@media only screen and (max-width: 376px) {
    .va-radio__text {
        width: 125px;
    }
}
@media only screen and (max-width: 321px) {
    .va-radio__text {
        width: 100px;
    }
}
</style>