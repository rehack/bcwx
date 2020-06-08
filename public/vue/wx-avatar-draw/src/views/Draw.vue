<template>
    <div>
        <div class="customer">
            <span v-for="item in customer" :key="item.headimgurl"><img :src="item.headimgurl" alt=""></span>
        </div>
        <div class="lun-tit">第{{this.lun+1}}轮：{{this.luckyItem[this.lun].name}}</div>
    </div>
</template>

<script>
import axios from 'axios'
export default {
    name: 'Draw',
    data() {
        return {
            customer: [],
            luckyItem:[
                {
                    lun: 1,
                    name:'美白880元',
                    num: 10
                },
                {
                    lun: 2,
                    name:'美白980元',
                    num: 6
                },
                {
                    lun: 3,
                    name:'美白1080元',
                    num: 3
                }
            ],
            lun: 0,//轮次序号
            // 中奖结果
            winPrize: [

            ]
        }
    },
    mounted(){
        this.getCustomer()
    },
    created() {
        let _this = this;
        document.onkeydown = function(e) {
            let key = window.event.keyCode;
            switch (key) {
                case 39: //右箭头
                    if(_this.lun+1 == _this.luckyItem.length){
                        _this.lun = 0
                    }else{
                        _this.lun += 1
                    }
                    break;
                case 37: //左箭头
                    if(_this.lun == 0){
                        _this.lun = _this.luckyItem.length -1
                    }else{
                        _this.lun -= 1
                    }
                    break;
                case 32: //空格
                    alert('空格')
                    break;
                default:
                    break;
            }
        };
    },
    methods: {
        getCustomer(){
            let url = 'http://bcwx.com/avatardraw/customer'
           
            axios.get(url)
                .then(resopnse=>{
                    console.log(resopnse.data)
                    this.customer = resopnse.data
                })
        },
        // 开始抽奖
        // 结束抽奖
    }
}
</script>
<style lang="scss" scoped>
.customer{
    img{
        width: 50px;
        height: 50px;
    }
}
</style>