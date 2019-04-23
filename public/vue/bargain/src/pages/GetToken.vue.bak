<template>
    <div>
        token page
        <p>{{token}}</p>
        <p>{{code}}</p>
        <!-- 
            参考https://www.jb51.net/article/138007.htm   router.beforeEach
        https://ask.csdn.net/questions/679367 
        https://www.v2ex.com/t/420936
        -->
    </div>
    
</template>

<script>
import axios from 'axios'

export default {
    data(){
        return{
            code:'',
            token:''
        }
    },

    created: function () {
        this.getWxCode()
    },
    methods:{
        getWxCode(){
            // this.code=this.$route.query.code
            // let url = window.location.search
            let code = this.getUrlParam('code')
            
            if(code){
                this.code=code
                this.getToken();
            }
        },

        getToken(){
            // let protocol = window.location.protocol
            // let host = window.location.host

            // let url = `${protocol}//${host}/wx_bargain_api/Token/getToken/`
            // 后台code换token接口
            let url = 'http://192.168.3.2/bargian_api/gettoken'

            axios.get(url,{params: { code: this.code }})
                .then(resopnse=>{
                    window.console.log(resopnse)
                    let token = resopnse.data.token
                    this.token=token
                    window.localStorage.setItem('user_token',token)
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
