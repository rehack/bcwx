<template>
    <div>
        <p>{{token}}</p>
        <p>{{code}}</p>
        <!-- 参考https://www.jb51.net/article/138007.htm
        https://ask.csdn.net/questions/679367 
        https://www.v2ex.com/t/420936
        -->
    </div>
    
</template>

<script>
import axios from 'axios'

export default {
    name:"GetToken",
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
            this.code=code
            if(code){

                this.getToken();
            }
        },

        getToken(){
            window.console.log('axios')
            axios.get('http://127.0.0.1/wx_bargain_api/Token/getToken/',{params: { code: this.code }})
                .then(resopnse=>{
                    window.console.log(resopnse)
                    this.token=resopnse.data
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
