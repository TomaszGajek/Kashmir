<template>
    <main>
    <section class="intro">
        <div class="container">
            <MainSlider :page="page"/>
        </div>
    </section>
    <section class="about">
        <div class="container about__container">
            <img src="~/assets/images/flower.png" />
            <h4 class="text">{{this.page.acf.about_text}}</h4>
            <h2>{{this.page.acf.about_slogan}}</h2>
            <img src="~/assets/images/symbol.png"/>
            <p>{{this.page.acf.about_description}}</p>
            <LinkButton :link="page.acf.about_link"/>
        </div>
    </section>
    <section class="offer">
        <div class="container">
            <OfferThumb v-for="(item,index) in offer" :key="index" :item="item"/>
        </div>
    </section>
    </main>
</template>

<script>

import Config from '@/config.js';
import axios from 'axios';
import MainSlider from '@/components/MainSlider';
import LinkButton from '@/components/LinkButton';
import OfferThumb from '@/components/OfferThumb';

export default {
    components:{
        MainSlider,
        LinkButton,
        OfferThumb
    }, 
    head () {
        return {
            title: this.page._yoast_wpseo_title,
            meta: [
                { hid: 'description', id: 'description', name: 'description', content: this.page._yoast_wpseo_metadesc }
            ]
        }
    },
    async asyncData({ query, error }) {
        let [page, offer] = await Promise.all([
            axios.get(`${Config.root}/wp-json/wp/v2/pages/?slug=strona-glowna`),
            axios.get(`${Config.root}/wp-json/wp/v2/oferta/`),
        ])
        return {
            page: page.data[0],
            offer: offer.data
        }
    },
    data(){
        return {
            page:{},
            offer: []
        }
    },
    mounted(){
        console.log(this.page);
        console.log(this.offer);
    }
 

}
</script>
<style lang="scss">
    @import '@/assets/css/pages/main-page.scss';
</style>

