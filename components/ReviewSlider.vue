<template>
    <div class="review-wrapper">
        <img class="rieview-wrapper-q--left" src="~/assets/images/qleft.png"/>
        <img class="rieview-wrapper-q--right" src="~/assets/images/qright.png"/>
        <swiper :options="swiperOption" class="review-slider">
            
            <swiper-slide 
                class="swiper-lazy review-slider__slide" 
                v-for="(item,index) in this.page.acf.review_slider" 
                :key="index" >
                <div class="review-slider__content">
                    <p>{{item.text}}</p>
                    <h4>{{item.author}}</h4>
                </div>            
            </swiper-slide>            
        </swiper>
        <div class="review-slider__nav">                       
            <div class="review-slider__button-prev" slot="button-prev">
                <img src="~/assets/images/prev.png"/>
            </div>    
            <div class="review-swiper-pagination swiper-pagination" slot="pagination"></div>         
            <div class="review-slider__button-next" slot="button-next">
                <img src="~/assets/images/next.png"/>
            </div>
        </div>
    </div>
</template>

<script>
import 'swiper/dist/css/swiper.css';
import '@/assets/css/components/ReviewSlider.scss';
import { swiper, swiperSlide } from 'vue-awesome-swiper';

export default {
    components: {
        swiper,
        swiperSlide
    },
    props:{
        page:{
            type:Object
        }
    },
    data(){
        return{
            swiperOption: {
                spaceBetween: 30,
                autoplay: {
                    delay: 4000,
                },
                loop:true,
                pagination: {
                    el: '.review-swiper-pagination',
                    clickable: true
                },
                navigation: {
                    nextEl: '.review-slider__button-next',
                    prevEl: '.review-slider__button-prev'
                }
            }
        }
    }
}
</script>
