<template>
    <div>dasd

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
        // let redirect_uri = 'http://192.168.1.253/wx_bargain_api/Token/callback'
        // let redirect_uri = encodeURIComponent('http://192.168.1.253/test/#/token/?')
        let redirect_uri = encodeURIComponent('http://127.0.0.1/bargain/#/token/')
        // let redirect_uri = encodeURIComponent(window.location.href.split('#')[0]+'#');
        let scope='snsapi_userinfo';
        let url = `https://open.weixin.qq.com/connect/oauth2/authorize?appid=${appid}&redirect_uri=${redirect_uri}&response_type=code&scope=${scope}&state=STATE#wechat_redirect`
        window.location.href=url;
    }
}
</script>


<style>

</style>
