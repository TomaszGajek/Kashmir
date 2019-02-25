<template>
  <div class="gallery-container">
    <gallery :images="listOfImages" :index="index" @close="index = null"></gallery>
    <div class="gallery-wrapper">
    <div class="image-line" v-for="(image, imageIndex) in page" :key="imageIndex">
        <span></span>
        <span></span>
        <span></span>
        <span></span>    
        <div
            class="image"
            :style="{ backgroundImage: 'url(' + image.sizes.large + ')' }"
            >
        </div>
        <div class="image-overlay" @click="index = imageIndex">
            <div class="link-button">
              <p class="link-button__text">Powiększ</p>
            </div>
        </div>
    </div>    
    </div>
  </div>
</template>

<script>
import VueGallery from 'vue-gallery';

export default {
    props:{
        page:{
            type:Array
        }
    },
    data: function () {
      return {
        index: null
      };
    },
    computed:{
        listOfImages(){
            const imagesUrl = [];
            this.page.forEach((image)=>{
                imagesUrl.push(image.sizes.large);
            })
            return imagesUrl;
            
        }

    },
    components: {
      'gallery': VueGallery
    }
}
</script>

<style lang="scss">
  @import '@/assets/css/components/Gallery.scss';
</style> 