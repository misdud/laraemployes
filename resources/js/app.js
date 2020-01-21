/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

window.Vue = require("vue");
import Vuelidate from "vuelidate";
import VueRouter from "vue-router";

import App from "./components/App";
//test
//import AppTree from "./components/AppTree";

import AppTree from "./components/MainHierarchy";

//import route from './route'
import router from "./routes";

Vue.use(VueRouter); 
Vue.use(Vuelidate);

const app = new Vue({
    el: "#appmy",
    components: { App },
    router
});

const app2 = new Vue({
    el: "#appmy2",
    components: { AppTree }

});