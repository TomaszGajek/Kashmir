<template>
    <section class="main-page">
        <div class="main-page-overlay"></div>
        <section class="intro">
            <div class="container">
                <MainSlider :page="page"/>
            </div>
            
        </section>
        <section class="about">
            <div class="container about__container">
                <img src="~/assets/images/flower.png" />
                <h4 class="text" v-in-viewport.once>{{this.page.acf.about_text}}</h4>
                <h2 v-in-viewport.once>{{this.page.acf.about_slogan}}</h2>
                <img src="~/assets/images/symbol.png"/>
                <p v-in-viewport.once>{{this.page.acf.about_description}}</p>
                <LinkButton :link="page.acf.about_link" />
            </div>
        </section>
        <section class="offer">
            <div class="offer__wrap" v-for="i in rowCount"> 
                <OfferThumb v-for="(item,index) in offer.slice((i-1)*6,i*6)" :key="index" :item="item" />
            </div>
        </section>
        <section class="review">
            <div class="container review__container">
                <img src="~/assets/images/flower.png" />
                <h2>{{this.page.acf.review_slogan}}</h2>
                <img src="~/assets/images/symbol.png"/>
            </div>
            <ReviewSlider :page="page"/>
        </section>
    </section>
</template>

<script>

import Config from '@/config.js';
import axios from 'axios';
import MainSlider from '@/components/MainSlider';
import LinkButton from '@/components/LinkButton';
import OfferThumb from '@/components/OfferThumb';
import ReviewSlider from '@/components/ReviewSlider';

export default {
    components:{
        MainSlider,
        LinkButton,
        OfferThumb,
        ReviewSlider
    }, 
    head () {
        return {
            title: this.page._yoast_wpseo_title,
            meta: [
                { hid: 'description', id: 'description', name: 'description', content: this.page._yoast_wpseo_metadesc }
            ]
        }
    },
    async asyncData({ params }) {
        console.log(params)
        let [page, offer] = await Promise.all([
            axios.get(`${Config.root}/wp-json/wp/v2/pages/?slug=strona-glowna`),
            axios.get(`${Config.root}/wp-json/wp/v2/oferta/?per_page=100`)
        ])
        return {
            page: page.data[0],
            offer: offer.data.filter((single)=>{
                return single.parent === 0
            })
            
        }
    },
    validate({ params, query, store }) {
        return true 
        return false // will stop Nuxt.js to render the route and display the error page
    },
    mounted(){
        
    },
    computed:{
        rowCount(){
            return Math.ceil(this.offer.length / 6);
        }
    }
 

}
</script>
<style lang="scss">
    @import '@/assets/css/pages/main-page.scss';
</style>

