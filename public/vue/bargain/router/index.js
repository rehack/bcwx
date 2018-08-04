import Vue from 'vue'
import Router from 'vue-router'
import Home from '@/components/Home';
import GetToken from '@/components/GetToken';
import Login from '@/components/Login';

Vue.use(Router)

const router = new Router({
    // mode:'history',
    routes:[
        {
            path:'/',
            component:Home,
            meta: {
                title: '首页'
            }
        },
        {
            path:'/token/',
            component:GetToken,
            meta: {
                title: '砍价商品'
            }
        },
        {
            path:'/login',
            name:'login',
            component:Login,
            meta: {
                title: '登陆'
            }
        }
    ],
})

// https://www.jb51.net/article/123280.htm 死循环
// https://segmentfault.com/q/1010000010645817


// 登陆验证拦截
router.beforeEach((to, from, next) => {
    let token = window.localStorage.getItem("user_token")
    let flag = window.localStorage.getItem("flag")
    if (token) {
        next()
    } else {
        if (flag) {
            next()
        } else {
            if(to.path=='/login'){ //如果是登录页面路径，就直接next()
                next()
            } else if(to.path=='/token' && !token){
                next('/login')
            }
            else { //不然就跳转到登录；
                next('/login')
            }
        }
    }
})

export default router


