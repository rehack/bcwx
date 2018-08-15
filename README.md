# vue2+thinkPHP5.1 前后端分离的微信砍价活动

## 需求：

-   微信公众号网页授权识别用户身份
-   选择商品进行分享
-   帮助砍价的用户可以帮助砍价（有活动时间限制，只能帮助同一个人砍价一次，砍价商品有最低价限制，砍多少有一个范围随机的）
-   帮助砍价的用户也可以自己选择商品分享砍价
-   暂时没有在线支付功能
-   权限控制，没有授权的用户(无 token),不能参与分享和砍价
-   用户帮助砍完价之后，可以继续分享出去

## 大致流程：

微信用户点击进入入口链接授权-> 获取 openid 等用户信息->存入数据库->生成 token>把 token 返回到客户端 -> 展示商品列表-> 选择一个商品进入详情页-> 详情页有一个分享按钮->分享到朋友圈或好友-> 别人进入分享的链接帮忙砍价（也可以自己选择一个商品参与分享砍价）

## 技术点：

1. 采用前后端分离模式进行开发，前端采用 vue2+vue-cli3,后端采用 tp5.1,API 采用 restfull 标准设计，公众号为认证的服务号
2. 采用 token 机制来授权接口，用户第一次进入会颁发一个 token(同时存入服务端缓存文件)给客户，然后存入客户端，客户每次请求都要带上这个 token(放 headers 里)，服务端拿到 token 后，从缓存中通过 token 读取用户信息
3. 为防止 token 被盗，所以后端缓存 token 的过期时间不能设置太长
4. 分享链接只携带订单编号

## 采坑：

#### redirect_uri 无限跳转

前端微信网页授权获取 code 的过程中使用了 router.beforeEach()路由拦截机制，无论使用哪个 url 进入网站都会先触发 router.beforeEach 钩子，在 router.beforeEach 钩子中判断用户当前登录状态，判断 window.localStorage.getItem("user_token")，没有就跳转到/login 路由，有就进入/list 路由。/login 路由里面的 redirect_uri 回调地址最好设置成当前的/login 路由地址，否则会出现路由死循环。同时判断/login 路由有无 code 参数，有就取到 code，提交给后台，后台拿到 code 返回 token,url 没有 code 参数就打开微信授权接口链接

redirect_uri 参数错误的几种原因：

1. appid 不正确
2. 公众平台配置的 OAuth2.0 网页授权 授权回调页面域名不正确，不带 http，测试号可以带端口可以是 ip
3. redirect_uri 回调地址不能正常访问

#### 采用前后端分离跨域问题

在 tp5 路由配置里添加 allowCrossDomain()，但是发现当前端用 axios 把 token 放到 headers 里面，然后提交给后台的时候还是存在跨域。找到了两种方法解决：

1. 在 nginx 里添加
   add_header 'Access-Control-Allow-Headers' 'Authorization, Content-Type, If-Match, If-Modified-Since, If-None-Match, If-Unmodified-Since, X-Requested-With,Access-Token';
   Access-Token 就是 axios Headers 里面的参数
2. 既然 Reopnse Headers 里面的 Access-Control-Allow-Headers 不存在 Access-Token 这一项，但存在 Authorization，所以就就把 token 值放到 Authorization 里传递到后端，至此 Access-Control-Allow-Headers 的跨域问题得到解决

还遇到一个奇怪的跨域问题，用 var_dump 打印一个模型查询结果,代码有问题也会出现 No 'Access-Control-Allow-Origin' header is present on the requested resource 跨域错误，有空再追踪 tp5 源码

#### vue history 模式和 hash 模式

当采用 hash 模式的时候，微信重定向到 redirect_uri 上的时候,redirect_uri 路由被破坏，原本的 xxx.com:8080/#/login 变成了 xxx.com:8080/?code=xxxx&state=xxx#/login
后面使用 this.$router.push()方法的时候，路由地址始终是这样，有个 code 参数在上面，hash 值在所有参数后面，这种链接分享出去不是很友好，在 ios 下也会出现问题（这种路由中带了参数的 url 是没法签名校验成功的）

我的解决办法是采用 history 模式，但 history 模式在前后端分离的项目中打包上线后会出现 404 情况，需要 nginx 配合:
我 vue 打包部署在二级目录

```
location /bargain {
    #root "E:/mygit/bcwx/public";   //你自己的根目录地址

    # 这里的 /bargain/ 也可以写成/bargain/index.html
    try_files $uri $uri/ /bargain/;
}
```

除了要改 nginx 配置外，还需要修改 vue 项目中路由相关代码，根目录不再是/ 而是配置的二级目录，路由地址前面都要加上这个目录，虽然在开发模式下不加也没啥问题，为了不在打包上线后一脸懵逼，最好是在开发阶段就加上,router-link 和 window.location 下面的 path 也要手动改,还有 router.beforeEach 里面的也要改，

总结来说使用 history 模式部署在二级目录有三个地方需要配置：

A.vue.config.js(cli3.0)

```javascript
baseUrl:'/xxx',
```

B.nginx

```
location /bargain {
    #root "E:/mygit/bcwx/public";   //你自己的根目录地址

    # 这里的 /bargain/ 也可以写成/bargain/index.html
    try_files $uri $uri/ /bargain/;
}
```

其他服务端配置参考https://router.vuejs.org/zh/guide/essentials/history-mode.html#%E5%90%8E%E7%AB%AF%E9%85%8D%E7%BD%AE%E4%BE%8B%E5%AD%90

C.vue 路由配置

```javascript
const router = new Router({
    mode: "history",
    base: "/xxx/", //这个很重要
    routes
});
```

#### 调用微信 js-sdk 分享接口的时候 签名校验失败 invalid signature

造成这个错误的原因很多(参考附录 5<https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1421141115>),常见的有：

A.URL 造成签名校验失败的可能性最大，此 URL 指的是当前使用微信 sdk 的前端页面路径，需要前端传给后台或后台直接获取，然后后台用来生成一些 config 接口注入权限验证配置参数。
前端一般通过 location.href.split('#')[0]获取当前 URL，并 encodeURIComponent 转码，然后传给后端，后端拿到 url 也要进行 urldecode 解码。问题是在 iOS 上通过$router.push()进行页面切换的时候，页面内容改变了，但是 URL 地址没有变，更奇怪的是通过 location.href.split('#')[0]获取到是 url 是正确的，然而通过右上角菜单复制出来的 URL 可以发现，复制出来的 url 还是最开始进入页面的入口 URL，按道理讲只有 location.href.split('#')[0]的 url 地址是正确的，就能校验通过，最后我尝试吧最开始进入页面的 URL 地址保存起来，拿来做签名的 URL，网上很多人是这样做的，但我没有成功。同时我还发现手动刷新一下当前页面，然后复制出来的 URL 就和 location.href.split('#')[0]的值一样了。于是我想到的解决方案就是当进入这个签名页面的时候，先自动刷新一下，让页面 url 地址正常，或者使用 location.href 代替$router.push()路由方式进行跳转，这样 url 地址就不会有问题,网上通用的解决方案是把 iOS 下第一次进入的路由存起来，用于签名参考<https://segmentfault.com/a/1190000014455713>

B.前端 config 中的 appid 与和后端获取 jsapi_ticket 的 appid 不一致

C.access_token 和 jsapi_ticket 没缓存起来

D.JS 接口安全域名没有配置正确，测试号管理下的 JS 接口安全域名是可以带端口的，也可以是本地 ip

E.官方提供了一个签名检测工具https://mp.weixin.qq.com/debug/cgi-bin/sandbox?t=jsapisign,也可以用它来排查问题

微信 js-sdk 分享经验总结：
a、对于 Android，用每个页面的 URL 做签名参数，对于 IOS，使用入口 URL 进行签名（切记），我是使用 VUEX 进行 url 的更新
b、一定要在 mounted 中做签名的初始化操作，反正我的 created 就是不成功。
c、对需要签名的 URL 进行 encodeURIComponent 编码，这个主要处理 URL 带参的分享问题。
d、在后台再对用于签名的 URL 进行一次解码。

#### vue 相关错误

类似这种错误[Vue warn]: Error in render: "TypeError: Cannot read property 'images' of undefined"的原因是 data 里面确实没有配置相关数据，或者 data 里面的数据默认格式不正确，和服务器传来的数据格式不一致，比如你配置的是 data:null,而服务器返回是一个数组
还有一种解决办法是渲染数据的时候加 v-if="Data.xxx"

#### CSS 中的背景和边框问题：

当一个元素边框是透明的时候，这个元素的背景色会侵透扩展到边框下，从而使透明边框不能正常显示，尤其是边框色和背景色一致的时候，解决办法是 background-clip: padding-box;属性来调整背景范围，默认值为 border-box
扩展：多重边框使用 box-shadow，双重边框使用 outline

#### vue 路由在 iOS 下 URL 不变的问题：

在 iOS 下会发现 vue 的路由跳转后，页面的 URL 没有跟着发生改变，通过右上角菜单把链接复制出来就能发现 url 还是最开始进入页面的 url,但是路由跳转后，页面的内容还是会变，这个问题导致了微信签名校验失败 invalid signature，参考上面`调用微信js-sdk分享接口的时候 签名校验失败invalid signature`

参考链接：<br>
<https://www.jianshu.com/p/a1a31f9da272><br>
<https://github.com/vuejs/vue-router/issues/481><br>
<https://zhuanlan.zhihu.com/p/31887792><br>
<https://www.jianshu.com/p/a1a31f9da272>

#### iOS 下 Data.parse 和 new Date(time)兼容问题

iOS 下 Data.parse 和 new Date(time)不能正常的转换时间戳，因为传入的时间的格式是 2018-8-14 10:03:45 这种，要改成 2018/8/14 10:03:45 这种格式
所以解决方法是:前端用正则替换 time.replace(/-/g, '/'); 或者后端返回 2018/8/14 10:03:45 这种格式的时间
