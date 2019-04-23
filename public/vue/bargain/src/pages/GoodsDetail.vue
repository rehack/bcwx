<template>
    <div v-if="bargainData.goods" class="main">
        <div class="banner">
            <img  :src="myconf.api_host+bargainData.goods.img2_id" alt="">
        </div>
        <div class="tit-wrap">
            <span class="tit">{{bargainData.goods.goods_name}}</span>
        </div>
        <div @click="share" class="sharebtn">召唤好友帮忙砍价</div>
        <div class="des" v-html="bargainData.goods.goods_desc"></div>
        <div @click="share" class="sharebtn">召唤好友帮忙砍价</div>
        <div class="price">原价:￥{{bargainData.goods.original_price}}</div>

        <!-- <div>
            <span>已坎3.2</span>
            <span>还差52.6元</span>
        </div>
        <div>还剩1天23：40：02：01过期 快来砍价吧</div> -->
        
            
        
        <footer>
            <router-link :to="{name:'list'}">活动商品</router-link>
            <router-link :to="{name:'mybargain'}">我的砍价</router-link>
        </footer>

        <div id="mcover" v-show="guideShow" @click="hideCover">
            <img :src="myconf.api_host+'/static/bargain/images/guide.png?v=1'">
        </div>
    </div>

</template>

<script>
import axios from "axios";
import wx from 'weixin-js-sdk'

export default {
    name: "GoodsDetail",
    data() {
        return {
            bargainData: {},
            images: {},
            configData: [],
            guideShow:false
        };
    },
    created() {
        //   console.log(this.$route)
        if(window.localStorage.getItem('iosurl')){

            window.localStorage.removeItem('iosurl')
            window.location=window.location
        }
        // this.getWxShareParams();
    },
    mounted(){
        this.getDetail();//不能放created，否则签名可能会失败
    },
    methods: {
        // 通过bargain单号获取详情
        getDetail() {
            let no = this.$route.query.no;
            axios({
                method: "GET",
                url: this.myconf.api_host + "/bargian_api/bargaindetail",
                params: { no }
            })
            .then(response => {
                // window.console.log(response.data);
                this.bargainData = response.data;
            })
            .then(()=>{
                this.getWxShareParams();
            })
            .catch(error => {
                // alert(error.response.data.msg);
                alert('用户身份校验失败，请刷新后再分享'+error);
            });
        },

        getWxShareParams() {
            // 判断iOS
            // var u = navigator.userAgent;
            // var isAndroid = u.indexOf('Android') > -1 || u.indexOf('Adr') > -1; //android终端
            // var isios = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/); //ios终端
            // alert('是否是Android：'+isAndroid);
            // alert('是否是iOS：'+isiOS);
            // var currentUrl =''
            // return false;
            /* if(isios){
                // window.location.href=window.location.href
                let iosurl = window.localStorage.getItem('iosurl');
                currentUrl = encodeURIComponent(iosurl)
                alert('local:'+iosurl)
            }else{
                currentUrl = encodeURIComponent(window.location.href.split('#')[0])
            } */
            let currentUrl = encodeURIComponent(window.location.href.split('#')[0])

            // alert('当前url:'+window.location.href.split('#')[0])
            axios({
                method: "get",
                url: this.myconf.api_host + "/bargian_api/wxshare",
                params:{currentUrl}
            }).then(response => {
                // window.console.log(response.data);
                // alert(JSON.stringify(response.data))
                // alert(response.data)
                // return false
                let configData = response.data;
                this.configData = configData;
                this.wxInit(configData);
                // alert('houtaiUrl'+configData.url)
            });
        },

        //微信分享使用方法
        wxInit(conf) {
            /* alert(window.location.href) 
            return false */
            let no = this.$route.query.no
            // return false
            // let links = window.location.href+'&flag=share'; //分享出去的链接
            let links = window.location.protocol+"//"+window.location.host+'/bargain/login?flag=share&no='+no; //分享出去的链接
            let title = this.bargainData.goods.goods_name; //分享的标题
            // let desc = this.bargainData.goods.goods_desc_m; //分享的简短描述
            let desc = '砍价活动进行中,快来帮帮TA砍一刀吧！'; //分享的简短描述
            let imgUrl = this.myconf.api_host+this.bargainData.goods.img1_id;
            wx.config({
                debug: false,
                appId: conf.appId,
                timestamp: conf.timestamp,
                nonceStr: conf.nonceStr,
                signature: conf.signature,
                jsApiList: [
                    "onMenuShareTimeline",
                    "onMenuShareAppMessage"
                ]
            });
            wx.ready(function() {
                wx.onMenuShareTimeline({
                    title: title, // 分享标题
                    desc: desc, // 分享描述
                    link: links, // 分享链接
                    imgUrl: imgUrl, // 分享图标
                    success: function() {
                        alert("分享到朋友圈成功")
                        
                        /* Toast({
                            message: "成功分享到朋友圈"
                        }); */
                    },
                    cancel: function() {
                        alert("分享失败,您取消了分享!")
                        /* Toast({
                            message: "分享失败,您取消了分享!"
                        }); */
                    }
                });
                //微信分享菜单测试
                wx.onMenuShareAppMessage({
                    title: title, // 分享标题
                    desc: desc, // 分享描述
                    link: links, // 分享链接
                    imgUrl: imgUrl, // 分享图标
                    success: function() {
                        alert("成功分享给朋友")
                        /* Toast({
                            message: "成功分享给朋友"
                        }); */
                    },
                    cancel: function() {
                        alert("分享失败,您取消了分享!")
                        /* Toast({
                            message: "分享失败,您取消了分享!"
                        }); */
                    }
                });
            });
            wx.error(function(res) {
                // window.console.log(res)
                alert(res.errMsg+'用户身份校验失败，请刷新后再分享')
                // config信息验证失败会执行error函数，如签名过期导致验证失败，具体错误信息可以打开config的debug模式查看，也可以在返回的res参数中查看，对于SPA可以在这里更新签名。
            });
        },

       
        share(){
            // 显示指引弹出层
            this.guideShow=true
        },
        hideCover(){
            this.guideShow=false
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
    color: #666;
    margin: 8px 0;
    font-size: 0.26rem;
}
.sharebtn{
    color: #fff;
    font-size: .32rem;
    background: red;
    width: 50%;
    margin: 14px auto;
    padding: 5px 10px;
    border-radius: 5px;
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
footer a{
    background: #d7b150;
    color: #fff;
    font-size: 0.26rem;
    border-radius: 5px;
    padding: 5px 10px;
}

/*分享指引弹出层*/
#mcover {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.6);
    z-index: 20000;
}

#mcover img {
    position: fixed;
    right: 0;
    top: 0;
    width: 100%;
    z-index: 999;
}
</style>
