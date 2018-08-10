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
        if(!window.localStorage.getItem('iosurl')){
            // alert('no')
            window.localStorage.setItem('iosurl',1)
        }
        if(this.isWechat()){
            this.login()
        }else{
            this.message='请在微信中打开...'
        }

        
    },

    methods:{

        // 判断是否是微信环境
        isWechat(){
            let ua = window.navigator.userAgent.toLowerCase();
            return ua.match(/MicroMessenger/i) == 'micromessenger';
        },
        // 微信网页授权
        login(){
            let appid = this.myconf.appid;
            /* let protocol = window.location.protocol
            let host = window.location.host */
            // window.console.log(this.$route)
            // let path = this.$route.path

            // 重定向地址，跳转后会带一个code参数
            // let redirect_uri = encodeURIComponent(`${protocol}//${host}/#/login`)
            // let redirect_uri = encodeURIComponent(`${protocol}//${host}/login`)//history模式
            let redirect_uri = encodeURIComponent(window.location.href)//history模式
            // let redirect_uri = encodeURIComponent(path)
            // window.localStorage.setItem('flag', true)
            let url = `https://open.weixin.qq.com/connect/oauth2/authorize?appid=${appid}&redirect_uri=${redirect_uri}&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect`

            // let code = this.getUrlParam('code');
            let code = this.$route.query.code
            let from = this.$route.query.flag//判断是否来自分享页
            let no = this.$route.query.no
            // http://192.168.1.253:8080/login?flag=share&no=FI8V2018080710154975
            if(code){
                // alert('code:'+code)
                this.getToken(code,from,no)
            }else{
                // alert('nocode')
                window.location.href=url;
            }
        },

        // 通过code换取token
        getToken(code,from,no){

            let url = this.myconf.api_host+'/bargian_api/gettoken'
           
            axios.get(url,{params: { code: code }})
                .then(resopnse=>{
                    // window.console.log(resopnse)
                    let token = resopnse.data.token
                    if(token){
                        window.localStorage.setItem('user_token',token)
                        // 获取到token后跳转到对应页面
                        if(from == 'share' && no){
                            // http://192.168.1.253/bargain/login?no=UTFR2018080948575356&flag=share
                            this.$router.push({name:'dobargain',query: { no }})
                        }else{
                            this.$router.push({name:'list'})
                        }
                    }else{
                        this.message = resopnse.data
                    }
                    
                })
                .catch(error=>{
                    // code不合法等错误（点击返回按钮也会出现）
                    // this.message = error.response.data
                    this.$router.push({name:'list'})
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
