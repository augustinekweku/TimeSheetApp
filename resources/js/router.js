import Vue from 'vue'
import Router from 'vue-router'
Vue.use(Router)

import staff from './admin/pages/staff';
import reportingTime from './admin/pages/reportingTime';
import login from './admin/pages/login';


const routes = [
    //admin routes
    {
        path:  '/reportingTime',
        component: reportingTime,
        name: 'reportingTime'
    },
    {
        path:  '/staff',
        component: staff,
        name: 'staff'
    },
    {
        path:  '/login',
        component: login,
        name: 'login'
    },

    
]

export default new Router ({
    mode: 'history',
    routes,
})