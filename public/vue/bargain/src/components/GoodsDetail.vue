<template>
    <div>
        <!-- <img :src="lib.APIHOST+itemData.images.img_path" alt=""> -->
    </div>

</template>

<script>
// import axios from 'axios'
export default {
    name: 'GoodsDetail',
    data(){
        return{
            itemData:null
        }
    },
    created(){
    //   console.log(this.$route)
        this.getItem()
    },
    methods:{

        getItem(){
            let item = this.$route.query;
            this.itemData = item
            window.console.log(item)
        }
    }


  
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
</style>
