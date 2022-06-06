require('./bootstrap');

import * as Vue from "vue";
import * as VueRouter from 'vue-router';
import "bootstrap/dist/css/bootstrap.min.css";
import axios from "axios";
import VueAxios from "vue-axios";

import { routes } from "./routes";
const router = VueRouter.createRouter({
    history: VueRouter.createWebHistory(),
    routes,
});

const app = Vue.createApp({});
app.use(router, VueAxios, axios);
app.mount("#app");
