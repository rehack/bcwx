# vue2+thinkPHP5.1前后端分离的微信砍价活动

## 需求：
- 微信公众号网页授权识别用户身份
- 选择商品进行分享
- 帮助砍价的用户可以帮助砍价（有活动时间限制，只能帮助同一个人砍价一次，砍价商品有最低价限制，砍多少有一个范围随机的）
- 帮助砍价的用户也可以自己选择商品分享砍价
- 暂时没有在线支付功能
- 权限控制，没有授权的用户(无token),不能参与分享和砍价
- 用户帮助砍完价之后，可以继续分享出去


## 大致流程：
微信用户点击进入入口链接授权-> 获取openid等用户信息->存入数据库->生成token>把token返回到客户端 -> 展示商品列表-> 选择一个商品进入详情页-> 详情页有一个分享按钮->分享到朋友圈或好友-> 别人进入分享的链接帮忙砍价（也可以自己选择一个商品参与分享砍价）




## 技术点：
1. 采用前后端分离模式进行开发，前端采用vue2+vue-cli3,后端采用tp5.1,API采用restfull标准设计，公众号为认证的服务号
2. 采用token机制来授权接口，用户第一次进入会颁发一个token(同时存入服务端缓存文件)给客户，然后存入客户端，客户每次请求都要带上这个token(放headers里)，服务端拿到token后，从缓存中通过token读取用户信息
3. 为防止token被盗，所以后端缓存token的过期时间不能设置太长
4. 分享链接只携带订单编号


## 采坑：
#### redirect_uri无限跳转
前端微信网页授权获取code的过程中使用了router.beforeEach()路由拦截机制，无论使用哪个url进入网站都会先触发router.beforeEach钩子，在router.beforeEach钩子中判断用户当前登录状态，判断window.localStorage.getItem("user_token")，没有就跳转到/login路由，有就进入/list路由。/login路由里面的redirect_uri回调地址最好设置成当前的/login路由地址，否则会出现路由死循环。同时判断/login路由有无code参数，有就取到code，提交给后台，后台拿到code返回token,url没有code参数就打开微信授权接口链接

redirect_uri 参数错误的几种原因：
1. appid不正确
2. 公众平台配置的OAuth2.0网页授权 授权回调页面域名不正确，不带http，测试号可以带端口可以是ip
3. redirect_uri回调地址不能正常访问


#### 采用前后端分离跨域问题
在tp5路由配置里添加allowCrossDomain()，但是发现当前端用axios把token放到headers里面，然后提交给后台的时候还是存在跨域。找到了两种方法解决：
1. 在nginx里添加
add_header 'Access-Control-Allow-Headers'  'Authorization, Content-Type, If-Match, If-Modified-Since, If-None-Match, If-Unmodified-Since, X-Requested-With,Access-Token';
Access-Token就是axios Headers里面的参数
2. 既然Reopnse Headers里面的Access-Control-Allow-Headers不存在Access-Token这一项，但存在Authorization，所以就就把token值放到Authorization里传递到后端，至此Access-Control-Allow-Headers的跨域问题得到解决

还遇到一个奇怪的跨域问题，用var_dump打印一个模型查询结果,代码有问题也会出现No 'Access-Control-Allow-Origin' header is present on the requested resource跨域错误，有空再追踪tp5源码

#### vue history模式和hash模式
当采用hash模式的时候，微信重定向到redirect_uri上的时候,redirect_uri路由被破坏，原本的xxx.com:8080/#/login 变成了xxx.com:8080/?code=xxxx&state=xxx#/login
后面使用this.$router.push()方法的时候，路由地址始终是这样，有个code参数在上面，hash值在所有参数后面，这种链接分享出去不是很友好，在ios下也会出现问题（这种路由中带了参数的url是没法签名校验成功的）

我的解决办法是采用history模式，但history模式在前后端分离的项目中打包上线后会出现404情况，需要nginx配合:
我vue打包部署在二级目录
```
location /bargain {
    #root "E:/mygit/bcwx/public";   //你自己的根目录地址

    # 这里的 /bargain/ 也可以写成/bargain/index.html
    try_files $uri $uri/ /bargain/;    
}
```
除了要改nginx配置外，还需要修改vue项目中路由相关代码，根目录不再是/ 而是配置的二级目录，路由地址前面都要加上这个目录，虽然在开发模式下不加也没啥问题，为了不在打包上线后一脸懵逼，最好是在开发阶段就加上,router-link和window.location下面的path也要手动改,还有router.beforeEach里面的也要改，

总结来说使用history模式部署在二级目录有三个地方需要配置：
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


C.vue路由配置
```javascript
const router = new Router({
    mode:'history',
    base: '/xxx/',//这个很重要
    routes
})
```


#### 调用微信js-sdk分享接口的时候 签名校验失败invalid signature
造成这个错误的原因很多(参考附录5<https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1421141115>),常见的有：

A.URL造成签名校验失败的可能性最大，此URL指的是当前使用微信sdk的前端页面路径，需要前端传给后台或后台直接获取，然后后台用来生成一些config接口注入权限验证配置参数。
前端一般通过location.href.split('#')[0]获取当前URL，并encodeURIComponent转码，然后传给后端，后端拿到url也要进行urldecode解码。问题是在iOS上通过$router.push()进行页面切换的时候，页面内容改变了，但是URL地址没有变，更奇怪的是通过location.href.split('#')[0]获取到是url是正确的，然而通过右上角菜单复制出来的URL可以发现，复制出来的url还是最开始进入页面的入口URL，按道理讲只有location.href.split('#')[0]的url地址是正确的，就能校验通过，最后我尝试吧最开始进入页面的URL地址保存起来，拿来做签名的URL，网上很多人是这样做的，但我没有成功。同时我还发现手动刷新一下当前页面，然后复制出来的URL就和location.href.split('#')[0]的值一样了。于是我想到的解决方案就是当进入这个签名页面的时候，先自动刷新一下，让页面url地址正常，或者使用location.href代替$router.push()路由方式进行跳转，这样url地址就不会有问题,网上通用的解决方案是把iOS下第一次进入的路由存起来，用于签名参考<https://segmentfault.com/a/1190000014455713>

B.前端config 中的 appid 与和后端获取 jsapi_ticket 的 appid不一致

C.access_token和jsapi_ticket没缓存起来

D.JS接口安全域名没有配置正确，测试号管理下的JS接口安全域名是可以带端口的，也可以是本地ip

E.官方提供了一个签名检测工具https://mp.weixin.qq.com/debug/cgi-bin/sandbox?t=jsapisign,也可以用它来排查问题

微信js-sdk分享经验总结：
a、对于Android，用每个页面的URL做签名参数，对于IOS，使用入口URL进行签名（切记），我是使用VUEX进行url的更新
b、一定要在mounted中做签名的初始化操作，反正我的created就是不成功。
c、对需要签名的URL进行encodeURIComponent编码，这个主要处理URL带参的分享问题。
d、在后台再对用于签名的URL进行一次解码。

#### vue相关错误
类似这种错误[Vue warn]: Error in render: "TypeError: Cannot read property 'images' of undefined"的原因是data里面确实没有配置相关数据，或者data里面的数据默认格式不正确，和服务器传来的数据格式不一致，比如你配置的是data:null,而服务器返回是一个数组
还有一种解决办法是渲染数据的时候加v-if="Data.xxx"


#### CSS中的背景和边框问题：
当一个元素边框是透明的时候，这个元素的背景色会侵透扩展到边框下，从而使透明边框不能正常显示，尤其是边框色和背景色一致的时候，解决办法是background-clip: padding-box;属性来调整背景范围，默认值为border-box
扩展：多重边框使用box-shadow，双重边框使用outline 

#### vue路由在iOS下URL不变的问题：
在iOS下会发现vue的路由跳转后，页面的URL没有跟着发生改变，通过右上角菜单把链接复制出来就能发现url还是最开始进入页面的url,但是路由跳转后，页面的内容还是会变，这个问题导致了微信签名校验失败invalid signature，参考上面`调用微信js-sdk分享接口的时候 签名校验失败invalid signature`

参考链接： 
<https://www.jianshu.com/p/a1a31f9da272>
<https://github.com/vuejs/vue-router/issues/481>
<https://zhuanlan.zhihu.com/p/31887792>
<https://www.jianshu.com/p/a1a31f9da272>



#### iOS下Data.parse和new Date(time)兼容问题
iOS下Data.parse和new Date(time)不能正常的转换时间戳，因为传入的时间的格式是2018-8-14 10:03:45这种，要改成2018/8/14 10:03:45这种格式
所以解决方法是:前端用正则替换time.replace(/-/g, '/'); 或者后端返回2018/8/14 10:03:45这种格式的时间






