<template>
    <div class="main">
        <ul class="list">
            <li v-for="item of bargainOrdersData" v-bind:key="item.id">
                <div class="goods-info">
                    <div class="pic">
                        <img :src="lib.APIHOST+item.goods.img1_id" alt="">
                    </div>
                    <div class="info">
                        <p class="goods-name">{{item.goods.goods_name}}<span>(￥{{item.goods.original_price}})</span></p>
                        <!-- <div class="old-price">原价：￥{{item.goods.original_price}}</div> -->
                        <div class="old-price">当前价：￥{{item.deal_money}}</div>
                        <div class="order-sn">单号：{{item.bargain_sn}}</div>
                        <div class="time">砍价单日期：{{item.create_time}}</div>
                        <div>
                            倒计时：{{`${day}天${hr}小时${min}分钟${sec}秒`}}
                            <router-link class="link" :to="{path:'detail',query:{no:item.bargain_sn}}">继续砍价</router-link>
                        </div>
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
            bargainOrdersData:null,
            day: 0, hr: 0, min: 0, sec: 0,
        }
    },
    created() {
        this.getBargainOrders()
    },
    mounted: function () {
            this._interval = setInterval(() => {
                this.countdown();
            }, 1000)
        },
         destroyed () {
            clearInterval(this._interval)
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
        },

        // 倒计时
        countdown: function () {
                const end = Date.parse(new Date(this.bargainOrdersData[0].over_time));
                const now = Date.parse(new Date());
                const msec = end - now;
                let day = parseInt(msec / 1000 / 60 / 60 / 24);
                let hr = parseInt(msec / 1000 / 60 / 60 % 24);
                let min = parseInt(msec / 1000 / 60 % 60);
                let sec = parseInt(msec / 1000 % 60);
                this.day = day;
                this.hr = hr > 9 ? hr : '0' + hr;
                this.min = min > 9 ? min : '0' + min;
                this.sec = sec > 9 ? sec : '0' + sec;
               
                // const that = this;
                // console.log(this.day===0 && this.hr===‘00‘ && this.min===‘00‘&& this.sec===‘00‘);
                // if(this.day===0 && this.hr=== ‘00‘ && this.min===‘00‘&& this.sec ===‘00‘){
                //     console.log(1234566)
                //     return
                // }
                // setTimeout(function () {
                //     that.countdown()
                // }, 1000)
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
.list li .goods-info .info .link{
    border-radius: 5px;
    background: rgb(236, 61, 61);
    color: #fff;
    /* padding: 3px 7px; */
    height: 0.4rem;
    line-height: 0.4rem;
    text-align:center;
    font-size: 0.23rem;
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
