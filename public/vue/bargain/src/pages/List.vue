<template>
    <div class="main">
        <div class="banner">
            <img :src="myconf.api_host+'/static/bargain/images/banner_01.jpg'" alt="">
        </div>
        <div class="list">
            <ul>
                <li v-for="item in listData" :key="item.id">
                    <div class="pic">
                        <img :src="myconf.api_host+item.img1_id" alt="">
                    </div>
                    <div class="info">
                        <div class="prices">
                            <!-- <p>原价：{{item.original_price}}元</p> -->
                            <p>原价：<s>{{item.original_price}}元</s></p>
                            <p>底价：？元</p>
                        </div>
                        <div class="btn" @click="startBargain(item.id)">发起砍价</div>
                    </div>
                </li>
            </ul>
        </div>
        <div class="rules">
            <fieldset>
                <legend>活动规则：</legend>
                <ul>
                    <li>1.选择砍价商品，点按钮“发起砍价”参加活动；</li>
                    <li>2.进入商品页面，点击右上角分享出去邀请朋友来为自己砍价；</li>
                    <li>3.砍价时间为期5天；</li>
                    <li>4.砍价时间结束后即可到店享受当前价格；</li>
                    <li>5.兑换地址：锦江区东大街紫东楼35号明宇金融广场25楼。</li>
                </ul>
            </fieldset>
        </div>
        <footer>
            <router-link :to="{name:'list'}">活动商品</router-link>
            <router-link :to="{name:'mybargain'}">我的砍价</router-link>
        </footer>
    </div>

</template>

<script>
import axios from "axios";
export default {
    name: "List",
    data(){
        return{
            listData:null
        }
    },
    created() {
        this.getList()
    },

    methods:{
        getList(){
            axios
            .get(this.myconf.api_host+"/bargian_api/goods")
            .then(response => {
                // window.console.log(response.data);
                this.listData = response.data
            })
            .catch(error => {
                window.console.log(error);
            });
        },
        // 发起砍价
        startBargain(id){
            axios({
                method:'POST',
                url:this.myconf.api_host+'/bargian_api/createbargain',
                headers:{
                    "Authorization":window.localStorage.getItem('user_token')
                },
                data:{"goods_id":id},
                
            })
            .then(response=>{
                // window.console.log(response.data)
                let sn = response.data.bargainSn
                if(sn){
                    /* this.$router.push({
                        path: 'detail', 
                        query: { no: sn }
                    }) */
                    // 解决iOS系统url不变的bug,不用路由跳转
                    window.location.href='/bargain/detail?no='+sn
                }else{
                    alert('发生错误')
                }
                
            })
            .catch(error=>{
                // window.console.log(error.response.data)
                let data = error.response.data
                if(data.msg == 'token已过期或无效token'){
                    
                    window.localStorage.removeItem('user_token')
                    // 跳转去后url存在原code
                    // this.$router.push({name:'login'})
                     this.$router.push({name:'login'})
                }else{
                    alert(error.response.data.msg)
                }
            }) 
        }
        
    }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped> 
.main{
    min-width: 320px;
    max-width: 640px;
    margin: 0 auto;
    overflow: hidden;
    padding-bottom: 0.8rem;
}
img{
    display: block;
}
.main .banner{
    width: 100%;
}
.main .banner img{
    width: 100%;
}


.main .list ul{
    display: flex;
    justify-content: space-around;
}
.main .list li{
    display: flex;
    width: 48%;
    margin-top: 20px;
    flex-direction: column;
    /* border-bottom: 1px dashed #666; */
}
.main .list li .pic img{
    width: 100%;
}
.main .list li .info{
    display: flex;
    flex-direction: column;
    justify-content: space-around;
    background: #5919be;
    padding: 10px 0;
    border-right: 3px solid #fff;
}
.main .list li .info .prices{
    border: 2px solid #fff;
    margin: 0 auto;
}
.main .list li .info .prices p{
    font-size: 0.27rem;
    font-weight: 600;
    color: #fff600;
    padding: 3px 2px;
}
.main .list li .info .prices p:last-child{
    background: #fff;
    color: #5919be;
}
.main .list li .info .btn{
    color: #ed1d79;
    background-color: #fcfcfc;
    font-size: 0.32rem;
    margin: 0 auto;
    text-align: center;
    padding: 5px 10px;
    border-radius: 5px;
    margin-top: 5px;
}
.rules{
    background: #f7f7f7;
    text-align: left;
    width: 96%;
    margin: 30px auto;
}
.rules legend{
    background: #5919be;
    padding: 5px 15px;
    margin: 0 20px;
    background-clip: padding-box;
    border: 10px solid #f7f7f7;
    color: #fff;
    font-size: 0.26rem;
}
.rules fieldset{
    border:2px solid #5919be;
    border-radius: 5px;
    padding: 13px;
}
.rules fieldset li{
    line-height: 0.4rem;
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

