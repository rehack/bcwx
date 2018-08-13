<template>
    <div>
        <ul>
            <li v-for="item of ordersData" :key="item.id" class="item"  v-if="item.helpers.length>0">
                <div class="info">
                    <span>{{item.id}}</span>
                    <img :src="item.users_info.headimgurl" alt="">
                    <span>{{item.users_info.nickname}}</span>
                </div>
                <span>砍价金额：{{item.goods.original_price}}-{{item.helpers_sum}}={{item.goods.original_price-item.helpers_sum}}</span>
                <span>砍价次数：{{item.helpers.length}}</span>
                <span class="detail" @click="showRecord(item.bargain_sn)">详细</span>
                <div class="record" v-show="flag && isShowRecord==item.bargain_sn">
                    <ul>
                        <li v-for="user of item.helpers" :key="user.id">
                            <img :src="user.user.headimgurl" alt="">
                            <p>{{user.user.nickname}}</p>
                            <span>{{user.bargain_money}}元</span>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>

    </div>

</template>

<script>
import axios from "axios";
export default {
    data() {
        return {
            ordersData:[],
            isShowRecord:'',
            flag:false
        };
    },
    created() {
        //   console.log(this.$route)
        this.getData();
    },
    methods: {
        getData() {
            axios({
                method: "GET",
                url: this.myconf.api_host + "/bargian_api/admin",
                headers: {
                    Authorization: window.localStorage.getItem("user_token")
                }
            })
            .then(response=>{
                this.ordersData = response.data
                window.console.log(response.data)
            })
            .catch(error=>{
                window.console.log(error.response.data)
            })
        },

        // 显示隐藏详细砍价记录
        showRecord(no){
            // console.log(e)
            this.isShowRecord = no
            this.flag=!this.flag
            // alert(this.isShowRecord)
        }
    }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="stylus" scoped>
    .item
        display flex
        flex-direction column
        border-bottom 1px dashed green
        padding-bottom 7px
        margin-top 15px
        text-align left
        margin-left 10px
        .info
            display flex
            align-items center
            color orange
        img 
            width 40px
            height 40px
            border-radius 100%
            margin 0 5px
        .detail
            width 60px
            background #96d5f3 
            border-radius 5px
            color #fff
            text-align center
        
        .record 
            li
                display: flex;
                border: 1px dotted #eee;
                align-items: center;
                margin: 0;
                img
                    width: 20px;
                    height: 20px;
                    border-radius: 100%;
                p
                    margin: 0 12px;
                    width: 380%;
                    text-align: left;




</style>


