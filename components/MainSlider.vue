<template>
    <swiper :options="swiperOption" class="main-slider">
        <swiper-slide 
            class="swiper-lazy main-slider__slide" 
            v-for="(item,index) in this.page.acf.main_slider" 
            :key="index" 
            :data-background="item.image">
            <div class="main-slider__overlay"></div>
            <div class="main-slider__content" v-in-viewport.once>
                <p>{{item.text}}</p>
                <h2>{{item.title}}</h2> 
                <LinkButton :link="item.link" />
            </div>            
        </swiper-slide>
        <div class="main-slider__nav">     
                  
            <div class="main-slider__button-prev" slot="button-prev">
                <img src="~/assets/images/prev.png"/>
            </div>    
            <div class="swiper-pagination" slot="pagination"></div>         
            <div class="main-slider__button-next" slot="button-next">
                <img src="~/assets/images/next.png"/>
            </div>
        </div>
    </swiper>
</template>

<script>

import 'swiper/dist/css/swiper.css';
import '@/assets/css/components/MainSlider.scss';
import { swiper, swiperSlide } from 'vue-awesome-swiper';
import LinkButton from '@/components/LinkButton';

export default {
    
    components: {
        swiper,
        swiperSlide,
        LinkButton
    },
    props:{
        page:{
            type:Object
        }        
    },
    data() {

      return {
        swiperOption: {
          lazy:{
              loadPrevNext:true
          },
          spaceBetween: 30,
          autoplay: {
                delay: 3000,
            },
          effect: 'fade',
          
          pagination: {
            el: '.swiper-pagination',
            clickable: true
          },
          navigation: {
            nextEl: '.main-slider__button-next',
            prevEl: '.main-slider__button-prev'
          }
        }
      }
    }
}
</script>
