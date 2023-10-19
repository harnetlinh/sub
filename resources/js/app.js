import { createApp } from 'vue';
import App from './components/App.vue';
// import Home from './components/customers/Home.vue';
import router from './router/index.js';

// const app = createApp(App);
const app = createApp({})
app.use(router);

// Đăng ký các component bằng .component
app.component('app', App);
// app.component('home', Home);


app.mount('#app');


