<template>
    <div class="main">
        <div class="logo"><img src="../assets/images/logo.png"></div>
        <div v-if="show">
            <div class="customer">
                <span v-for="item in customer" :key="item.id"><img :src="item.headimgurl"></span>
            </div>
            <div v-if="lun>=0 && luckyItem.length>0" class="lun-tit">第{{luckyItem[lun].lun}}轮：{{luckyItem[lun].name}}</div>
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
                <span>第{{index+1}}轮：{{luckyItem[index].name}}<i v-for="(c,i) in item" :key="i"><img :src="c.headimgurl"></i></span>
            </div>
        </div>
        <audio ref="runMusic" id="play-music" @play="playMusic" @pause="pauseMusic" src="../assets/music/run.mp3" loop></audio>
        <!-- <audio id="stop-music" src="../assets/music/stop.mp3"></audio> -->
    </div>
</template>

<script>
import axios from 'axios'
export default {
    name: 'Draw',
    data() {
        return {
            customer: [],
            luckyItem:[],
            lun: 0,//轮次序号
            // 中奖结果
            winPrize: [],
            timer:null,
            show:true,
            audio:null
        }
    },
    mounted(){
        // console.log(process.env.BASE_URL)
        this.getLuckyItem()
        this.getCustomer()
    },
    created() {
        let _this = this;
        document.onkeydown = function(e) {
            let oEvent = e || window.event
            let key = oEvent.keyCode
            switch (key) {
                case 39: //右箭头
                    if(_this.lun+1 == _this.luckyItem.length){
                        _this.lun = 0
                    }else{
                        _this.lun += 1
                    }
                    _this.getCustomer()
                    break;
                case 37: //左箭头
                    if(_this.lun == 0){
                        _this.lun = _this.luckyItem.length -1
                    }else{
                        _this.lun -= 1
                    }
                    _this.getCustomer()
                    break;
                case 38: //上箭头
                   _this.showResult() //显示全部抽奖结果
                case 32: //空格
                    _this.beginDraw()
                    break;
                case 90 | oEvent.ctrlKey: //ctrl+z初始化数据
                    _this.initData()
                    break;
                default:
                    break;
            }
        };
    },
    methods: {
        // 获取抽奖项目
        getLuckyItem(){
            axios({
                url:  process.env.VUE_APP_SERVER_URL+'/avatardraw/luckyitem',
                method:'get',
            }).then(res=>{
                this.luckyItem = res.data
            })
        },
        // 获取本轮参与抽奖的人员
        getCustomer(){
            this.customer = []
            let url =  process.env.VUE_APP_SERVER_URL+'/avatardraw/customer'
            // let lun = this.lun+1
            axios({
                url:url,
                method:'get',
                params:{
                    lun: this.lun+1
                }
            }).then(resopnse=>{
                this.customer = resopnse.data
                // 递归轮询 10秒
                setTimeout(() => {
                    this.getCustomer()
                }, 25000);
            })
            // axios.get(url)
            // .then(resopnse=>{
            //     // console.log(resopnse.data)
            //     this.customer = resopnse.data
            //     // 递归轮询 10秒
            //     setTimeout(() => {
            //         this.getCustomer()
            //     }, 15000);
            // })
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
            this.playMusic()
            this.timer = setInterval(()=> {
                let curLucky = this.customer[this.randomIndex(this.customer)]
                // console.log(curLucky)
                this.customer.splice(this.customer.findIndex(item=>item.id==curLucky.id),1)
                this.winPrize[this.lun].push(curLucky)
                if(this.winPrize[this.lun].length==num){
                    clearInterval(this.timer);
                }
                if(this.winPrize[this.lun].length==num){//本轮抽完后提交到数据库和本地存储
                    let commitData = {
                        lucky_item_name : this.luckyItem[this.lun].name,//中奖项目名称
                        win_prize : this.winPrize[this.lun]
                    }
                    this.updateLuckyList(commitData)
                    window.localStorage.setItem(this.lun,JSON.stringify(this.winPrize[this.lun]))
                    this.pauseMusic()
                }
                
            }, 1000)
            // console.log(this.winPrize)

        

        },
        // 从数组随机抽取一个元素函数
        randomIndex(arr){
            return Math.random() * arr.length | 0
        },
        //更新数据库中奖者
        updateLuckyList(data){
            let url =  process.env.VUE_APP_SERVER_URL+'/avatardraw/updatelucky'
            axios({
                method: 'post',
                url:  process.env.VUE_APP_SERVER_URL+'/avatardraw/updatelucky',
                data: {
                    lucky: data
                }
            }).then(res=>{
                console.log(res)
            })
        },
        // 显示全部抽奖结果
        showResult(){
            this.show = false
            if(this.winPrize.length == 0) {
                for(let i=0;i<this.luckyItem.length;i++){
                    this.winPrize[i] = JSON.parse(window.localStorage.getItem(i))
                }
            }
        },
        // 初始化数据,此操作有风险，需谨慎操作，抽奖开始后不能进行此操作
        initData(){
            window.localStorage.clear()
            axios({
                method:'post',
                url: process.env.VUE_APP_SERVER_URL+'/avatardraw/init'
            })
        },
        playMusic(){
            this.$refs['runMusic'].play()
            
        },
        pauseMusic(){
            this.$refs['runMusic'].pause()
        }
    }
}
</script>
<style lang="scss" scoped>
.main{
    width: 100%;
    height: 100vh;
    background: url(~@/assets/images/bg.jpg) no-repeat 0 0;
    .logo{
        padding: 30px 0;
    }
    .customer{
        text-align: left;
        span{
            margin: 10px;
        }
        img{
            width: 60px;
            height: 60px;
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
        font-size: 34px;
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
            width: 80px;
            height: 80px;
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