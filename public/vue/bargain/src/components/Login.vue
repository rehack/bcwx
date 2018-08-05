<template>
    <div>
        {{message}}

        <!-- 参考https://www.jb51.net/article/138007.htm
        https://ask.csdn.net/questions/679367 
        https://segmentfault.com/a/1190000010753247

        https://blog.csdn.net/weixin_32697945/article/details/78318615
        VUE开发SPA之较舒服的微信授权登录

        
        #号问题  https://www.cnblogs.com/manman04/p/6129464.html
        
        vw  https://www.jianshu.com/p/eb0d00e8ffed
        
        vw  https://www.w3cplus.com/mobile/vw-layout-in-vue.html-->
    </div>
    
</template>

<script>
import axios from 'axios'
export default {
    name:"Login",
    data(){
        return{
            message:'玩命加载中。。。'
        }
    },
    created(){
        let appid = 'wx150347fed55855dd';
        let protocol = window.location.protocol
        let host = window.location.host
        window.console.log(this.$route)
        // let path = this.$route.path

        // 重定向地址，跳转后会带一个code参数
        let redirect_uri = encodeURIComponent(`${protocol}//${host}/#/login`)
        // let redirect_uri = encodeURIComponent(path)
        // window.localStorage.setItem('flag', true)
        let url = `https://open.weixin.qq.com/connect/oauth2/authorize?appid=${appid}&redirect_uri=${redirect_uri}&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect`

        let code = this.getUrlParam('code')
        if(code){
            this.getToken(code)
        }else{
            window.location.href=url;
        }
    },

    methods:{
        getToken(code){
            // let protocol = window.location.protocol
            // let host = window.location.host

            // let url = `${protocol}//${host}/wx_bargain_api/Token/getToken/`
            // 后台code换token接口
            let url = 'http://192.168.3.2/bargian_api/gettoken'

            axios.get(url,{params: { code: code }})
                .then(resopnse=>{
                    window.console.log(resopnse)
                    let token = resopnse.data.token
                    if(token){
                        window.localStorage.setItem('user_token',token)
                        // 获取到token后跳转到商品列表
                        this.$router.push({name:'list'})
                    }else{
                        this.message = resopnse.data
                    }
                    
                })
                .catch(error=>{
                    this.message = error.response.data
                    // console.log(error)
                })

        },
        /*通过正则获取url中的参数*/
        getUrlParam(name){
            var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
            var r = window.location.search.substr(1).match(reg);
            if(r!=null)return decodeURI(r[2]); return null;
        }
    }
}
</script>


<style>

</style>
