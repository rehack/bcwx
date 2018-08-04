<template>
    <div>
        授权中。。。

        <!-- 参考https://www.jb51.net/article/138007.htm
        https://ask.csdn.net/questions/679367 
        
        #号问题  https://www.cnblogs.com/manman04/p/6129464.html
        
        vw  https://www.jianshu.com/p/eb0d00e8ffed
        
        vw  https://www.w3cplus.com/mobile/vw-layout-in-vue.html-->
    </div>
    
</template>

<script>
export default {
    name:"Login",

    created(){
        let appid = 'wx150347fed55855dd';
        let protocol = window.location.protocol
        let host = window.location.host
        // window.console.log(this.$route)


        // 重定向地址，跳转后会带一个code参数
        let redirect_uri = encodeURIComponent(`${protocol}//${host}/#/token/`)
        window.localStorage.setItem('flag', true)
        let url = `https://open.weixin.qq.com/connect/oauth2/authorize?appid=${appid}&redirect_uri=${redirect_uri}&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect`

        window.location.href=url;
    }
}
</script>


<style>

</style>
