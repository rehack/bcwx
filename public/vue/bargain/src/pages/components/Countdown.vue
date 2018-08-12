<template>
    <span class='orange'>倒计时:{{time}}</span>
</template>
<script>
export default {
    data() {
        return {
            time: "",
        };
    },
    props: ["endtime"],
    
    mounted() {
         this._interval = setInterval(() => {
            this.timeDown();
        }, 1000)
    },
    destroyed () {
        clearInterval(this._interval)
    },
    methods: {
        timeDown () {
            let time = new Date(this.endtime) - Date.parse(new Date());

            let day = parseInt(time / 1000 / 60 / 60 / 24);
            let hr = parseInt(time / 1000 / 60 / 60 % 24);
            let min = parseInt(time / 1000 / 60 % 60);
            let sec = parseInt(time / 1000 % 60);

            hr = hr > 9 ? hr : '0' + hr;
            min = min > 9 ? min : '0' + min;
            sec = sec > 9 ? sec : '0' + sec;

            this.time = day+"天"+hr+"小时"+min+"分"+sec+"秒";
            // this.time = time
            // this.time = `${day}天${hr}小时${min}分${sec}秒`
        }
    },
};
</script>
<style scoped>
.orange {
    color: orange;
}
</style>