
// import {createApp} from 'vue'


// const app = createApp({})

// window._ = require('lodash');
// window.axios = require('axios');
// window.Vue = require('vue');

// import { BootstrapVue, IconsPlugin } from 'bootstrap-vue';
// import 'bootstrap/dist/css/bootstrap.css';
// import 'bootstrap-vue/dist/bootstrap-vue.css';
// import Vue from 'vue';
// Vue.use(BootstrapVue);
// Vue.use(IconsPlugin);

// import Head from '@/components/Head.vue';
// import Nav from './components/Nar.vue';

// app.component('head',Head)
// app.component('nav',Nav)
// import app from './components/head.vue';
// // import app1 from './components/nav.vue';

// createApp(app).mount("#app");
// createApp(app1).mount("#app1");

import { createApp } from 'vue';
import App from './components/customers/App.vue';
import Home from './components/customers/Home.vue';

// const app = createApp(App);
const app = createApp({})

// Đăng ký các component bằng .component
app.component('app', App);
app.component('home', Home);




app.mount('#app');

