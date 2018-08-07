<template>
    <div class="main">
        <div class="banner">
            <img :src="this.lib.APIHOST+'/static/bargain/images/banner_01.jpg'" alt="">
        </div>
        <div class="list">
            <ul>
                <li v-for="item in listData" :key="item.id">
                    <div class="pic">
                        <img :src="lib.APIHOST+item.img1_id" alt="">
                    </div>
                    <div class="info">
                        <span>原价{{item.original_price}}元</span>
                        <div class="btn" @click="startBargain(item.id)">立即砍价</div>

                    </div>
                </li>
            </ul>
        </div>
        
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
        // 发起砍价
        startBargain(id){
            

            axios({
                method:'POST',
                url:this.lib.APIHOST+'/bargian_api/createbargain',
                headers:{
                    "Authorization":window.localStorage.getItem('user_token')
                },
                data:{"goods_id":id},
                
            })
            .then(response=>{
                window.console.log(response.data)
                let sn = response.data.bargainSn
                if(sn){
                    this.$router.push({
                        path: 'detail', 
                        query: { no: sn }
                    })
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
.main .list li .pic{
    /* width: 40%; */
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
.main .list li .info span{
    font-size: 0.27rem;
    color: #fff600;
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

