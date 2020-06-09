<template>
    <div class="main">
        <div class="logo"><img src="../assets/images/logo.png"></div>
        <div v-if="show">
            <div class="customer">
                <span v-for="item in customer" :key="item.headimgurl"><img :src="item.headimgurl"></span>
            </div>
            <div class="lun-tit">第{{this.lun+1}}轮：{{this.luckyItem[this.lun].name}}</div>
            <p v-if="winPrize.length>0" style="font-size:32px;color:#fff;">恭喜以下中奖人员</p>
            <div class="winner" ref="winwrap">
                <span v-for="item in winPrize[lun]" :key="item.headimgurl">
                    <img :src="item.headimgurl">
                    <p>{{item.nickname}}</p>
                </span>
            </div>
        </div>
        <div v-else class="result">
            <p>恭喜本次活动所有中奖者</p>
            <div v-for="(item,index) in winPrize" :key="index">
                <span>第{{index+1}}轮：{{luckyItem[index].name}}<i v-for="(c,i) in item" :key="i"><img :src="c.headimgurl" alt=""></i></span>
            </div>
        </div>
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
            winPrize: [],
            timer:null,
            show:true
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
                case 38:
                    _this.show = false
                case 32: //空格
                    _this.beginDraw()
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
                // console.log(resopnse.data)
                this.customer = resopnse.data
            })
        },
        // 开始抽奖
        beginDraw(){
            let num = this.luckyItem[this.lun].num //抽取的个数

            let data = this.customer;
            let curLucky = this.customer[this.randomIndex(this.customer)]
            // console.log(curLucky)
            if(this.winPrize[this.lun]){
                return false
            }
            this.winPrize[this.lun] = []

            clearInterval(this.timer)
            this.timer = setInterval(()=> {
                let curLucky = this.customer[this.randomIndex(this.customer)]
                // console.log(curLucky)
                this.customer.splice(this.customer.findIndex(item=>item.id==curLucky.id),1)
                this.winPrize[this.lun].push(curLucky)
                if(this.winPrize[this.lun].length==num){
                    clearInterval(this.timer);
                }
                if(this.winPrize[this.lun].length==num){
                    this.updateLuckyList()
                }
                
            }, 1000)
            if(this.winPrize[this.lun].length==num){
                this.updateLuckyList()
            }
            // console.log(this.winPrize)

        

        },
        // 从数组随机抽取一个元素函数
        randomIndex(arr){
            // console.log(Math.random() * arr.length | 0)
            // return arr[Math.random() * arr.length | 0];
            return Math.random() * arr.length | 0
        },
        //更新数据库中奖者
        updateLuckyList(){
            let url = 'http://bcwx.com/avatardraw/updatelucky'
            axios({
                method: 'post',
                url: 'http://bcwx.com/avatardraw/updatelucky',
                data: {
                    lucky: this.winPrize[this.lun]
                }
            }).then(res=>{
                console.log(res)
            })
        }
        // 结束抽奖
    }
}
</script>
<style lang="scss" scoped>
.main{
    width: 100%;
    height: 100vh;
    background: url(~@/assets/images/bg.jpg) no-repeat 0 0;
    .logo{
        padding: 50px 0;
    }
    .customer{
        text-align: left;
        span{
            margin: 10px;
        }
        img{
            width: 75px;
            height: 75px;
            border-radius: 100%;
        }
        
    }
    .lun-tit{
        color: #fff;
        font-size: 50px;
        font-weight: bold;
        margin-top: 18px;
    }
    .winner{
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        text-align: center;
        font-size: 38px;
        color: #fff;
        span{
            // border: 1px solid #fff;
            margin: 5px 15px;
            p{
                border-bottom: 1px solid #ccc;
                color:#EEE8AA;
                // padding-bottom:3px;
            }
        }
        img{
            width: 90px;
            height: 90px;
            border-radius: 100%;
        }
    }
    
}
.result{
    color: #FFD900;
    font-size: 40px;
    font-weight: bold;
    div{width:98%;margin:45px auto;text-align: left;}
    img{
        width: 70px;
        height: 70px;
        border-radius: 8px;
        margin: 0 10px;
    }
}
@keyframes to-rt {
    0% {
        transform: translateY(40px);
    }
    100% {
        transform: translateY(var(--y));
    }
}

</style>