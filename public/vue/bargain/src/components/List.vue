<template>
  <div>列表</div>
    
</template>

<script>
import axios from 'axios'
export default {
  name: 'Home',
  created(){
      axios.get('http://127.0.0.1/test/index').then(response=>{
          window.console.log(response.data)
      }).catch(error=>{
          window.console.log(error)
      })
  }
  
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
