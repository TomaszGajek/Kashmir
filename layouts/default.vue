<template>
  <div>
    <Header/>
    <nuxt/>
    <Footer />
  </div>
</template>

<script>
import Header from '@/components/Header.vue';
import Footer from '@/components/Footer.vue';

export default {
  components:{
    Header,
    Footer
  },
  // async asyncData({ query, error }) {
  //       let [footer] = await Promise.all([
  //           axios.get(`${Config.root}/wp-json/acf/v3/options/options`)
  //       ])
  //       return {
  //           footer: page.data
  //       }
  //   },
  //   data(){
  //       return {
  //           footer:{}
  //       }
  //   },
  //   mounted(){
  //       console.log(this.footer);        
  //   },
}
</script>

<style lang="scss">

</style>

