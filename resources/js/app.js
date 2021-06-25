window.$ = window.jQuery = require('jquery');
require('./bootstrap');

import Vue from 'vue';
import router from './router'
import store from './store'

import ViewUI from 'view-design';
import 'view-design/dist/styles/iview.css';
Vue.use(ViewUI);

import common from './common'
Vue.mixin(common);

import VueGoodTablePlugin from 'vue-good-table';

import JsonExcel from "vue-json-excel";
Vue.component("downloadExcel", JsonExcel);





// import the styles
import 'vue-good-table/dist/vue-good-table.css'

Vue.use(VueGoodTablePlugin);


window.humanizeDuration = require("humanize-duration");


Vue.component('mainapp', require('./components/mainapp.vue').default); 
const app = new Vue({
    el: '#app',
    router,
    store
})