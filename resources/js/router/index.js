import { createRouter, createWebHistory } from 'vue-router'
import * as VueRouter from 'vue-router';
import App from '../components/App.vue';
import ListCloud from '../components/customers/ListCloud.vue';
import AddCloud from '../components/customers/AddCloud.vue';
import SingleDrive from '../components/customers/SingleDrive.vue';
import DetailDrive from '../components/customers/DetailCloud.vue';

const router = VueRouter.createRouter({
    history: VueRouter.createWebHashHistory(),
    routes: [
        {
            path: '/',
            component: App,
            name: 'app',
        },
        {
            path: '/addCloud',
            component: AddCloud,
            name: 'addCloud',
        },
        {
            path: '/listCloud',
            component: ListCloud,
            name: 'listCloud',
        },
        {
            path: '/singleDrive/:cloud/:id',
            component: SingleDrive,
            name: 'singleDrive',
            props: true
        },
        {
            path: '/detailDrive/:cloud/:id',
            component: DetailDrive,
            name: 'detailDrive',
        },
    ]
});


export default router
