import Vue from 'vue'
import Router from 'vue-router'
import Home from '@/components/Home';
// import GetToken from '@/components/GetToken';
import Login from '@/components/Login';
import List from '@/components/List';

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
        /* {
            path:'/token',
            component:GetToken,
            meta: {
                title: '砍价商品'
            }
        }, */
        {
            path:'/login',
            name:'login',
            component:Login,
            meta: {
                title: '登录中...'
            }
        },
        {
            path:'/list',
            name:'list',
            component:List,
            meta: {
                title: '砍价商品列表'
            }
        }
    ],
})

// https://www.jb51.net/article/123280.htm 死循环
// https://segmentfault.com/q/1010000010645817


// 登陆验证拦截
router.beforeEach((to, from, next) => {
    let token = window.localStorage.getItem("user_token")

    document.title = to.meta.title
    if(token || to.path == '/login'){
        // 用户已经授权过或正在授权
        next()
    }else{
        // 用户第一次进入
        next('/login')
        return false
    }

    if(token && to.path == '/login'){
        // 用户使用后退返回到授权页，则默认回到list
        next('/list')
        return false
    }
    
    next()
})

export default router


