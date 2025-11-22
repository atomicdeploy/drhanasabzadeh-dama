<template>
  <!-- BEGIN: Header-->
  <nav style="margin: 1.3rem;right:0;width: 97%" class="header-navbar navbar navbar-expand-lg align-items-center floating-nav navbar-light navbar-shadow container-xxl">
    <div class="navbar-container d-flex content">
      <div class="bookmark-wrapper d-flex align-items-center">
        <ul class="nav navbar-nav d-xl-none">
          <li class="nav-item" @click="this.HeaderOpenMenu()">
            <a class="nav-link menu-toggle" href="#">
              <font-awesome-icon icon="fa-solid fa-bars" size="lg"  :style="{ color: '#888888' }"/>
            </a></li>
        </ul>
        <ul class="nav navbar-nav bookmark-icons">
          <li class="nav-item d-none d-lg-block"><router-link to="/" class="nav-link" data-bs-toggle="tooltip" data-bs-placement="bottom" title="خانه">خانه</router-link></li>
          <li class="nav-item d-none d-lg-block"><router-link to="/login" class="nav-link" data-bs-toggle="tooltip" data-bs-placement="bottom" title="پنل کاربری">پنل کاربری</router-link></li>
          <li class="nav-item d-none d-lg-block"><router-link to="/shop" class="nav-link"  data-bs-toggle="tooltip" data-bs-placement="bottom" title="Chat">فروشگاه</router-link></li>
          <li class="nav-item d-none d-lg-block"><router-link to="/blog" class="nav-link"  data-bs-toggle="tooltip" data-bs-placement="bottom" title="Calendar">وبلاگ</router-link></li>
        </ul>
      </div>
      <ul class="nav navbar-nav align-items-center ms-auto">

<!--        <li class="nav-item d-none d-lg-block"><a class="nav-link nav-link-style"><i class="ficon" data-feather="moon"></i></a></li>-->

        <li class="nav-item dropdown dropdown-cart me-25">

            <va-button-dropdown hide-icon="true" class="mb-2" color="#7367f0" style="margin:unset !important;padding:unset !important;">
              <template #label style="margin:unset !important;padding:unset !important;">
                <font-awesome-icon icon="fa-solid fa-cart-shopping" size="lg"  :style="{ color: '#ffffff' }"/>
                <span class="badge rounded-pill bg-primary badge-up cart-item-count">{{ carts.length }}</span>
              </template>
             <div style="width: 336px;padding: 10px;position: fixed;left: 23px;background: white;top: 85px;overflow-y:scroll;overflow-x:hidden; height:400px;">
               <div class="row mb-2">
                 <div class="col-8">سبد خرید</div>
                 <div class="col-3 badge rounded-pill badge-light-primary" style="margin-left:5px">{{ carts.length }} محصول</div>
               </div>
               <hr/>
               <div  v-for="cart in carts" :key="cart.id"  style="background:white">
                <div v-if="cart.num>0" class="row mt-1">
                   <div class="col-3">
                     <img class="d-block rounded me-1" :src="this.apiurl+'/images/product/'+cart.pic" alt="donuts" width="62">
                   </div>
                   <div class="col-6"><h6 class="cart-item-title"><router-link class="text-body" :to="'/shop/'+cart.id"> {{ cart.name }}</router-link></h6><small class="cart-item-by" style="font-size:12px">{{ cart.num }} عدد</small></div>
                   <div class="col-3">
                     <h5 class="cart-item-price mt-2">{{ this.formatter.format(cart.price) }}</h5>
                     <br/>
                     <p @click="this.delheaderhome(cart.id)" style="cursor:pointer"><span class="badge rounded-pill badge-light-danger me-1"><vue-feather type="trash" size="16"></vue-feather>&nbsp;حذف</span></p>
                   </div>
                   <hr class="mt-2"/>
                </div>
               </div>
               <div class="d-flex justify-content-between mb-1" style="background:white">
                 <h6 class="fw-bolder mb-4 mt-2">جمع کل:</h6>
                 <h6 class="text-primary fw-bolder  mb-4 mt-2">{{this.formatter.format(this.sumPrice)}} تومان</h6>
               </div><router-link to="/basket" class="btn btn-primary w-100" >ادامه خرید</router-link>
             </div>

        </va-button-dropdown>
        </li>
        <li class="nav-item dropdown dropdown-notification me-25"><a class="nav-link" href="#" data-bs-toggle="dropdown">
          <font-awesome-icon icon="fa-solid fa-envelope" size="xl"  :style="{ color: '#989898' }"/>
          <span class="badge rounded-pill bg-danger badge-up">0</span></a>
          <ul class="dropdown-menu dropdown-menu-media dropdown-menu-end">
            <li class="dropdown-menu-header">
              <div class="dropdown-header d-flex">
                <h4 class="notification-title mb-0 me-auto">پیام ها</h4>
                <div class="badge rounded-pill badge-light-primary">0 پیام</div>
              </div>
            </li>
            <li class="dropdown-menu-footer"><a class="btn btn-primary w-100" href="#">بستن</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown dropdown-user"><a class="nav-link dropdown-toggle dropdown-user-link" id="dropdown-user" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <div class="user-nav d-sm-flex d-none"><span class="user-name fw-bolder">کاربر</span><span class="user-status">مهمان</span></div><span class="avatar"><img class="round"  alt="avatar" height="40" width="40"><span class="avatar-status-online"></span></span>
        </a>
          <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-user">
            <router-link to="/login" class="dropdown-item">
              <i class="me-50" data-feather="user"></i> پنل کاربری
            </router-link>
            <a class="dropdown-item" href="#">
              <i class="me-50" data-feather="mail"></i> پیام ها
            </a>
            <div class="dropdown-divider"></div>
            <router-link to="/login" class="dropdown-item">
              <i class="me-50" data-feather="power"></i> خروج
            </router-link>
          </div>
        </li>
      </ul>
    </div>
  </nav>
</template>
<script>
import { library } from '@fortawesome/fontawesome-svg-core'
import { faBars,faCartShopping,faEnvelope } from '@fortawesome/free-solid-svg-icons'
// import { faShopify,faReadme } from '@fortawesome/free-brands-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

library.add(faBars,faCartShopping,faEnvelope)
export default {
  name: "HeaderHome.vue",
  components: {
    FontAwesomeIcon
  },
  props: ['carts'],
  data(){
    return{
      sum:0,
      formatter : new Intl.NumberFormat('en', {
        maximumFractionDigits:0,
      })
    }
  },
  mounted() {

  },
  methods:{
    HeaderOpenMenu(){
      this.$emit('headeropenMenu')
    },
    delheaderhome(ref){
      this.$emit("delheaderhome",ref);
    }
  },
  computed: {
    sumPrice() {
      var summ=0;
      this.carts.forEach(object => {
        summ+=object.price*object.num;
      });
      return summ;
    }

  },
  updated() {
    console.log("Header CART");
    // console.log(this.carts);
    if(this.carts!==""){
      this.sum=0;
      this.carts.forEach(object => {
        console.log("AAA HHHHHHH");
        this.sum+=object.price;
      });
    }
  }
}
</script>
<style>
div{
  font-family: IRANYekan !important;
}
</style>