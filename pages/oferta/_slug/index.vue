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
                    <span class="bread-crumbs__destiny">{{this.page.title.rendered}}</span>
                </div>
            </div>
            <div class="container content container--narrow" v-if="this.offer.length > 0"> 
                <img class="symbol-bottom" src="~/assets/images/flower.png"/>               
                <div class="offer-single__wrapper">
                    <nuxt-link class="offer-single__thumbnail" 
                        :to="`/oferta/${page.slug}/${item.slug}`"
                        v-for="(item,index) in this.offer"
                        :key="index">  
                        <div class="offer-single__overlay">
                            <div class="offer-single__image" v-lazy:background-image="item.featured_image.url[0]"></div>                            
                            <div class="offer-single__read-more">
                                <h2>czytaj więcej</h2>
                            </div>                                             
                        </div>
                        <div class="offer-single__title-wrapper">
                            <h2 class="offer-single__title">{{item.title.rendered}}</h2>
                        </div>          
                    </nuxt-link>
                </div>
                <img class="symbol-bottom" src="~/assets/images/symbol.png"/>
            </div> 
            <div class="container content container--narrow" v-else>
                <img class="symbol-bottom" src="~/assets/images/flower.png"/>
                <!-- <img class="offer-single__baner" v-lazy="page.featured_image.url[0]" /> -->
                <article v-html="this.page.content.rendered">
                    
                </article>
                <div class="offer-single__gallery-wrapper" v-if="page.acf.gallery">
                    <Gallery :page="page.acf.gallery" />
                </div>
                <img class="symbol-bottom" src="~/assets/images/symbol.png"/>
            </div>  

        </section>
    </div>
</template>

<script>

import axios from 'axios';
import Config from '@/config.js';
import Gallery from '@/components/Gallery';


export default {
    components:{
        Gallery
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
    },
    mounted(){
        console.log(this.page);
    }
}
</script>
<style lang="scss">
    @import '@/assets/css/pages/offer-single.scss';
</style>
