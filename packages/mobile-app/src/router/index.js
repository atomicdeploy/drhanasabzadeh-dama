import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'

const routes = [
    {
        path: '/pay',
        name: 'Payresult',
        component: ()=>import('../views/Payresult.vue'),
    },
    {
        path: '/invoice/:id',
        name: 'InvoiceSp',
        component: ()=>import('../views/Invoice.vue'),
    },
    {
        path: '/invoice',
        name: 'Invoice',
        component: ()=>import('../views/Invoice.vue'),
    },
     {
        path: '/CryptoInvoice',
        name: 'CryptoInvoice',
        component: ()=>import('../views/CryptoInvoice.vue'),
    },
     {
        path: '/test',
        name: 'Test',
        component: ()=>import('../views/Test.vue'),
    },
      {
        path: '/mobile',
        name: 'Mobile',
        component: ()=>import('../views/Mobile.vue'),
    },
    {
        path: '/mobile2',
        name: 'Mobile2',
        component: ()=>import('../views/Mobile2.vue'),
    },
    {
        path: '/code',
        name: 'Code',
        component: ()=>import('../views/Code.vue'),
    },
     {
        path: '/code2',
        name: 'Code2',
        component: ()=>import('../views/Code2.vue'),
    },
    {
        path: '/',
        name: 'Home',
        component: ()=>import('../views/Home.vue'),
    },
    {
        path: '/meets/:id',
        name: 'Meets',
        component: ()=>import('../views/Meets.vue'),
    },
    {
        path: '/courses',
        name: 'Courses',
        component: ()=>import('../views/Courses.vue'),
    },
    {
        path: '/play',
        name: 'Player',
        component: ()=>import('../views/Player.vue'),
    },
    {
        path: '/subscription',
        name: 'Subscription',
        component: ()=>import('../views/Subscription.vue'),
    },
    {
        path: '/contact',
        name: 'Contact',
        component: ()=>import('../views/Contact.vue'),
    },
    {
        path: '/channel',
        name: 'Channel',
        component: ()=>import('../views/Channel.vue'),
    },
    {
        path: '/channelpost/:id',
        name: 'ChannelPost',
        component: ()=>import('../views/ChannelPost.vue'),
    },
    {
        path: '/mycourses',
        name: 'MyCourses',
        component: ()=>import('../views/MyCourses.vue'),
    },
    {
        path: '/fav',
        name: 'Fav',
        component: ()=>import('../views/Fav.vue'),
    },
    {
        path: '/wallet',
        name: 'Wallet',
        component: ()=>import('../views/Wallet.vue'),
    },
    {
        path: '/search',
        name: 'Search',
        component: ()=>import('../views/Search.vue'),
    },
    {
        path: '/counseling',
        name: 'Counseling',
        component: ()=>import('../views/Counseling.vue'),
    },
    {
        path: '/challenge/:id',
        name: 'challengeDetail',
        component: ()=>import('../views/ChallengeDetail.vue'),
    },
    {
        path: '/challenge',
        name: 'Challenge',
        component: ()=>import('../views/Challenge.vue'),
    },
    {
        path: '/support/:id',
        name: 'SupportDetail',
        component: ()=>import('../views/SupportDetail.vue'),
    },
    {
        path: '/support',
        name: 'Support',
        component: ()=>import('../views/Support.vue'),
    },
    {
        path: '/live/:id',
        name: 'LiveDetail',
        component: ()=>import('../views/LiveDetail.vue'),
    },
    {
        path: '/live',
        name: 'Live',
        component: ()=>import('../views/Live.vue'),
    },
    {
        path: '/liveplay/:id',
        name: 'LivePlay',
        component: ()=>import('../views/LivePlay.vue'),
    },
    {
        path: '/exams',
        name: 'Exams',
        component: ()=>import('../views/Exams.vue'),
    },
    {
        path: '/exam/:id',
        name: 'Exam',
        component: ()=>import('../views/Exam.vue'),
    },
    {
        path: '/exam_q/:id',
        name: 'ExamDetail',
        component: ()=>import('../views/ExamQuestion.vue'),
    },
    {
        path: '/exam_a/:id',
        name: 'ExamAnswer',
        component: ()=>import('../views/ExamAnswer.vue'),
    },
    {
        path: '/profile',
        name: 'Profile',
        component: ()=>import('../views/Profile.vue'),
    },
    {
        path: '/terms',
        name: 'Terms',
        component: ()=>import('../views/Terms.vue'),
    },
    {
        path: '/installerIos',
        name: 'installerIos',
        component: ()=>import('../views/installerIos.vue'),
    },
    {
        path: '/installer',
        name: 'Installer',
        component: ()=>import('../views/Installer.vue'),
    },



    {
        path: '/shop/home',
        name: 'ShopHome',
        component: ()=>import('../views/shop/HomeShop.vue'),
    },
    {
        path: '/shop/category',
        name: 'ProductShop',
        component: ()=>import('../views/shop/Category.vue'),
    },
    {
        path: '/shop/basecat/:b/:c/:s',
        name: 'Basecat',
        component: ()=>import('../views/shop/Basecat.vue'),
    },
    {
        path: '/shop/cat/:b/:c/:s',
        name: 'Cat',
        component: ()=>import('../views/shop/Cat.vue'),
    },
    {
        path: '/shop/subcat/:b/:c/:s',
        name: 'Subcat',
        component: ()=>import('../views/shop/Subcat.vue'),
    },
    {
        path: '/shop/detail/:id',
        name: 'DetailShop',
        component: ()=>import('../views/shop/Detail.vue'),
    },
    {
        path: '/shop/basket',
        name: 'BasketShop',
        component: ()=>import('../views/shop/Basket.vue'),
    },
    {
        path: '/shop/invoice',
        name: 'InvoiceShop',
        component: ()=>import('../views/shop/Invoice.vue'),
    },
    {
        path: '/shop/search',
        name: 'SearchShop',
        component: ()=>import('../views/shop/SearchShop.vue'),
    },
    {
        path: '/shop/products',
        name: 'ProductShop.vue',
        component: ()=>import('../views/shop/ProductShop.vue'),
    },
    {
        path: '/article/:id',
        name: 'Pdfviewer',
        component: ()=>import('../views/Pdfviewer.vue'),
    },





    {
        path: '/appointment',
        name: 'appointment',
        component: () => import('../views/TakeTurns/Appointment.vue'),
    },
    {
        path: '/favorites',
        name: 'favorites',
        component: () => import('../views/TakeTurns/FavoritesList.vue'),
    },
    {
        path: '/my-appointments',
        name: 'my-appointments',
        component: () => import('../views/TakeTurns/MyAppointments.vue'),
    },
    {
        path: '/branches',
        name: 'branches',
        component: () => import('../views/TakeTurns/Branches.vue'),
    },
    {
        path: '/skills',
        name: 'skills',
        component: () => import('../views/TakeTurns/Skills.vue'),
    },
    {
        path: '/operators',
        name: 'operators',
        component: () => import('../views/TakeTurns/Operators.vue'),
    },
    {
        path: '/operator-appointment',
        name: 'operator-appointment',
        component: () => import('../views/TakeTurns/OperatorAppointment.vue'),
    },
    {
        path: '/choose-day-hour',
        name: 'choose-day-hour',
        component: () => import('../views/TakeTurns/ChooseDayHour.vue'),
    },
    {
        path: '/approve-chosen-appointment',
        name: 'approve-chosen-appointment',
        component: () => import('../views/TakeTurns/ApproveChosenAppointment.vue'),
    },
    {
        path: '/approve-chosen-appointment',
        name: 'approve-chosen-appointment',
        component: () => import('../views/TakeTurns/ApproveChosenAppointment.vue'),
    },
    {
        path: '/successful-payment',
        name: 'successful-payment',
        component: () => import('../views/TakeTurns/SuccessfulPayment.vue'),
    },
    {
        path: '/my-comments',
        name: 'my-comments',
        component: () => import('../views/TakeTurns/MyComments.vue'),
    },



    {
        path: '/languages',
        name: 'Languages',
        component: () => import('../components/Languages.vue'),
    },
    {
        path: '/teachers',
        name: 'Teachers',
        component: ()=>import('../views/Teacher/Teachers.vue'),
    },
    {
        path: '/teacher/:id',
        name: 'TeacherDetail',
        component: ()=>import('../views/Teacher/TeacherDetail.vue'),
    },
    {
        path: '/cardtocard',
        name: 'CardtocardInvoice',
        component: ()=>import('../views/CardtocardInvoice.vue'),
    },
    {
        path: '/wv',
        name: 'WebView',
        component: ()=>import('../views/WebView.vue'),
    },
    {
        path: '/convert',
        name: 'Convert',
        component: ()=>import('../views/Convert.vue'),
    },
    {
        path: '/commission',
        name: 'Commission',
        component: ()=>import('../views/Commission.vue'),
    },
    {
        path: '/currencyprice',
        name: 'CurrencyPrice',
        component: ()=>import('../views/CurrencyPrice.vue'),
    },


]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
