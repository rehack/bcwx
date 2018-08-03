import Vue from 'vue'
import Router from 'vue-router'
import GetToken from '@/components/GetToken';
import Home from '@/components/Home';
import Login from '@/components/Login';

Vue.use(Router)

export default new Router({
    // mode:'history',
    // base: '/test',
    routes:[
        {
            path:'/',
            component:Home
        },
        {
            path:'/token/',
            component:GetToken
        },
        {
            path:'/login',
            component:Login
        }
    ],
})
