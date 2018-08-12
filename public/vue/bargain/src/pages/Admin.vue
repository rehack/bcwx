<template>
    <div>
        <ul>
            <li v-for="item of ordersData" :key="item.id" class="item"  v-if="item.helpers.length>0">
                <span>{{item.id}}</span>
                <img :src="item.users_info.headimgurl" alt="">
                <span>{{item.users_info.nickname}}</span>
                <span>({{item.goods.original_price}}-{{item.helpers_sum}}={{item.goods.original_price-item.helpers_sum}})</span>
                <span>{{item.helpers.length}}</span>
            </li>
        </ul>

    </div>

</template>

<script>
import axios from "axios";
export default {
    data() {
        return {
            ordersData:[]
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
        }
    }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="stylus" scoped>
    .item
        display flex
        border-bottom 1px dashed green
        align-items center
        margin-bottom 10px
        margin-top 10px
        img 
            width 40px
            height 40px
            border-radius 100%
            margin 0 5px

</style>


