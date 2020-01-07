/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

window.Vue = require("vue");
import VueRouter from "vue-router";

import App from "./components/App";

//import route from './route'
import router from "./routes";

Vue.use(VueRouter);

const app = new Vue({
    el: "#appmy",
    components: { App },
    router
});
