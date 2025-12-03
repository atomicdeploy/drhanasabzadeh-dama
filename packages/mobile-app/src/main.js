import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import axios from 'axios'
import VueCookies from 'vue-cookies'

import { createVuestic } from 'vuestic-ui'
import 'vuestic-ui/dist/vuestic-ui.css'

import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import VueFeather from 'vue-feather';
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";

// other video player
import VueVideoPlayer from 'vue-video-player'
// require videojs style
import 'video.js/dist/video-js.css'
// end other video player
import { createI18nWithLogging } from './plugins/i18n'
const i18n = createI18nWithLogging({
    locale: 'fa', // زبان پیش‌فرض
    fallbackLocale: 'en',
    messages: {
        en: require('./locales/en.json'),
        fa: require('./locales/fa.json'),
        // اضافه کردن زبان‌های دیگر اینجا
    }
})
var r = document.querySelector(':root');
r.style.setProperty('--va-primary', jsonData.c_basecolor);
r.style.setProperty('--va-basecolor', jsonData.c_basecolor);
r.style.setProperty('--va-greencolor', '#34cc73');
r.style.setProperty('--va-seccolor', jsonData.c_seccolor);
r.style.setProperty('--va-textcolor', '#3b3b3b');
r.style.setProperty('--va-gray', '#5a5a5a');
r.style.setProperty('--va-back1', '#f3f3f3');
r.style.setProperty('--va-focus', '#d7d7d7');
import jsonData from '../public/constant.json';
import { createPinia } from 'pinia'
import piniaPluginPersistedstate from 'pinia-plugin-persistedstate'
const pinia = createPinia()
pinia.use(piniaPluginPersistedstate)
let app=createApp(App)
app.use(pinia)
app.config.globalProperties.$http = axios
// app.config.globalProperties.$i18n = i18n
app.config.globalProperties.apiurl = jsonData.c_baseurl+"/apiw"
app.config.globalProperties.baseurl = jsonData.c_baseurl
app.config.globalProperties.appname_en = jsonData.c_appname_en
app.config.globalProperties.appname = jsonData.c_appname
app.config.globalProperties.appdirectory = jsonData.c_directory
app.config.globalProperties.walleturl = jsonData.c_walleturl
app.config.globalProperties.dl = "https://appdama.ir/hakwolQ8zcx/"
app.config.globalProperties.basecolor = jsonData.c_basecolor
app.config.globalProperties.gray = '#5a5a5a'
app.use(router)
app.use(Toast)
app.use(VueVideoPlayer)
app.use(VueCookies, { expire: '21d'})
app.use(createVuestic({
    config: {
        colors: {
            primary: jsonData.c_basecolor,
            basecolor: jsonData.c_basecolor,
            greencolor: '#34cc73',
            seccolor: jsonData.c_seccolor,
            textcolor: '#3b3b3b',
            gray: '#5a5a5a',
            back1: '#FAFAFA',
            focus:'#d7d7d7'
        },
    },
}))
app.use(VueSweetalert2);
app.use(i18n);
app.component(VueFeather.name, VueFeather);
app.mount('#app')


// createApp(App).use(router).mount('#app')
