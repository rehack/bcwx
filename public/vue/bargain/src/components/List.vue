<template>
    <div class="a">列表

        <div class="b">ui</div>
    </div>

</template>

<script>
import axios from "axios";
export default {
    name: "Home",
    created() {
        this.getList()
    },

    methods:{
        getList(){
            axios
            .get("http://127.0.0.1/bargian_api/goods")
            .then(response => {
                window.console.log(response.data);
            })
            .catch(error => {
                window.console.log(error);
            });
        }
    }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="stylus" scope> 
.a
    color red
    .b
        color #000
        
</style>

