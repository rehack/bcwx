<template>
    <div class="home">
        <div class="user">
            <img :src="user.headimgurl" alt="">
            <p>{{user.nickname}}</p>
        </div>
        <div class="info">感谢您参与本次贝臣口腔发布的抽奖活动，随后将在大屏进行抽奖和公布抽奖结果，您也可以实时关注下方抽奖状态！</div>
        <!-- <div class="btn" @click="query">查询是否中奖</div> -->
        <div class="status">
            <span v-if="user && user.isprize == 1">中奖状态：恭喜您中奖({{user.prize_item}})</span>
            <span v-else>中奖状态：未中奖</span>
        </div>
    </div>
</template>

<script>
// @ is an alias to /src
import axios from 'axios'
export default {
    name: 'Home',
    data() {
        return {
            user: null
        }
    },
    mounted(){
        this.query()
    },
    methods: {
        query() {
            axios({
                url: process.env.VUE_APP_SERVER_URL+'/avatardraw/isprize',
                method:'get',
                headers:{
                    Authorization: window.localStorage.getItem('user_token')
                }
            }).then(res=>{
                console.log(res.data)
                this.user = res.data
                setTimeout(() => {
                    this.query()
                }, 5000);
            }).catch(err=>{
                // console.log(err)
                // alert(err)
                window.localStorage.clear()
            })
        }
    }

}
</script>
<style lang="scss" scoped>
.home {
    .user{
        margin-top: 10px;
        img{
            width: 60px;
            height: 60px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }
    }
    .info {
        margin-top:20px;
        text-align: left;
    }
    .btn {
        margin: 0 auto;
        margin-top: 50px;
        padding: 5px 0;
        width: 50%;
        background-color: #04be02;
        color: #fff;
        border-radius: 5px;
    }
    .status{
        margin-top: 50px;
        color: red;
    }
}
</style>
