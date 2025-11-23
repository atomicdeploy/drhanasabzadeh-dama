<template>
    <!-- login GDialog -->
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
    <!-- login GDialog -->
    <!-- abort appointment GDialog -->
    <GDialog v-model="this.abortDialog" max-width="500" >
        <div class="wrapper" style="">
            <div class="content">
                <div style="width: 100%;text-align: center">
                  <font-awesome-icon icon="fa-solid fa-circle-exclamation" :style="{ color: '#ff6b6b',position:'relative',top:'2px',fontSize:'52px',margin:'10px 0 10px 0' }"/>

                </div>
                <div style="width: 100%;text-align: center;font-size: 18px;font-weight: bold;padding: 10px">لغو نوبت</div>

                <p style="width: 100%;text-align: center;font-size: 14px;padding: 10px 0 10px 0">
                آیا از لغو نوبت رزرو شده اطمینان دارید؟
                </p>
            </div>
        </div>
        <div class="row" style="padding: unset;margin-top: 15px ">

            <div @click="this.abortDialog=false" style="width: 50%;text-align: center;background: #ff6b6b;padding: 10px 0 10px 0; color:white;">خیر</div>
          <div @click="this.abortAppointment()" style="width: 50%;text-align: center;background: #bec4c2;padding: 10px 0 10px 0;color:white;">بله</div>
        </div>
    </GDialog>
    <!-- abort appointment GDialog -->
    <Header @headeropenMenu="this.headerOpenMenu()" :isHome="0" />
    <SideMenu
        :openMenu="this.openMenu"
        @headercloseMenu="this.headerCloseMenu()"
        :group_ref="0"
    />
    <Loading v-if="this.geted === 1" style="margin-top: 80px" />

    <div class="bodyPart">
        <!-- appointments tabs -->
        <div v-if="this.geted === 2" class="appointmentTabsContainer">
            <va-tabs
            v-model="this.tabValue"
            hideSlider
            class="appointmentTabs"
            >
                <va-tab
                v-for="(tab, index) in appointmentActives"
                :key="index"
                :name="index"
                color="primary"
                >
                {{ tab }}
                </va-tab>
            </va-tabs>
        </div>
        <!-- appointments tabs -->
        
        <!-- all appointments list -->
        <div v-if="this.tabValue===0 && this.geted === 2">
            <div class="noAppointments" v-if="myAppointments == null || myAppointments == [] || myAppointments == '' || myAppointments == undefined">
                <img src="../../assets/images/nopic.png"/>
            </div>
            <div v-else v-for="appointment in myAppointments" :key="appointment.id">
                <div class="generalCard" >
<!--                    <div class="operatorCard">-->
                        <div class="rightPart">
                            <img
                            v-if="appointment.operator_pic == null || appointment.operator_pic == ''"
                            src="../../assets/images/nopic.png"
                            class="operatorPic"
                            />
                            <img
                            v-else
                            :src="this.baseurl+'/images/take_turns/'+appointment.operator_pic"
                            class="operatorPic"
                            />
                            <div class="generalColumn">
                                <div class="appContent">{{ appointment.operator_name }}</div>
                                <div class="appContent">{{ appointment.skill_name }}</div>
                                <div class="appContent">بیعانه: {{ appointment.price }} تومان</div>
                                <div class="appContent">تاریخ نوبت: {{ appointment.reserve_time+" "+appointment.reserve_date }}</div>
                              <div class="myroww">
                                <div v-if="appointment.active === 1 || appointment.active === 2 || appointment.active === 3" class="showActive">
                                  {{ appointment.active_name }}
                                </div>
                                <div v-else-if="appointment.active === 4" class="showActiveMissed">
                                  {{ appointment.active_name }}
                                </div>
                                <div v-else-if="appointment.active === 5" class="showActiveAborted">
                                  {{ appointment.active_name }}
                                </div>
                                <div v-if="appointment.active === 1" class="abortAppointment" @click="this.showAbortDialog(appointment.id)">لغو نوبت <font-awesome-icon icon="fa-solid fa-angle-left" :style="{ color: 'white',position:'relative',top:'2px',fontSize:'11px' }"/></div>
                                <div v-else-if="appointment.active === 2 || appointment.active === 3" class="commentAppointment" @click="this.open(appointment.id)">ثبت نظر<font-awesome-icon icon="fa-solid fa-angle-left" :style="{ color: 'white',position:'relative',top:'2px',fontSize:'11px',marginRight:'5px' }"/></div>
                              </div>
                            </div>

                        </div>
                        <div class="leftPart">

                        </div>
<!--                    </div>-->
                </div>
            </div>
        </div>
        <!-- all appointments list -->

        <!-- reserved appointments list -->
      <div v-if="this.tabValue===1 && this.geted === 2">
        <div class="noAppointments" v-if="myAppointments == null || myAppointments == [] || myAppointments == '' || myAppointments == undefined">
          <img src="../../assets/images/nopic.png"/>
        </div>
        <div v-else v-for="appointment in myAppointments" :key="appointment.id">
          <div class="generalCard" v-if="appointment.active === 1">
            <!--                    <div class="operatorCard">-->
            <div class="rightPart">
              <img
                  v-if="appointment.operator_pic == null || appointment.operator_pic == ''"
                  src="../../assets/images/nopic.png"
                  class="operatorPic"
              />
              <img
                  v-else
                  :src="this.baseurl+'/images/take_turns/'+appointment.operator_pic"
                  class="operatorPic"
              />
              <div class="generalColumn">
                <div class="appContent">{{ appointment.operator_name }}</div>
                <div class="appContent">{{ appointment.skill_name }}</div>
                <div class="appContent">بیعانه: {{ appointment.price }} تومان</div>
                <div class="appContent">تاریخ نوبت: {{ appointment.reserve_time+" "+appointment.reserve_date }}</div>
                <div class="myroww">
                  <div v-if="appointment.active === 1 || appointment.active === 2 || appointment.active === 3" class="showActive">
                    {{ appointment.active_name }}
                  </div>
                  <div v-else-if="appointment.active === 4" class="showActiveMissed">
                    {{ appointment.active_name }}
                  </div>
                  <div v-else-if="appointment.active === 5" class="showActiveAborted">
                    {{ appointment.active_name }}
                  </div>
                  <div v-if="appointment.active === 1" class="abortAppointment" @click="this.showAbortDialog(appointment.id)">لغو نوبت <font-awesome-icon icon="fa-solid fa-angle-left" :style="{ color: 'white',position:'relative',top:'2px',fontSize:'11px' }"/></div>
                  <div v-else-if="appointment.active === 2 || appointment.active === 3" class="commentAppointment" @click="this.open(appointment.id)">ثبت نظر<font-awesome-icon icon="fa-solid fa-angle-left" :style="{ color: 'white',position:'relative',top:'2px',fontSize:'11px' }"/></div>
                </div>
              </div>

            </div>
            <div class="leftPart">

            </div>
            <!--                    </div>-->
          </div>
        </div>
      </div>
        <!-- reserved appointments list -->

        <!-- visited appointments list -->
      <div v-if="this.tabValue===2 && this.geted === 2">
        <div class="noAppointments" v-if="myAppointments == null || myAppointments == [] || myAppointments == '' || myAppointments == undefined">
          <img src="../../assets/images/nopic.png"/>
        </div>
        <div v-else v-for="appointment in myAppointments" :key="appointment.id">
          <div class="generalCard" v-if="appointment.active === 2">
            <!--                    <div class="operatorCard">-->
            <div class="rightPart">
              <img
                  v-if="appointment.operator_pic == null || appointment.operator_pic == ''"
                  src="../../assets/images/nopic.png"
                  class="operatorPic"
              />
              <img
                  v-else
                  :src="this.baseurl+'/images/take_turns/'+appointment.operator_pic"
                  class="operatorPic"
              />
              <div class="generalColumn">
                <div class="appContent">{{ appointment.operator_name }}</div>
                <div class="appContent">{{ appointment.skill_name }}</div>
                <div class="appContent">بیعانه: {{ appointment.price }} تومان</div>
                <div class="appContent">تاریخ نوبت: {{ appointment.reserve_time+" "+appointment.reserve_date }}</div>
                <div class="myroww">
                  <div v-if="appointment.active === 1 || appointment.active === 2 || appointment.active === 3" class="showActive">
                    {{ appointment.active_name }}
                  </div>
                  <div v-else-if="appointment.active === 4" class="showActiveMissed">
                    {{ appointment.active_name }}
                  </div>
                  <div v-else-if="appointment.active === 5" class="showActiveAborted">
                    {{ appointment.active_name }}
                  </div>
                  <div v-if="appointment.active === 1" class="abortAppointment" @click="this.showAbortDialog(appointment.id)">لغو نوبت <font-awesome-icon icon="fa-solid fa-angle-left" :style="{ color: 'white',position:'relative',top:'2px',fontSize:'11px' }"/></div>
                  <div v-else-if="appointment.active === 2 || appointment.active === 3" class="commentAppointment" @click="this.open(appointment.id)">ثبت نظر<font-awesome-icon icon="fa-solid fa-angle-left" :style="{ color: 'white',position:'relative',top:'2px',fontSize:'11px' }"/></div>
                </div>
              </div>

            </div>
            <div class="leftPart">

            </div>
            <!--                    </div>-->
          </div>
        </div>
      </div>
        <!-- visited appointments list -->

        <!-- missed appointments list -->
      <div v-if="this.tabValue===3 && this.geted === 2">
        <div class="noAppointments" v-if="myAppointments == null || myAppointments == [] || myAppointments == '' || myAppointments == undefined">
          <img src="../../assets/images/nopic.png"/>
        </div>
        <div v-else v-for="appointment in myAppointments" :key="appointment.id">
          <div class="generalCard" v-if="appointment.active === 3">
            <!--                    <div class="operatorCard">-->
            <div class="rightPart">
              <img
                  v-if="appointment.operator_pic == null || appointment.operator_pic == ''"
                  src="../../assets/images/nopic.png"
                  class="operatorPic"
              />
              <img
                  v-else
                  :src="this.baseurl+'/images/take_turns/'+appointment.operator_pic"
                  class="operatorPic"
              />
              <div class="generalColumn">
                <div class="appContent">{{ appointment.operator_name }}</div>
                <div class="appContent">{{ appointment.skill_name }}</div>
                <div class="appContent">بیعانه : {{ appointment.price }} تومان</div>
                <div class="appContent">تاریخ نوبت: {{ appointment.reserve_time+" "+appointment.reserve_date }}</div>
                <div class="myroww">
                  <div v-if="appointment.active === 1 || appointment.active === 2 || appointment.active === 3" class="showActive">
                    {{ appointment.active_name }}
                  </div>
                  <div v-else-if="appointment.active === 4" class="showActiveMissed">
                    {{ appointment.active_name }}
                  </div>
                  <div v-else-if="appointment.active === 5" class="showActiveAborted">
                    {{ appointment.active_name }}
                  </div>
                  <div v-if="appointment.active === 1" class="abortAppointment" @click="this.showAbortDialog(appointment.id)">لغو نوبت <font-awesome-icon icon="fa-solid fa-angle-left" :style="{ color: 'white',position:'relative',top:'2px',fontSize:'11px' }"/></div>
                  <div v-else-if="appointment.active === 2 || appointment.active === 3" class="commentAppointment" @click="this.open(appointment.id)">ثبت نظر<font-awesome-icon icon="fa-solid fa-angle-left" :style="{ color: 'white',position:'relative',top:'2px',fontSize:'11px' }"/></div>
                </div>
              </div>

            </div>
            <div class="leftPart">

            </div>
            <!--                    </div>-->
          </div>
        </div>
      </div>
        <!-- missed appointments list -->

        <!-- aborted appointments list -->
      <div v-if="this.tabValue===4 && this.geted === 2">
        <div class="noAppointments" v-if="myAppointments == null || myAppointments == [] || myAppointments == '' || myAppointments == undefined">
          <img src="../../assets/images/nopic.png"/>
        </div>
        <div v-else v-for="appointment in myAppointments" :key="appointment.id">
          <div class="generalCard" v-if="appointment.active === 4">
            <!--                    <div class="operatorCard">-->
            <div class="rightPart">
              <img
                  v-if="appointment.operator_pic == null || appointment.operator_pic == ''"
                  src="../../assets/images/nopic.png"
                  class="operatorPic"
              />
              <img
                  v-else
                  :src="this.baseurl+'/images/take_turns/'+appointment.operator_pic"
                  class="operatorPic"
              />
              <div class="generalColumn">
                <div class="appContent">{{ appointment.operator_name }}</div>
                <div class="appContent">{{ appointment.skill_name }}</div>
                <div class="appContent">بیعانه: {{ appointment.price }} تومان</div>
                <div class="appContent">تاریخ نوبت: {{ appointment.reserve_time+" "+appointment.reserve_date }}</div>
                <div class="myroww">
                  <div v-if="appointment.active === 1 || appointment.active === 2 || appointment.active === 3" class="showActive">
                    {{ appointment.active_name }}
                  </div>
                  <div v-else-if="appointment.active === 4" class="showActiveMissed">
                    {{ appointment.active_name }}
                  </div>
                  <div v-else-if="appointment.active === 5" class="showActiveAborted">
                    {{ appointment.active_name }}
                  </div>
                  <div v-if="appointment.active === 1" class="abortAppointment" @click="this.showAbortDialog(appointment.id)">لغو نوبت <font-awesome-icon icon="fa-solid fa-angle-left" :style="{ color: 'white',position:'relative',top:'2px',fontSize:'11px' }"/></div>
                  <div v-else-if="appointment.active === 2 || appointment.active === 3" class="commentAppointment" @click="this.open(appointment.id)">ثبت نظر<font-awesome-icon icon="fa-solid fa-angle-left" :style="{ color: 'white',position:'relative',top:'2px',fontSize:'11px' }"/></div>
                </div>
              </div>

            </div>
            <div class="leftPart">

            </div>
            <!--                    </div>-->
          </div>
        </div>
      </div>
        <!-- aborted appointments list -->
    </div>
    

    <Footer :selected_num="3" />

    <div v-if="this.geted === 2" id="myModal" class="modal">
        <!-- comment Modal content -->
        <div  class="modal-content" style="max-width: 540px;border-radius: 20px;margin: 0 2% 0 2%;width: 96%">
            <div class="row" style="margin: 15px 0 15px 0">
                <p style="width: 100%; margin: 10px 10px 0 0;">نظر و امتیاز شما به خدمات:</p>
                <div style="width: 15%;margin:0 0 0 10px;text-align: left">
                    <va-avatar style="cursor: pointer" size="small"  @click="this.close()" class="mr-4" color="red"><span style="font-size: 35px;margin-top: 5px">&times;</span></va-avatar>
                </div>
            </div>

          <p style="width: 100%; margin: 10px 10px 0 0;">امتیاز شما :</p>
          <va-rating  v-model="this.rate" style="cursor: pointer;direction: ltr;margin: 0 0 15px 17px;" color="warning"/>

            <div class="row" style="margin-bottom: 5px">
                <textarea v-model="this.comment" type="tel" class="comment"></textarea>
            </div>
          <div class="row mb-3" >
            <label for="file-upload"  class="custom-file-upload" style="width: 30%;height:35px;background-color: #6C9FD8;color: white;text-align: center;border-radius: 25px;padding: 8px 0 8px 0;cursor: pointer">
              افزودن عکس
            </label>
            <input id="file-upload" style="display:none" type="file" @change="getFileName()"/>

          </div>
          <pre v-if="this.filename!==''" style="color: #8d8c8c;direction: ltr;padding: 5px 0 0 5px">{{this.filename}}</pre>
            <div style="width:96%;margin: 0 2% 0 2%;padding:5px 10px 10px 10px;border-radius: 15px;">
                <button @click="this.sendComment()" class="comment_btn" type="button" style="margin: 5px 0 0 0;text-align: center;">
                    ثبت نظر
                </button>
            </div>
        </div>
        <!-- comment Modal content -->
    </div>
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
import { faAngleLeft,faCircleExclamation} from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
library.add(faAngleLeft,faCircleExclamation)

export default {
    name: "my-appointments",
    components: {
        Loading,
        SideMenu,
        Header,
        SubHeader,
        Footer,
        LoadingButton,
        GDialog,FontAwesomeIcon
    },
    created() {
        this.getAppointments();
    },
    methods: {
        //header menu funcs
        getFileName(){
          this.filename= document.getElementById("file-upload").value;
        },
        headerOpenMenu() {
            this.openMenu = true;
            console.log("homeOpenMenu");
        },
        headerCloseMenu() {
            this.openMenu = false;
            console.log("homeCloseMenu");
        },
        //header menu funcs

        //getting appointments func
        getAppointments() {
            if (localStorage.getItem("tk") == null || localStorage.getItem("tk") == undefined || localStorage.getItem("tk") == '') {
                this.loginDialog = true;
            } else {
                const mydata = {
                    action: "tt_my_turns",
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
                        if (response.data.data == null || response.data.data == ' ' || response.data.data == '' || response.data.data == undefined) {
                            this.$swal({
                                title: "جزئیاتی یافت نشد!",
                                text: "تا به حال نوبتی ثبت نکرده‌اید!",
                                icon: "warning",
                                confirmButtonText: "بسیار خب",
                                customClass: {
                                    confirmButton: "btn btn-warning",
                                },
                                buttonsStyling: true,
                            });
                        } else {
                            this.myAppointments = response.data.data;
                            console.log(this.myAppointments)
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
        //getting appointments func

        //show abort dialog func
        showAbortDialog(id) {
            this.abortDialog = true;
            this.chosenAppointment = id;
        },
        //show abort dialog func

        //abort appointment func
        abortAppointment() {
            const mydata = {
                action: "tt_cancel_reserve",
                reserve_ref: this.chosenAppointment,
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
                            text: "اطلاعات دریافتی نوبت اشتباه است!",
                            icon: "warning",
                            confirmButtonText: "بسیار خب",
                            customClass: {
                                confirmButton: "btn btn-warning",
                            },
                            buttonsStyling: true,
                        });
                    } else {
                        console.log(response)
                        this.chosenAppointment = null;
                    }
                } else {
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
        //abort appointment func

        //changing chosen visit mode background func
        // changeDelayMode(dayHourMode) {
        //     if (dayHourMode == 'ontime') {
        //         document.getElementById('onTimeMode').classList.add('selectedDayMode');
        //         document.getElementById('ontimeModeId').style.display = 'flex';
        //         document.getElementById('delayMode').classList.remove('selectedDayMode');
        //         document.getElementById('delayModeId').style.display = 'none';
        //     } else {
        //         document.getElementById('delayMode').classList.add('selectedDayMode');
        //         document.getElementById('delayModeId').style.display = 'flex';
        //         document.getElementById('onTimeMode').classList.remove('selectedDayMode');
        //         document.getElementById('ontimeModeId').style.display = 'none';
        //     }
        // },
        //changing chosen visit mode background func

        //open and close comment modal funcs
        close(){
            var modal = document.getElementById("myModal");
            modal.style.display = "none";
        },
        open(id) {
            this.chosenAppointment = id;
            var modal = document.getElementById("myModal");
            modal.style.display = "block";
        },
        //open and close comment modal funcs

        //oepn image input func
        openImageInput() {
            document.getElementById("commentImage").click();
        },
        //open image input func

        //send comment func
        sendComment() {
            if (this.comment === null || this.comment === '' || this.comment === undefined) {
                this.$swal({
                    title: "خطا!",
                    text: "فیلد متن نظر نباید خالی باشد!",
                    icon: "warning",
                    confirmButtonText: "بسیار خب",
                    customClass: {
                        confirmButton: "btn btn-warning",
                    },
                    buttonsStyling: true,
                });
            } else {

                const mydata = {
                    action: "tt_send_comment",
                    reserve_ref: this.chosenAppointment,
                    rating: this.rate,
                    comment: this.comment
                };
                const file = document.querySelector('#file-upload');
                if(file.files.length!==0){
                  this.geted_upload=1;
                  mydata.file=file.files[0]
                }
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
                                text: "اطلاعات دریافتی نوبت اشتباه است!",
                                icon: "warning",
                                confirmButtonText: "بسیار خب",
                                customClass: {
                                    confirmButton: "btn btn-warning",
                                },
                                buttonsStyling: true,
                            });
                        } else {
                            this.chosenAppointment = null;
                            this.close();
                            this.$swal({
                            title: "عملیات موفقیت آمیز !",
                            text: response.data.msg,
                            icon: "success",
                            confirmButtonText: "بسیار خب",
                            customClass: {
                                confirmButton: "btn btn-primary",
                            },
                            buttonsStyling: false,
                            });
                            }
                    } else {
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
        //send comment func
    },
    data() {
        return {
            geted: 1,
            tabValue: 0,
            rate: 5,
            openMenu: false,
            loginDialog: false,
            abortDialog: false,
            myAppointments: null,
            chosenAppointment: null,
            visitMode: null,
            comment: null,
            filename:"",
            appointmentActives: ['همه نوبت‌ها', 'نوبت‌های رزرو شده', 'نوبت‌های حضور یافته', 'نوبت‌های حضور نیافته', 'نوبت‌های کنسل شده'],
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
.appointmentTabsContainer {
    width: 528px !important;
    
}
.noAppointments {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 480px !important;
}
.generalCard {

    text-align: center;
    padding: 10px;
}
.generalColumn {
  padding: 0 5px 0 0;
    width: 100%;
    display: flex;
    flex-flow: column;
    align-items: flex-start;
}
.appContent {
    padding: 5px !important;
  font-size: 13px;
}
.operatorCard {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px;
    background: white;
    border-radius: 15px;
}
.myroww {
  display: flex; /* ایجاد یک Flex Container */
  justify-content: space-between; /* فاصله‌دهی مساوی بین دو دیو */
  width: 100%;

}
.operatorPic {
    width: 100px;
    border-radius: 15px 0 15px 0;
}
.rightPart {
    display: flex;
  background: white;
  border-radius: 15px;
}
.leftPart {
    display: flex;
    flex-flow: column;
    justify-content: center;
    align-items: center;
}
.showActive {

  background: #34cc73;
  color: white;
  border-radius: 20px;
  padding: 6px;
  height: 25px;
  font-size: 13px;
  margin: 0 2px 0 10px;
}
.showActiveMissed {
    background: rgb(255, 225, 0);
    color: white;
    border-radius: 20px;
    padding: 6px;
    height: 25px;
    font-size: 13px;
    margin: 0 2px 0 10px;
}
.showActiveAborted {
    background: #ff6c6c;
    color: white;
    border-radius: 20px;
    padding: 6px;
    height: 25px;
    font-size: 13px;
    margin: 0 2px 0 10px;
}
.abortAppointment {
    cursor: pointer;
  background: #ff6c6c;
  color: white;
  border-radius: 20px;
  padding: 6px;
  height: 25px;
  font-size: 13px;
  margin: 0 2px 0 10px;
}
.commentAppointment {

    background: rgb(0, 140, 255);
    cursor: pointer;
    color: white;
    border-radius: 20px;
    padding: 6px;
    height: 25px;
    font-size: 13px;
    margin: 0 2px 0 10px;
}
.hourListContainer {
    padding: 10px;
    display: flex;
    flex-flow: column;
    justify-content: center;
    align-items: center;
}
.hourList {
    width: 100%;
    display: flex;
    justify-content: space-around;
    align-items: center;
    border: 1px solid rgb(4, 4, 248);
    border-radius: 5px 5px 0px 0px;
}
.innerHourContainer {
    display: flex;
    flex-flow: column;
    justify-content: center;
    align-items: center;
    width: 100%;
}
.dayHourText {
    width: 100%;
    text-align: center;
    padding: 5px;
    cursor: pointer;
    border-radius: 0px, 5px, 0px, 0px;
}
.selectedDayMode {
    background: green !important;
}
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  left: 0;
  top: 0;
  width: 100%; /* Full width */

  height: 90%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
  -webkit-animation-name: fadeIn; /* Fade in the background */
  -webkit-animation-duration: 0.4s;
  animation-name: fadeIn;
  animation-duration: 0.4s
}
.modal-content {
    position: fixed;
    top: 30%;
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
.row::-webkit-scrollbar {
    display: none;
}
.comment_btn{
    width: 100%;
    text-align: center;
    margin:3%;
    height: 45px;
    background-color: var(--va-greencolor);
    color:white;
    border-radius: 10px;
    border:unset;
    cursor: pointer;
}
.comment{
    width: 96%;
    height: 60px;
    text-align: right;
    direction: rtl;
    outline: none !important;
    border:1px solid #8a8a8a;
    border-radius: 10px;
    padding: 10px;
}
@media only screen and (max-width: 436px) {
    .bodyPart {
        min-height: 750px;
    }
}
</style>

<style>
.va-tabs__wrapper {
    display: none;
}
.va-tabs__content {
    display: flex !important;
    overflow-x: scroll;
}
</style>