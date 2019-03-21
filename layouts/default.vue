<template>
  <div class="overflow-x">
    <div id="google_translate_element"></div>
    <Header/>
    <main>
    <nuxt/>
    </main>
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
  
  mounted(){
     console.log('init google');
    new google.translate.TranslateElement({pageLanguage: 'pl', layout: google.translate.TranslateElement.InlineLayout.SIMPLE, autoDisplay: false}, 'google_translate_element');
  }
  
}
</script>

<style lang="scss">

</style>

