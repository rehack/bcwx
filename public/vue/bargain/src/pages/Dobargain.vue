<template>

    <div v-if="bargainData.goods" class="main">
        <div class="banner">
            <img  :src="myconf.api_host+bargainData.goods.img2_id" alt="">
        </div>
        <div class="tit-wrap">
            <span class="tit">{{bargainData.goods.goods_name}}</span>
        </div>
        <div class="des" v-html="bargainData.goods.goods_desc"></div>
        <div class="bargian-monry" v-if="kjmoney">我帮TA砍了：{{kjmoney}}元</div>
        <div class="price">原价:￥{{bargainData.goods.original_price}}</div>
        <!-- <div v-if="bargainRresult">当前价格：￥{{bargainRresult.deal_money}}</div> -->
        <footer>
            <div @click="meto" class="div">我也要参加</div>
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
            bargainData:{},
            bargainRresult:null,//砍价结果
            kjmoney:0
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

            let localData = window.localStorage.getItem(no)

            if(localData){
                this.kjmoney = localData
            }
            
            axios({
                method:'GET',
                url:this.myconf.api_host+'/bargian_api/bargaindetail',
                params:{no}
            })
            .then(resoponse=>{
                let bargainData = resoponse.data
                window.console.log(bargainData)
                this.bargainData = bargainData
            })
            .catch(error=>{
                alert(error.response.data.msg)
                this.$router.push({name:'list'})
                // window.console.log(JSON.stringify(error))
            })
        },

        // 帮TA砍一刀
        doBargain(){
            // alert(1)
            let no = this.no
            axios({
                method:'POST',
                url:this.myconf.api_host+'/bargian_api/dobargain',
                headers:{
                    "Authorization":window.localStorage.getItem('user_token')
                },
                data:{no}
            })
            .then(resoponse=>{
                let result = resoponse.data
                // window.console.log(result)
                // this.bargainRresult = result
                window.localStorage.setItem(no,result.kjmoney)
                this.kjmoney = result.kjmoney
                
                alert('您成功帮你的好友砍了'+result.kjmoney+'元!')
                // 可以继续分享
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
                    alert('发生错误')
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
.main{background: #eee;padding-bottom: 1rem;}
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
.bargian-monry{
    font-size: 0.25rem;
    color: rgb(192, 133, 4);
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
footer div,footer a{
    background: #d7b150;
    color: #fff;
    font-size: 0.26rem;
    border-radius: 5px;
    padding: 5px 10px;
}
</style>
