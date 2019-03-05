<template>
    <div>
        <section class="offer-single">
            <div class="page-baner">
                <h1 v-html="this.page.title.rendered"></h1>
                <div class="bread-crumbs">
                    <nuxt-link to="/">Start</nuxt-link>
                    <span>/</span>
                    <nuxt-link to="/oferta">Oferta</nuxt-link>
                    <span>/</span>
                    <span class="bread-crumbs__destiny" v-html="this.page.title.rendered"></span>
                </div>
            </div>
            <div class="container content container--narrow" v-if="this.offer.length > 0"> 
                             
                <div class="offer-single__wrapper">
                    <nuxt-link class="offer-single__thumbnail" 
                        :to="`/oferta/${page.slug}/${item.slug}`"
                        v-for="(item,index) in this.offer"
                        :key="index">  
                        <div class="offer-single__overlay">
                            <clazy-load :src="item.featured_image.url_large[0]" v-if="item.featured_image.url_large[0]">
                                <transition name="fade">
                                    <div class="offer-single__image" :style="{backgroundImage:`url('${item.featured_image.url_large[0]}')`}"></div>
                                </transition>
                                <transition name="fade" slot="placeholder">
                                    <div slot="placeholder">
                                        Ładowanie....
                                    </div>
                                </transition>
                            </clazy-load>
                            <div class="offer-single__title-wrapper">
                                <h2 class="offer-single__title" v-html="item.title.rendered"></h2>
                            </div>
                        </div>

                    </nuxt-link>
                </div>
                
            </div> 
            <div class="container content container--narrow container--split" v-else>
                <div class="offer-single__content-wrapper">
                    <article v-html="this.page.content.rendered"></article>
                    <div class="offer-single__gallery-wrapper" v-if="page.acf.gallery">
                        <h4>Galeria</h4>
                        <Gallery :page="page.acf.gallery" />
                    </div>
                    <img class="symbol-bottom" src="~/assets/images/symbol.png"/>
                </div>
                <aside class="aside">
                    <h4><p>Oferta</p></h4>
                    <nuxt-link 
                        class="link-button"
                        :to="`/oferta/${item.slug}`"
                        v-for="(item,index) in this.all"
                        :key="index">   
                        <span class="link-button__text" v-html="item.title.rendered"></span>                                         
                    </nuxt-link>
                </aside>
            </div>  

        </section>
    </div>
</template>

<script>

import axios from 'axios';
import Config from '@/config.js';
import Gallery from '@/components/Gallery';
import AsideMenu from '@/components/AsideMenu';


export default {
    components:{
        Gallery,
        AsideMenu
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
            all:offer.data.filter((single)=>{
                return single.parent === 0
            }),
            offer: offer.data.filter((single)=>{
                return single.parent == page.data[0].id
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
