<template>
    <Header @headeropenMenu="this.headerOpenMenu()" :isHome="0" />
    <SideMenu
        :openMenu="this.openMenu"
        @headercloseMenu="this.headerCloseMenu()"
        :group_ref="0"
    />
    <Loading v-if="this.geted === 1" style="margin-top: 80px" />

    <div class="bodyPart">
        <!-- search input -->
        <div v-if="this.geted === 2" class="text_search">
            <div class="textStyle">
                <img
                src="../../assets/images/Ellipse.png"
                style="width: 10px; margin-left: 10px;"
                
                />
                <p>اپراتور مورد نظر خود را انتخاب نمایید.</p>
            </div>
            <va-input
                v-model="search"
                type="search"
                placeholder="جستجوی اپراتور"
                clearable
                class="searchInput"
            />
        </div>
        <!-- search input -->

        <!-- operators list -->
        <div
        class="noOperatorPic"
        v-if="(this.operatorsList === null || this.operatorsList === [] || this.operatorsList === '' || this.operatorsList === undefined) && this.geted === 2"
        >
            <img
            src="../../assets/images/nopic.png"
            />
        </div>
        <div style="padding: 10px;" v-else-if="this.geted === 2">
            <div
            class="generalCard"
            v-if="this.searchItems === [] || this.searchItems === null || this.searchItems === undefined"
            v-for="operator in this.operatorsList" :key="operator.id"
            >
                <div class="operatorCard" @click="this.goToPage('/operator-appointment',0, operator.id, operator.name)">
                    <img
                    v-if="operator.pic == null || operator.pic == ''"
                    src="../../assets/images/nopic.png"
                    class="operatorPic"
                    />
                    <img
                    v-else
                    :src="this.baseurl+'/images/take_turns/'+operator.pic"
                    class="operatorPic"
                    />
                    <va-divider class="dividerClass" vertical dashed />
                    <div class="generalColumn">
                        <div class="mb-3" style="font-weight: bold;">{{ operator.name }}</div>
                        <div>
                            <va-rating
                                v-if="operator.rating"
                                v-model="operator.rating"
                                class="ratingStar mb-3"
                                color="warning"
                            />
                            <p class="mb-3" v-else>رتبه‌ای برای این اپراتور ثبت نشده است!</p>
                        </div>
                        <div>{{ operator.price }}</div>
                    </div>
                </div>
            </div>
            <div
            class="generalCard"
            v-else
            v-for="searchItem in searchItems" :key="searchItem.id"
            >
                <div class="operatorCard" @click="this.goToPage('/operator-appointment',0, searchItem.id, searchItem.name)">
                    <img
                    v-if="searchItem.pic == null || searchItem.pic == ''"
                    src="../../assets/images/nopic.png"
                    class="operatorPic"
                    />
                    <img
                    v-else
                    :src="this.baseurl+'/images/take_turns/'+searchItem.pic"
                    class="operatorPic"
                    />
                    <va-divider class="dividerClass" vertical dashed />
                    <div class="generalColumn">
                        <div>{{ searchItem.name }}</div>
                        <div>
                            <va-rating
                                v-if="searchItem.rate"
                                v-model="searchItem.rate"
                                class="ratingStar"
                                color="warning"
                            />
                            <p v-else>رتبه‌ای برای این اپراتور ثبت نشده است!</p>
                        </div>
                        <div>قیمت:‌ {{ searchItem.price }}</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- operators list -->
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
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import "swiper/css";
import "swiper/css/pagination";
import "swiper/css/scrollbar";
import "swiper/css/autoplay";

export default {
    name: "operators",
    components: {
        Loading,
        SideMenu,
        Header,
        SubHeader,
        Footer,
        FontAwesomeIcon,
        LoadingButton,
    },
    watch: {
    // whenever search changes, this function will run
        search(newSearch) {
            this.searchItems = []
            for (let i = 0; i < this.operatorsList.length; i++) {
                if(this.operatorsList[i].name.includes(newSearch)) {
                    this.searchItems.push(this.operatorsList[i]);
                }
            }
        }
    // whenever search changes, this function will run
    },
    created() {
        this.searchItems = null;
    },
    mounted() {
        //getting request infoes from localStorage
        this.branchId = JSON.parse(localStorage.getItem("branchId"));
        this.skillId = JSON.parse(localStorage.getItem("skillId"));
        //getting request infoes from localStorage
        
        //calling getting operators list and details function
        this.getOperators(this.branchId, this.skillId);
        //calling getting operators list and details function
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

        //getting operators list and details function
        getOperators(branchId, skillId) {
            // console.log(branchId, skillId)
            const mydata = {
                action: "tt_operators",
                branch_ref: branchId,
                skill_ref: skillId,
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
                    if (response.data.data == null || response.data.data == ' ' || response.data.data == '' || response.data.data == undefined) {
                        this.$swal({
                            title: "اپراتوری یافت نشد!",
                            text: "متأسفانه برای خدمات مورد نظر شما، اپراتوری یافت نشد!",
                            icon: "warning",
                            confirmButtonText: "بسیار خب",
                            customClass: {
                                confirmButton: "btn btn-warning",
                            },
                            buttonsStyling: true,
                        });
                    } else {
                        this.operatorsList = response.data.data;
                        console.log(this.operatorsList)
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
        //getting operators list and details function

        //going to next page func
        goToPage(page, pageref, operatorId, operatorName) {
            localStorage.setItem("operatorId", JSON.stringify(operatorId));
            localStorage.setItem("operatorName", JSON.stringify(operatorName));
            if (pageref > 0) {
                this.$router.push({ path: page ,query:{ pageref: pageref } });
            }
            else {
                this.$router.push({path: page});
            }
        },
        //going to next page func
    },
    data() {
        return {
            geted: 1,
            ratingValue: 4,
            openMenu: false,
            operatorsList: [],
            searchItems: [],
            search: null,
            branchId: null,
            skillId: null,
        };
    },
}
</script>

<style scoped>
.bodyPart {
    background: url("../../assets/images/takeTurnBackground.png");
    min-height: 585px;
    background-size: 539px 100%;
    background-repeat: no-repeat;
}
.generalCard {
    text-align: center;
    padding: 10px;
    background: white !important;
    border-radius: 10px;
}
.generalCard:hover {
    cursor: pointer;
    background-color: rgba(13, 0, 255, 0.663) !important;
    color: white !important;
}
.noOperatorPic {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 480px !important;
}
.operatorCard {
    display: flex;
    align-items: center;
}
.text_search {
    padding: 15px 15px 0 0;
}
.textStyle {
    display: flex;
    justify-content: flex-start;
    align-items: center;
    padding: 10px;
    margin-top: 10px
}
.searchInput {
    margin-top: 10px;
    border: 1px solid blue;
    border-radius: 5px;
    width: 97%;
}
.va-input-wrapper__field {
    border: none !important;
}
.dividerClass {
    vertical-align: top !important;
    height: 140px;
    border-color: #E5E5E5 !important;
    margin-right: 15px;
}
.generalColumn {
    display: flex;
    flex-flow: column;
    align-items: flex-start;
    justify-content: space-around;
    margin-right: 10px;
}
.operatorPic {
    width: 28%;
    height: 130px !important;
    border-radius: 5px;
}
@media only screen and (max-width: 436px) {
    .bodyPart {
        min-height: 750px;
    }
}
</style>