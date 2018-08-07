<template>

    <div>
        <!-- <div v-for="item of bargainData" v-bind:key="item.id">
            <img :src="this.lib.APIHOST+item.goods.images.img_path" alt="">
        </div> -->

        <img v-if="bargainData.goods" :src="this.lib.APIHOST+bargainData.goods.images.img_path" alt="">
        <p @click="doBargain">帮她砍一刀</p>

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

        }
    }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
</style>
