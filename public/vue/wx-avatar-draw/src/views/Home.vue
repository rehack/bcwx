<template>
  <div class="home">
    <div class="info">感谢您参与本次抽奖活动，随后将在大屏进行抽奖和公布抽奖结果，您也可以点击下面按钮查询本次抽奖结果！</div>
    <div class="btn">查询是否中奖</div>
    <div>
        <!-- 抱歉您未中奖 -->
    </div>
  </div>
</template>

<script>
// @ is an alias to /src


export default {
  name: 'Home',
  
}
</script>
<style lang="scss" scoped>
    .home{
        .info{
            margin-top: 50px;
            text-align: left;
        }
        .btn{
            margin: 0 auto;
            margin-top: 50px;
            padding: 5px 0;
            width: 50%;
            background-color: #04BE02;
            color: #fff;
            border-radius: 5px;
        }
    }
</style>
