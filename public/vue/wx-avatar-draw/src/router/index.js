import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home.vue'
import Login from '../views/Login.vue'
import Draw from '../views/Draw.vue'

Vue.use(VueRouter)

  const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home,
    meta: {
        title: '贝臣口腔'
    }
  },
  {
    path: '/login',
    name: 'Login',
    component: Login,
    meta: {
        title: '贝臣口腔'
    }
  },
  {
    path: '/draw',
    name: 'Draw',
    component: Draw,
    meta: {
        title: '贝臣口腔抽奖活动'
    }
  }
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})
// 登陆验证拦截
router.beforeEach((to, from, next) => {
    let token = window.localStorage.getItem("user_token")
    // let 

    if(token || to.path == '/login'){
        // 用户已经授权过或正在授权
        next()
    }else{
        // 用户第一次进入
        if(to.path == '/draw'){ //抽奖界面不用限制
            next()
        }else{
            next('/login')
            return false
        }
        
    }
    
    if((token && to.path == '/login' && !to.query.flag) || (token && to.path == '/')) {
        window.console.log('to.query',JSON.stringify(to.query))
        // 用户使用后退返回到授权页，则默认回到首页
        next('/')
        return false
    }
    // 设置路由title
    document.title = to.meta.title
    next()
})

export default router
