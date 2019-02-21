<template>
    <div>   
        <div class="page-baner">
            <h1>{{this.page.title.rendered}}</h1>
            <div class="bread-crumbs">
                <nuxt-link to="/">Start</nuxt-link>
                <span>/</span>
                <nuxt-link to="/oferta">Oferta</nuxt-link>
                <span>/</span>
                <nuxt-link :to="`/oferta/${parent[0].slug}`" class="">{{this.parent[0].title.rendered}}</nuxt-link>
                <span>/</span>
                <span class="bread-crumbs__destiny">{{this.page.title.rendered}}</span>
            </div>
        </div>
        <div class="container content container--narrow container--split">
            <div class="offer-single__content-wrapper">
                <img class="symbol-bottom" src="~/assets/images/flower.png"/> 
                <img class="offer-single__baner" v-lazy="page.featured_image.url[0]" />
                <article class="offer-single__content" v-html="page.content.rendered">                    
                </article>
                <div class="offer-single__gallery-wrapper" v-if="page.acf.gallery">
                    <Gallery :page="page.acf.gallery" />
                </div>
                <img class="symbol-bottom" src="~/assets/images/symbol.png"/>
            </div>
            <AsideMenu :links="offer" :parent="parent"/>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import Config from '@/config.js';
import AsideMenu from '@/components/AsideMenu';
import Gallery from '@/components/Gallery';
export default {
    components:{
        AsideMenu,
        Gallery
    },
    async asyncData({ params }) {
        let [page, offer] = await Promise.all([
            axios.get(`${Config.root}/wp-json/wp/v2/oferta/?slug=${params.slug}`),
            axios.get(`${Config.root}/wp-json/wp/v2/oferta/?per_page=100`)
        ]).catch(error=>{
            context.error(new Error())            
        })
        return {
            page: page.data[0],
            parent:offer.data.filter((parent)=>{
                return parent.id == page.data[0].parent
            }),
            offer: offer.data.filter((single)=>{
                return single.parent == page.data[0].parent
            })            
        }
    },
    mounted(){
        console.log(this.parent);
        console.log(this.offer);
    }
}
</script>

<style lang="scss">
    @import '@/assets/css/pages/offer-single.scss';
</style>
