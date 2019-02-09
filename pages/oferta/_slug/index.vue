<template>
    <div>
        <section class="offer-single">
            <div class="page-baner">
                <h1>{{this.page.title.rendered}}</h1>
                <div class="bread-crumbs">
                    <nuxt-link to="/">Start</nuxt-link>
                    <span>/</span>
                    <nuxt-link to="/oferta">Oferta</nuxt-link>
                    <span>/</span>
                    <nuxt-link :to="`/${page.slug}`" class="">{{this.page.title.rendered}}</nuxt-link>
                </div>
            </div>
            <div class="offer-single-wrapper">
                <nuxt-link class="offer-single-child" 
                    :to="`/oferta/${page.slug}/${item.slug}`"
                    v-for="(item,index) in this.offer"
                    :key="index">
                    {{item.title.rendered}}
                
                </nuxt-link>
            </div>
            <div class="container container--narrow" v-if="page.acf.background">
                <div class="offer-bg" v-lazy:background-image="page.acf.background"></div>
            </div>
            <div class="container content container--narrow" v-html="page.content.rendered"></div> 
        </section>
    </div>
</template>

<script>

import axios from 'axios';
import Config from '@/config.js';

export default {
     
    head () {
        return {
            title: this.page._yoast_wpseo_title,
            meta: [
                { hid: 'description', id: 'description', name: 'description', content: this.page._yoast_wpseo_metadesc }
            ]
        }
    },
    async asyncData({ params }) {
        let [page, offer] = await Promise.all([
            axios.get(`${Config.root}/wp-json/wp/v2/oferta/?slug=${params.slug}`),
            axios.get(`${Config.root}/wp-json/wp/v2/oferta/?per_page=100`)
        ])
        return {
            page: page.data[0],
            parent:page.data[0].id,
            offer: offer.data.filter((single)=>{
                return single.parent == page.data[0].id
            })
            
        }
    }
}
</script>
<style lang="scss">
    @import '@/assets/css/pages/offer-single.scss';
</style>
