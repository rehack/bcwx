import Vue from 'vue'
import Router from 'vue-router'
import GetToken from '@/components/GetToken';
import HelloWorld from '@/components/HelloWorld';
import Login from '@/components/Login';

Vue.use(Router)

export default new Router({
    // mode:'history',
    // base: '/test',
    routes:[
        {
            path:'/token/',
            component:GetToken
        },
        {
            path:'/',
            component:HelloWorld
        },
        {
            path:'/login',
            component:Login
        }
    ],
})
