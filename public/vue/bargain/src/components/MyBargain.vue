<template>
    <div class="main">
        <ul class="list">
            <li v-for="item of bargainOrdersData" v-bind:key="item.id">
                <div class="goods-info">
                    <div class="pic">
                        <img :src="lib.APIHOST+item.goods.img1_id" alt="">
                    </div>
                    <div class="info">
                        <p class="goods-name">{{item.goods.goods_name}}</p>
                        <div class="old-price">原价：￥{{item.goods.original_price}}</div>
                        <div class="old-price">当前价：￥{{item.deal_money}}</div>
                        <div class="order-sn">单号：{{item.bargain_sn}}</div>
                        <div class="time">砍价单日期：{{item.create_time}}</div>
                        <router-link class="link" :to="{path:'detail',query:{no:item.bargain_sn}}">继续砍价</router-link>
                    </div>
                </div>
            </li>
        </ul>
        <footer>
            <router-link to="/list">活动商品</router-link>
            <router-link to="/mybargain">我的砍价</router-link>
        </footer>
    </div>


</template>

<script>
import axios from 'axios'
export default {
    name: "mybargain",
    data(){
        return{
            bargainOrdersData:null
        }
    },
    created() {
        this.getBargainOrders()
    },
    methods:{
        getBargainOrders(){
            axios({
                method:'GET',
                url:this.lib.APIHOST+"/bargian_api/bargainorders",
                headers:{
                    "Authorization":window.localStorage.getItem('user_token')
                }
            })
            .then(response=>{
                let result = response.data
                this.bargainOrdersData =result
                window.console.log(result)
            })
            .catch(error=>{
                let msg = error.response.data.msg
                if(msg == 'token已过期或无效token'){
                    window.localStorage.removeItem('user_token')
                    this.$router.push({name:'login',query:{flag:'share',no:this.no}})
                }else if(msg != 'token已过期或无效token'){
                    alert(msg)
                }else{
                    alert('发生错误')
                }
            })
        }
    }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.main{padding-bottom: 1rem;}
.list li{
    margin-top: 15px;
    border-bottom: 1px dashed #666;
}
.list li .goods-info{
    display: flex;
    text-align: left;
    justify-content: space-around;
    font-size: 0.22rem;
}
.list li .goods-info .pic{
    width: 36%;
}
.list li .goods-info img{
    width: 100%;
}
.list li .goods-info .info .goods-name{
    font-size: 0.26rem;
    color: red;
    font-weight: bold;
}
.list li .goods-info .info .link{
    border-radius: 5px;
    background: rgb(236, 61, 61);
    color: #fff;
    padding: 3px 7px;
}
footer{
    width: 100%;
    margin: 0 auto;
    display: flex;
    position: fixed;
    bottom: 0;
    background: #eee;
    align-items: center;
    justify-content: space-around;
    height: 0.8rem;
}
footer a{
    background: #d7b150;
    color: #fff;
    font-size: 0.26rem;
    border-radius: 5px;
    padding: 5px 10px;
}
</style>
