/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import VueRouter from 'vue-router'

import App from './components/App'
import Hierarchyt from './components/hierarchy'
import Employees from './components/employees'

//import route from './route'

Vue.use(VueRouter)


const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'hierarchy',
            component: Hierarchyt,
        },
        {
            path: '/employees',
            name: 'employees',
            component: Employees
        },

    ],
});

const app = new Vue({
    el: '#app',
    components: { App },
    router,
});
