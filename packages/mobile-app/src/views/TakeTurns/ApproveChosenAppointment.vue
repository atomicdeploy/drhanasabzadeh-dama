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
<!--     <Loading v-if="this.geted === 1" style="margin-top: 80px" />-->

    <div v-if="this.showPage === true" class="mainColumn">
        <div style="width: 100%; padding: 10px;">
            <!-- operator card -->
            <div class="generalCard">
                <div class="operatorCard">
                    <img
                    v-if="this.paymentInfo.operator_pic == null || this.paymentInfo.operator_pic == ''"
                    src="../../assets/images/nopic.png"
                    class="operatorPic"
                    />
                    <img
                    v-else
                    :src="this.baseurl+'/images/take_turns/'+this.paymentInfo.operator_pic"
                    class="operatorPic"
                    />
                    <div class="generalColumn">
                        <div class="mb-3" style="font-weight: bold;">{{ this.paymentInfo.operator_name }}</div>
                        <div>
                            <va-rating
                                v-if="this.paymentInfo.operator_rate"
                                v-model="this.paymentInfo.operator_rate"
                                class="ratingStar mb-3"
                                color="warning"
                            />
                          <va-rating
                             v-else
                              v-model="this.defStar"
                              class="ratingStar mb-3"
                              color="warning"
                          />

                        </div>
                        <div style="display: flex; color: #484B57;">
                            <img style="width:14px; margin-left: 10px;" src="../../assets/images/cityAddress.png">
                            {{ this.paymentInfo.branch_name }}
                        </div>
                    </div>
                </div>
            </div>
            <!-- operator card -->
            <!-- payment Info card -->
            <div class="generalCard">
                <div class="showChosenDetails">
                    <div class="pa-1 reserveDetails">
                        <div class="topPart">
                            <img style="width:14px; margin-left: 10px;" src="../../assets/images/calendar.png">
                            <p>تاریخ:</p>
                        </div>
                        <div class="bottomPart">
                            {{ this.paymentInfo.reserve_date }}
                        </div>
                    </div>
                    <div class="pa-1 mr-2 reserveDetails">
                        <div class="topPart">
                            <img style="width:14px; margin-left: 10px;" src="../../assets/images/hourChoose.png">
                            <p>روز و ساعت:</p>
                        </div>
                        <div class="bottomPart">
                            {{ this.dayNameVar }} - {{ this.paymentInfo.reserve_time }}
                        </div>
                    </div>
                </div>
                <div class="operatorDtailsContainer">
                    <div class="detailCard" >
                        <div class="cardTitle">
                            شعبه:
                        </div>
                        <p>{{ this.paymentInfo.branch_name }}</p>
                    </div>
                    <div class="detailCard" >
                        <div class="cardTitle">
                            خدمات:
                        </div>
                        <p>{{ this.paymentInfo.skill_name }}</p>
                    </div>
                    <div class="detailCard" >
                        <div class="cardTitle">
                            اپراتور:
                        </div>
                        <p>{{ this.paymentInfo.operator_name }}</p>
                    </div>
                    <div>
                        <div class="detailCard">
                            <div class="cardTitle">
                                آدرس:
                            </div>
                            <p>{{ this.paymentInfo.address }}</p>
                        </div>
                    </div>
                </div>
                <div class="paymentInfoContainer">
                    <p style="font-size: 20px; font-weight: bold; color: #70737D;">مبلغ قابل پرداخت</p>
                    <div style="display: flex;">
                        <p class="mt-2" style="color: red;">{{ this.formattedPrice }}</p>
                        <p class="mt-2 mr-2">تومان</p> 
                    </div>
                </div>
                <!-- payment Button -->
                <div v-if="this.geted === 1" class="payment_button generalNormalFlex mt-4" >
                    <LoadingButton/>
                </div>

                <div v-else class="payment_button generalNormalFlex mt-4" @click="this.getPaymentPortalLink(this.operatorId, this.skillId, this.branchId, this.chosenDay, this.chosenHour, this.userName)">
                    <p>پرداخت و ثبت نوبت</p>
                </div>
                <!-- payment Button -->
            </div>
            <!-- payment Info card -->
        </div>
        

    </div>

    <Footer :selected_num="3" />
</template>

<script>
import Loading from "../../components/Loading.vue";
import LoadingButton from '../../components/LoadingButton.vue';
import Header from "../../components/Header.vue";
import Footer from "../../components/Footer.vue";
import SubHeader from "../../components/SubHeader.vue";
import SideMenu from "../../components/SideMenu.vue";
import { GDialog } from 'gitart-vue-dialog'
import "swiper/css";
import "swiper/css/pagination";
import "swiper/css/scrollbar";
import "swiper/css/autoplay";

export default {
    name: "approve-chosen-appointment",
    components: {
        Loading,
        LoadingButton,
        SideMenu,
        Header,
        SubHeader,
        Footer,
        GDialog
    },
    mounted() {
        this.dayNameVar = JSON.parse(localStorage.getItem("dayNameVar"));
        this.operatorId = JSON.parse(localStorage.getItem("operatorId"));
        this.skillId = JSON.parse(localStorage.getItem("skillId"));
        this.branchId = JSON.parse(localStorage.getItem("branchId"));
        this.chosenDay = JSON.parse(localStorage.getItem("appointmentDay"));
        this.chosenHour = JSON.parse(localStorage.getItem("appointmentHour"));
        this.userName = JSON.parse(localStorage.getItem("userName"));
        this.timeOfDay = JSON.parse(localStorage.getItem("timeOfDay"));
        this.checkAppointmentInfoApprove(this.operatorId, this.skillId, this.branchId, this.chosenDay, this.chosenHour, this.userName);
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

        //put comma per 3 digits func
        putComma(number) {
            this.formattedPrice = number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        },
        //put comma per 3 digits func

        //checking if appointment info needs payment or not func
        checkAppointmentInfoApprove(operatorId, skillId, branchId, chosenDay, chosenHour, userName) {
            const mydata = {
                action: "tt_do_reserve",
                operator_ref: operatorId,
                skill_ref: skillId,
                branch_ref: branchId,
                date_ref: chosenDay,
                time: chosenHour,
                name: userName
                
            };
          this.geted = 1;
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
                            text: "متأسفانه، جزئیاتی برای اطلاعات ارسال به سرور یافت نشد!",
                            icon: "warning",
                            confirmButtonText: "بسیار خب",
                            customClass: {
                                confirmButton: "btn btn-warning",
                            },
                            buttonsStyling: true,
                        });
                    } else {
                        this.paymentInfo = response.data;
                        console.log(this.paymentInfo)
                        if (this.paymentInfo.has_pay === 1) {
                            this.showPage = true;
                            //put comma per 3 digits for price
                            this.putComma(this.paymentInfo.price);
                            //put comma per 3 digits for price
                            this.geted = 2;
                        } else {
                            this.geted = 2;
                            this.showPage = false;
                            this.goToPage('/successful-payment', 0);
                        }
                        
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
        },
        //checking if appointment info needs payment or not func

        //get the payment portal link func
        ___getPaymentPortalLink(operatorId, skillId, branchId, chosenDay, chosenHour, userName) {
            this.geted = 1;
            const mydata = {
                action: "tt_pay_link",
                operator_ref: operatorId,
                branch_ref: branchId,
                skill_ref: skillId,
                date_ref: chosenDay,
                time: chosenHour,
                name: userName
                
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
                    this.geted=0;
                    if (response.data == null || response.data == ' ' || response.data == '' || response.data == undefined) {
                        this.$swal({
                            title: "جزئیاتی یافت نشد!",
                            text: "متأسفانه، جزئیاتی برای اطلاعات ارسال به سرور یافت نشد!",
                            icon: "warning",
                            confirmButtonText: "بسیار خب",
                            customClass: {
                                confirmButton: "btn btn-warning",
                            },
                            buttonsStyling: true,
                        });
                    } else {
                        console.log(response.data)
                        // this.goToPage(response.data.url, 0);
                        // window.open(response.data.url);
                        window.location.replace(response.data.url);
                    }
                } else {
                    this.geted=0;
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
                    this.geted=0;
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
      getPaymentPortalLink(operatorId, skillId, branchId, chosenDay, chosenHour, userName) {
        this.geted = 1;
        const mydata = {
          // action: "tt_pay_link",
          operator_ref: operatorId,
          branch_ref: branchId,
          skill_ref: skillId,
          date_ref: chosenDay,
          time: chosenHour,
          name: userName
        };
        var jsonString = JSON.stringify(mydata);
        localStorage.setItem('PayData', jsonString);
        localStorage.setItem('typeGl', 'TakeTurn');
        localStorage.setItem('subRefGl', '0');
        localStorage.setItem('CourseRef', '0');
        localStorage.setItem('CourseRefGl', '0');
        localStorage.setItem('CounselingRefGl', '0');
        this.$router.push({ path: '/invoice'})
      },
        //get the payment portal link func
        
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
            geted: 0,
            openMenu: false,
            loginDialog: false,
            showPage: false,
            dayNameVar: null,
            operatorId: null,
            skillId: null,
            branchId: null,
            chosenDay: null,
            chosenHour: null,
            userName: null,
            paymentInfo: null,
            timeOfDay: null,
            formattedPrice: null,
          defStar:5
        }
    }
}
</script>

<style scoped>
.generalCard {
    width: 100%;
    text-align: center;
    padding: 10px;
    margin-top: 10px;
    background: white !important;
    border: 2px dashed #E5E5E5;
    border-radius: 10px;
}
.operatorCard {
    width: 100%;
    display: flex;
    align-items: center;
}
.operatorPic {
    width: 28%;
    height: 130px !important;
    border-radius: 5px;
}
.generalColumn {
    display: flex;
    flex-flow: column;
    align-items: flex-start;
    justify-content: space-around;
    margin-right: 10px;
}
.mainColumn {
    display: flex;
    flex-flow: column;
    justify-content: space-between;
    align-items: center;
    width: 100%;
    height: 100%;
    background-color: #EEEEEE;
}
.topPart {
    width: 100% !important;
}
.textPart {
    padding: 10px;
    align-self: flex-start;
}
.showChosenDetails {
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 10px;
}
.reserveDetails {
    width: 100%;
    height: 60px;
    border: 2px solid #EFF2F1;
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
    display: flex;
    padding: 5px;
}
.paymentInfoContainer {
    width: 100%;
    display: flex;
    flex-flow: column;
    justify-content: center;
    align-items: center;
    padding: 10px;
    border: 2px dashed #E5E5E5;
    border-radius: 10px;
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
    border: 2px solid #EFF2F1;
    border-radius: 10px;
}
.cardTitle {
    display: flex;
    width: 100px;
    padding: 10px;
    background-color: #F8FAFB;
    border-radius: 10px;
    margin-left: 10px;
}
.payment_button {
    width: 100%;
    height: 60px;
    margin-bottom: 40px !important;
    background-color: #3B0056;
    color: white;
    border-radius: 10px;
    align-self: center !important;
    cursor: pointer;
}
.generalNormalFlex {
    display: flex;
    justify-content: center;
    align-items: center;
}
</style>