<template>
    <span class='orange'>倒计时:{{time}}</span>
</template>
<script>
export default {
    data() {
        return {
            time: "",
            flag:false
        };
    },
    props: ["endtime"],

    mounted() {
        this._interval = setInterval(() => {
            if (this.flag) {
                clearInterval(this._interval);
            }
            this.timeDown();
        }, 1000);
    },
    destroyed() {
        clearInterval(this._interval);
    },
    methods: {
        timeDown() {
            let time = new Date(this.endtime) - Date.parse(new Date());
            // let time = new Date("2018/8/13 23:47:02") - Date.parse(new Date());
            let leftTime = parseInt(time / 1000); //剩余秒数

            let day = parseInt(time / 1000 / 60 / 60 / 24);
            let hr = parseInt((time / 1000 / 60 / 60) % 24);
            let min = parseInt((time / 1000 / 60) % 60);
            let sec = parseInt((time / 1000) % 60);

            hr = hr > 9 ? hr : "0" + hr;
            min = min > 9 ? min : "0" + min;
            sec = sec > 9 ? sec : "0" + sec;

            this.time = day + "天" + hr + "小时" + min + "分" + sec + "秒";
            if (leftTime <= 0) {
                this.$emit("timeEnd")
                this.flag = true
                this.time = 0
            }
            // this.time = time
            // this.time = `${day}天${hr}小时${min}分${sec}秒`
        }
    }
};
</script>
<style scoped>
.orange {
    color: orange;
}
</style>