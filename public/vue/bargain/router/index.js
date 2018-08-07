import Vue from 'vue'
import Router from 'vue-router'
import Home from '@/components/Home';
// import GetToken from '@/components/GetToken';
import Login from '@/components/Login';
import List from '@/components/List';
import GoodsDetail from '@/components/GoodsDetail';
import Dobargain from '@/components/Dobargain';
import MyBargain from '@/components/MyBargain';

Vue.use(Router)

const router = new Router({
    mode:'history',
    routes:[
        {
            path:'/',
            component:Home,
            meta: {
                title: '首页'
            }
        },
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
        },
        {
            path:'/detail',
            name:'detail',
            component:GoodsDetail,
            meta: {
                title: '分享砍价'
            }
        },
        {
            path: '/dobargain',
            name:'dobargain',
            component: Dobargain,
            meta: {
                title: '帮TA砍一刀吧！'
            }
        },
        {
            path: '/mybargain',
            name:'mybargain',
            component: MyBargain,
            meta: {
                title: '我的砍价单'
            }
        },
        {
            // 访问路由表中不存在的路由，进入list，默认路由
            path: '*',
            component: List,
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

    if(token || to.path == '/login'){
        // 用户已经授权过或正在授权
        next()
    }else{
        // 用户第一次进入
        next('/login')
        return false
    }
    
    if((token && to.path == '/login') || (token && to.path == '/')) {
        // 用户使用后退返回到授权页，则默认回到list
        next('/list')
        return false
    }
    // 设置路由title
    document.title = to.meta.title
    next()
})

export default router


