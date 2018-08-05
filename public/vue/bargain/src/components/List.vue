<template>
    <div class="main">
        <div class="banner"></div>
        <div class="headimg">
            <img src="{$user[0]['headimgurl']}" alt="">
            
        </div>
        <div class="list">
            <ul>
                <li v-for="item in listData" :key="item.id">
                    <div class="pic">
                        <img :src="lib.APIHOST+item.images.img_path" alt="">
                    </div>
                    <div class="info">
                        <div class="tit">{{item.goods_name}}</div>
                        <!-- <div class="btn" @click="toDetail" :data-id="item.goods_id">点击砍价</div>
                         -->
                        <div class="btn">
                            <router-link :to="{ name: 'detail', query: item}">立即砍价</router-link>
                        </div>
                        <div class="price">
                            <s>原价{{item.original_price}}元</s>
                            <span>现价{{item.activity_money}}元</span>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
        <footer>
            <ul>
                <li>砍价商品</li>
                <li>我的砍价</li>
            </ul>
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
            .get(this.lib.APIHOST+"/bargian_api/goods")
            .then(response => {
                window.console.log(response.data);
                this.listData = response.data
            })
            .catch(error => {
                window.console.log(error);
            });
        },

        
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
}
.main .banner{
    width: 100%;
    height: 50px;
    background: #1dddd3;
}
.main .headimg{
    display: flex;
    align-items: center
}
.main .headimg img{
    border-radius: 100%;
    width: 1rem;
    height: 1rem;
    border: 1px solid #ccc;
    margin-right: 10px;
}
.main .list{
    margin-top: 20px;
    border-top: 1px solid #ccc;
}
.main .list li{
    display: flex;
    margin-top: 20px;
    border-bottom: 1px dashed #666;
}
.main .list li .pic{
    width: 40%;
}
.main .list li .pic img{
    width: 100%;
}
.main .list li .info{
    width: 50%;
    display: flex;
    flex-direction: column;
    justify-content: space-around;
}
.main .list li .info .tit{
    font-size: 0.27rem;
}
.main .list li .info .btn a{
    color: #fff;
    background-color: red;
    width: 40%;
    margin: 0 auto;
    text-align: center;
    padding: 5px 10px;
    font-size: 0.22rem;
    border-radius: 5px;
}
.main .list li .info .price{
    display: flex;
    justify-content: space-around;
}
.main .list li .info .price s{
    color: #666;
    margin-right: 5px;
}
.main .list li .info .price span{
    color: red;
}

footer{
    width: 100%;
    margin: 0 auto;
    position: fixed;
    bottom: 0;
    background-color: #eee;
    height: 0.6rem;
}
footer ul{
    height: 100%;
    display: flex;
    border-top: 1px solid #666;
    align-items: center;
    align-content: center;
}
footer ul li{
    flex:1;
    text-align: center;
}
        
</style>

