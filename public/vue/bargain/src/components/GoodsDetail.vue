<template>
    <div>
        <!-- <img :src="lib.APIHOST+bargainData.goods.images.img_path" alt="">
        <h2>{{bargainData.goods.goods_name}}￥56.3</h2> -->
        <div>
            <span>已坎3.2</span>
            <span>还差52.6元</span>
        </div>
        <div>还剩1天23：40：02：01过期 快来砍价吧</div>
        <div>分享好友砍一刀</div>
    </div>

</template>

<script>
import axios from "axios";
import wx from 'weixin-js-sdk'
/* 微信分享
https://www.imooc.com/article/44083
https://segmentfault.com/a/1190000014455713
https://www.cnblogs.com/juewuzhe/p/7234195.html
配置信息需要后端返回

iso分享问题
https://github.com/vuejs/vue-router/issues/481
*/
export default {
    name: "GoodsDetail",
    data() {
        return {
            bargainData: {},
            images: {},
            shareData: []
        };
    },
    created() {
        //   console.log(this.$route)
        alert(location.href.split('#')[0])
        this.getDetail();
        this.getWxShareParams();
    },
    methods: {
        // 通过bargain单号获取详情
        getDetail() {
            let no = this.$route.query.no;
            axios({
                method: "GET",
                url: this.lib.APIHOST + "/bargian_api/bargaindetail",
                params: { no }
            })
                .then(response => {
                    window.console.log(response.data);
                    this.bargainData = response.data;
                })
                .catch(error => {
                    alert(error.response.data.msg);
                });
        },

        getWxShareParams() {
            axios({
                method: "get",
                url: this.lib.APIHOST + "/bargian_api/wxshare"
            }).then(response => {
                window.console.log(response.data);
                let shareData = response.data;
                this.shareData = shareData;
                this.wxInit(shareData);
            });
        },

        //微信分享使用方法
        wxInit(sd) {
            // alert(window.location.href)
            let links = window.location.href; //分享出去的链接
            let title = "向您推荐：的活动微站"; //分享的标题
            let desc = "关注有新活动通知您"; //分享的详情介绍
            let imgUrl = '';
            wx.config({
                debug: false,
                appId: sd.appId,
                timestamp: sd.timestamp,
                nonceStr: sd.nonceStr,
                signature: sd.signature,
                jsApiList: [
                    "onMenuShareTimeline",
                    "onMenuShareAppMessage",
                    "onMenuShareQQ",
                    "onMenuShareWeibo",
                    "onMenuShareQZone"
                ]
            });
            wx.ready(function() {
                wx.onMenuShareTimeline({
                    title: title, // 分享标题
                    desc: desc, // 分享描述
                    link: links, // 分享链接
                    imgUrl: imgUrl, // 分享图标
                    success: function() {
                        // alert("分享到朋友圈成功")
                        Toast({
                            message: "成功分享到朋友圈"
                        });
                    },
                    cancel: function() {
                        // alert("分享失败,您取消了分享!")
                        Toast({
                            message: "分享失败,您取消了分享!"
                        });
                    }
                });
                //微信分享菜单测试
                wx.onMenuShareAppMessage({
                    title: title, // 分享标题
                    desc: desc, // 分享描述
                    link: links, // 分享链接
                    imgUrl: imgUrl, // 分享图标
                    success: function() {
                        // alert("成功分享给朋友")
                        Toast({
                            message: "成功分享给朋友"
                        });
                    },
                    cancel: function() {
                        // alert("分享失败,您取消了分享!")
                        Toast({
                            message: "分享失败,您取消了分享!"
                        });
                    }
                });

                wx.onMenuShareQQ({
                    title: title, // 分享标题
                    desc: desc, // 分享描述
                    link: links, // 分享链接
                    imgUrl: imgUrl, // 分享图标
                    success: function() {
                        // alert("成功分享给QQ")
                        Toast({
                            message: "成功分享到QQ"
                        });
                    },
                    cancel: function() {
                        // alert("分享失败,您取消了分享!")
                        Toast({
                            message: "分享失败,您取消了分享!"
                        });
                    }
                });
                wx.onMenuShareWeibo({
                    title: title, // 分享标题
                    desc: desc, // 分享描述
                    link: links, // 分享链接
                    imgUrl: imgUrl, // 分享图标
                    success: function() {
                        // alert("成功分享给朋友")
                        Toast({
                            message: "成功分享到腾讯微博"
                        });
                    },
                    cancel: function() {
                        // alert("分享失败,您取消了分享!")
                        Toast({
                            message: "分享失败,您取消了分享!"
                        });
                    }
                });
                wx.onMenuShareQZone({
                    title: title, // 分享标题
                    desc: desc, // 分享描述
                    link: links, // 分享链接
                    imgUrl: imgUrl, // 分享图标
                    success: function() {
                        // alert("成功分享给朋友")
                        Toast({
                            message: "成功分享到QQ空间"
                        });
                    },
                    cancel: function() {
                        // alert("分享失败,您取消了分享!")
                        Toast({
                            message: "分享失败,您取消了分享!"
                        });
                    }
                });
            });
            wx.error(function(res) {
                // alert("error")
                // config信息验证失败会执行error函数，如签名过期导致验证失败，具体错误信息可以打开config的debug模式查看，也可以在返回的res参数中查看，对于SPA可以在这里更新签名。
            });
        }
    }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
</style>
