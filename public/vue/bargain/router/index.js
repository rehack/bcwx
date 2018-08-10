import Vue from 'vue'
import Router from 'vue-router'
import Home from '@/pages/Home';
// import GetToken from '@/pages/GetToken';
import Login from '@/pages/Login';
import List from '@/pages/List';
import GoodsDetail from '@/pages/GoodsDetail';
import Dobargain from '@/pages/Dobargain';
import MyBargain from '@/pages/MyBargain';
import Clear from '@/pages/Clear';

Vue.use(Router)

const router = new Router({
    mode:'history',
    routes:[
        {
            path:'/bargain/',
            component:Home,
            meta: {
                title: '首页'
            }
        },
        {
            path:'/bargain/login',
            name:'login',
            component:Login,
            meta: {
                title: '登录中...'
            }
        },
        {
            path:'/bargain/list',
            name:'list',
            component:List,
            meta: {
                title: '砍价商品列表'
            }
        },
        {
            path:'/bargain/detail',
            name:'detail',
            component:GoodsDetail,
            meta: {
                title: '分享砍价'
            }
        },
        {
            path: '/bargain/dobargain',
            name:'dobargain',
            component: Dobargain,
            meta: {
                title: '帮TA砍一刀吧！'
            }
        },
        {
            path: '/bargain/c',
            name:'c',
            component: Clear,
            meta: {
                title: 'c'
            }
        },
        {
            path: '/bargain/mybargain',
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
                title: '成都贝臣齿科'
            }
        }
    ],
})

// https://www.jb51.net/article/123280.htm 死循环
// https://segmentfault.com/q/1010000010645817


// 登陆验证拦截
router.beforeEach((to, from, next) => {
    let token = window.localStorage.getItem("user_token")
    // let 

    if(token || to.path == '/bargain/login'){
        // 用户已经授权过或正在授权
        next()
    }else{
        // 用户第一次进入
        next('/bargain/login')
        return false
    }
    
    if((token && to.path == '/bargain/login' && !to.query.flag) || (token && to.path == '/bargain/')) {
        window.console.log('to.query',JSON.stringify(to.query))
        // 用户使用后退返回到授权页，则默认回到list
        next('/bargain/list')
        return false
    }
    // 设置路由title
    document.title = to.meta.title
    next()
})

export default router


