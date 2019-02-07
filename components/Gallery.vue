<template>
  <div class="container gallery-container">
    <gallery :images="listOfImages" :index="index" @close="index = null"></gallery>
    <div class="gallery-wrapper">
    <div class="image-line" v-for="(image, imageIndex) in page" :key="imageIndex">
        <span></span>
        <span></span>
        <span></span>
        <span></span>    
        <div
            class="image"
            @click="index = imageIndex"
            :style="{ backgroundImage: 'url(' + image.sizes.large + ')', width: '400px', height: '400px' }"
            ></div>
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

<style scoped>

  .html,body{
    overflow:hidden;
}  


.gallery-container{
    display:-webkit-box;
    display:-ms-flexbox;
    display:flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
        -ms-flex-direction: column;
            flex-direction: column;
    overflow:hidden;
}  
.gallery-wrapper{
    display:-webkit-box;
    display:-ms-flexbox;
    display:flex;
    -ms-flex-wrap:wrap;
        flex-wrap:wrap;
    width:1240px;
    margin:0 auto;
    overflow:auto;
}  
.image {
  background-size: cover;
  background-repeat: no-repeat;
  background-position: center center;
  border: 1px solid #ebebeb;
  margin: 6px;
  -webkit-transition:all 0.3s ease-in-out;
  transition:all 0.3s ease-in-out;
}

.body {
    overflow: scroll ;
}
</style> 