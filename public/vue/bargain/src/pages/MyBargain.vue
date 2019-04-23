<template>
    <div class="main">
        <!-- {{bargainOrdersData.bargain_orders}} -->
        <ul class="list" v-if="bargainOrdersData.length>0">
            <li v-for="(order,index) in bargainOrdersData" v-bind:key="order.id" >
                <div class="goods-info">
                    <div class="pic">
                        <img :src="myconf.api_host+order.goods.img1_id" alt="">
                    </div>
                    <div class="info">
                        <p class="goods-name">{{order.goods.goods_name}}<span>(￥{{order.goods.original_price}})</span></p>
                        <div class="old-price">当前价：￥{{order.goods.original_price-order.helpers_sum}}</div>
                        <div class="order-sn">单号：{{order.bargain_sn}}</div>
                        <!-- <div><countdown :endtime='order.over_time' @timeEnd="isTimeEnd[order.id]=false"></countdown></div> -->
                        <div><countdown :endtime='order.over_time' @timeEnd="timeEndHandel(index)"></countdown></div>
                        <div class="btns">
                            <div class="link" @click="showRecord(order.bargain_sn)">查看记录</div>
                            <router-link class="link" v-if="isTimeEnd[index] != false" :to="{name:'detail',query:{no:order.bargain_sn}}">继续砍价</router-link>
                            <div class="link over-link" v-else>当前砍价已结束</div>
                        </div>
                    </div>
                </div>
                <transition name="fade">
                    <div class="record" v-show="flag && isShowRecord==order.bargain_sn">
                        <ul>
                            <li v-for="user of order.helpers" :key="user.id">
                                <img :src="user.user.headimgurl" alt="">
                                <p>{{user.user.nickname}}</p>
                                <span>{{user.bargain_money}}元</span>
                            </li>
                        </ul>
                    </div>
                </transition>
            </li>
        </ul>
        <div v-else>砍价单空空如也，您还没有发起过砍价！</div>
        <footer>
            <router-link to="/list">活动商品</router-link>
            <router-link to="/mybargain">我的砍价</router-link>
        </footer>
    </div>


</template>

<script>
import axios from 'axios'
import countdown from './components/Countdown.vue';
export default {
    name: "mybargain",
    components:{
		countdown
	},
    data(){
        return{
            bargainOrdersData:{},
            isShowRecord:'',//显示详细砍价记录
            flag:true,
            isTimeEnd:[]
        }
    },
    created() {
        this.getBargainOrders()
    },
    methods:{
        getBargainOrders(){
            axios({
                method:'GET',
                url:this.myconf.api_host+"/bargian_api/bargainorders",
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
        },

        // 显示隐藏详细砍价记录
        showRecord(no){
            // console.log(e)
            this.isShowRecord = no
            this.flag=!this.flag
            // alert(this.isShowRecord)
        },

        // 倒计时结束处理
        timeEndHandel(index){
            // alert('time end')
            // this.isTimeEnd = no
            this.$set(this.isTimeEnd, index, false)
        }

        

    }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.main{padding-bottom: 1rem;}
.list li{
    margin-top: 10px;
    margin-bottom: 30px;
    border-bottom: 1px dashed #666;
    padding-bottom: 5px;
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
.list li .goods-info .info{
    width: 60%;
    line-height: 0.35rem;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    
}
.list li .goods-info .info .goods-name{
    font-size: 0.26rem;
    color: red;
    font-weight: bold;
}
.list li .goods-info .info .goods-name span{
    font-size: 0.18rem;
}
.list li .goods-info .info .btns{
    display: flex;
    justify-content: space-between;
}
.list li .goods-info .info .link{
    width: 46%;
    border-radius: 5px;
    background: rgb(236, 61, 61);
    color: #fff;
    height: 0.5rem;
    line-height: 0.5rem;
    text-align:center;
    font-size: 0.23rem;
}
.list li .goods-info .info .over-link{
    background: #ccc;
    color: #000;
}
.list .record li{
    display: flex;
    border: 1px dotted #eee;
    align-items: center;
    margin: 0;
}
.list .record li img{
    width: 40px;
    height: 40px;
    border-radius: 100%;
}
.list .record li p{
    margin: 0 12px;
    width: 33%;
    text-align: left;
}
.fade-enter-active, .fade-leave-active {
  transition: opacity .5s;
}
.fade-enter, .fade-leave-to {
  opacity: 0;
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
