<template>
    <div>   
        <div class="page-baner">
            <h1 v-html="this.page.title.rendered"></h1>
            <div class="bread-crumbs">
                <nuxt-link to="/">Start</nuxt-link>
                <span>/</span>
                <nuxt-link to="/oferta">Oferta</nuxt-link>
                <span>/</span>
                <nuxt-link :to="`/oferta/${parent[0].slug}`" class="">{{this.parent[0].title.rendered}}</nuxt-link>
                <span>/</span>
                <span class="bread-crumbs__destiny" v-html="this.page.title.rendered"></span>
            </div>
        </div>
        <div class="container content container--narrow container--split">
            <div class="offer-single__content-wrapper">
                <clazy-load :src="page.featured_image.url_large[0]" v-if="page.featured_image.url_large[0]">
                    <transition name="fade">
                        <img class="offer-single__baner" :src="page.featured_image.url_large[0]"/>
                    </transition>
                    <transition name="fade" slot="placeholder">
                        <div slot="placeholder">
                            Ładowanie....
                        </div>
                    </transition>
                </clazy-load>
                <!-- <img class="offer-single__baner" v-lazy="page.featured_image.url[0]" /> -->
                <article class="offer-single__content" v-html="page.content.rendered">                    
                </article>
                <div class="offer-single__gallery-wrapper" v-if="page.acf.gallery">
                    <h4>Galeria</h4>
                    <Gallery :page="page.acf.gallery" />
                </div>
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
    }
}
</script>

<style lang="scss" scoped>
    @import '@/assets/css/pages/offer-single.scss';

    @keyframes acrossIn {
      0% {
        transform: translate3d(-10%, 0, 0);
      }
      100% {
        transform: translate3d(0, 0, 0);
      }
    }
    @keyframes acrossOut {
      0% {
        transform: translate3d(0, 0, 0);
      }
      100% {
        transform: translate3d(10%, 0, 0);
      }
    }

    .page-enter-active {
      animation: acrossIn .40s ease-out both;
    } 
    .page-leave-active {
      animation: acrossOut .60s ease-in both;
    }    
</style>
