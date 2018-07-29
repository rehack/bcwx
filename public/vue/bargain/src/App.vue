<template>
<!--参考 https://github.com/iSAM2016/wechat 
https://segmentfault.com/a/1190000010753247
https://m.imooc.com/act/share
https://jingyan.baidu.com/article/9158e00042cab4a255122860.html
https://www.cnblogs.com/manman04/p/6129464.html
https://github.com/ninggege/wixin_kanjia/blob/master/weixin_kanjia/Application/Home/Controller/IndexController.class.php
https://segmentfault.com/a/1190000009493199
https://github.com/wshshra/vue-wechat-plugin
https://github.com/jindasong/vue-wechat-auth
https://github.com/raychenfj/v-wechat-auth
http://www.ruanyifeng.com/blog/2014/05/oauth_2_0.html
-->
    <div id="app">
        <img src="./assets/logo.png">
    </div>
</template>

<script>
import axios from "axios";
export default {
    name: "app",
    data(){
        return{

        }
    },

    created(){
        const url = 'https://bcwx.rehack.cn/bargain_api/login';
        /* Axios({
            method:"get",
            url:'https://bcwx.rehack.cn/wx_bargain_api/index/getUserCode',
            data:{
                
            },
            then(data){
                console.log(data)
            }
        }) */
        axios
        .get(url)
        .then(response=>{
            window.console.log(response.data)
        });
    }
    
};
</script>

<style>
#app {
    font-family: "Avenir", Helvetica, Arial, sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    text-align: center;
    color: #2c3e50;
    margin-top: 60px;
}
</style>
