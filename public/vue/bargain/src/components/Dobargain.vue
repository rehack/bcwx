<template>

    <div v-if="bargainData.goods" class="main">
        <div class="banner">
            <img  :src="lib.APIHOST+bargainData.goods.img2_id" alt="">
        </div>
        <div class="tit-wrap">
            <span class="tit">{{bargainData.goods.goods_name}}</span>
        </div>
        <div class="des" v-html="bargainData.goods.goods_desc"></div>
        <div class="price">原价:￥{{bargainData.goods.original_price}}</div>
        <footer>
            <div @click="meto" class="div">我也参加</div>
            <div @click="doBargain" class="sharebtn">帮TA砍一刀</div>
        </footer>

    </div>

</template>

<script>
import axios from 'axios'
export default {
    name: "Dobargain",
    data(){
        return{
            no:'',
            bargainData:{}
        }
    },
    created() {
        this.getBargain()
        // alert(window.location.host);
    },
    methods:{
        // 根据单号获取详情
        getBargain(){
            let no =this.$route.query.no
            this.no = no
            axios({
                method:'GET',
                url:this.lib.APIHOST+'/bargian_api/bargaindetail',
                params:{no}
            })
            .then(resoponse=>{
                let bargainData = resoponse.data
                window.console.log(bargainData)
                this.bargainData = bargainData
            })
            .catch(error=>{
                window.console.log(error)
            })
        },
        doBargain(){
            // alert(1)
            let no = this.no
            axios({
                method:'POST',
                url:this.lib.APIHOST+'/bargian_api/dobargain',
                headers:{
                    "Authorization":window.localStorage.getItem('user_token')
                },
                data:{no}
            })
            .then(resoponse=>{
                let bargainData = resoponse.data
                window.console.log(bargainData)
                this.bargainData = bargainData
            })
            .catch(error=>{
                // window.console.log()
                let msg = error.response.data.msg
                if(msg == 'token已过期或无效token'){
                    window.localStorage.removeItem('user_token')
                    this.$router.push({name:'login',query:{flag:'share',no:this.no}})
                }else if(msg != 'token已过期或无效token'){
                    alert(msg)
                }else{
                    alert('发送错误')
                }
                // alert(error.resoponse)
            })

        },

        // 我也参加
        meto(){
            this.$router.push({name:'list'})
        }
    }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.main{background: #eee;padding-bottom: 0.8rem;}
.banner img{
    width: 100%;
}
.tit-wrap{

    display: inline-block;
    color: #313131;
    border:15px solid rgba(253, 231, 40, 0.3);
    margin: 15px 0;
}
.tit-wrap .tit{
    font-size: 0.3rem;
    font-weight: bold;
    background: #fde727;
    padding: 5px 15px;
}
.des{
    width: 80%;
    margin: 0 auto;
    text-align: left;
    color: #515151;
    font-size: 0.23rem;
    line-height: 0.5rem;
}
.price{
    font-size: 0.32rem;
    color: red;
    margin: 8px 0;
}
footer{
    width: 100%;
    margin: 0 auto;
    display: flex;
    position: fixed;
    bottom: 0;
    font-size: 0.3rem;
    background: #ccc;
    align-items: center;
    justify-content: space-around;
    height: 0.8rem;
}
footer div{
    background: #d7b150;
    color: #fff;
    font-size: 0.3rem;
    border-radius: 5px;
    padding: 5px 10px;

}
</style>
