<template>
    <div>
        <div class="page-baner">
            <h1 v-html="this.page.title.rendered"></h1>
            <div class="bread-crumbs">
                <nuxt-link to="/">Start</nuxt-link>
                <span>/</span>
                <nuxt-link to="/galeria">Galeria</nuxt-link>
                <span>/</span>
                <span class="bread-crumbs__destiny" v-html="this.page.title.rendered"></span>
            </div>
        </div>
        <div class="container content" v-if="this.gallery.length > 0"> 
            <img class="symbol-bottom" src="~/assets/images/flower.png"/>             
            <div class="gallery__wrapper gallery__wrapper--slug">
                <nuxt-link class="gallery__item gallery__item--inner" 
                v-for="item in gallery" 
                :key="item.id"
                v-lazy:background-image="item.featured_image.url[0]"
                :to="`/galeria/${page.slug}/${item.slug}`"
                >
                    <div class="gallery__overlay">
                        <div class="gallery__line">
                            <h2>{{item.title.rendered}}</h2>
                        </div>

                    </div>
                </nuxt-link>
            </div>
            <img class="symbol-bottom" src="~/assets/images/symbol.png"/>
        </div>
        <div class="gallery-box" v-else>
            <img class="symbol-bottom" src="~/assets/images/flower.png"/>  
            <Gallery :page="page.acf.gallery" v-if="page.acf.gallery"/>
            <img class="symbol-bottom" src="~/assets/images/symbol.png"/>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import Config from '@/config.js';
import Gallery from '@/components/Gallery';
import AsideMenu from '@/components/AsideMenu';

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
        let [page, gallery] = await Promise.all([
            axios.get(`${Config.root}/wp-json/wp/v2/galeria/?slug=${params.slug}`),
            axios.get(`${Config.root}/wp-json/wp/v2/galeria/?per_page=100`)
        ])
        return {
            page: page.data[0],
            parent:page.data[0].id,
            all:gallery.data.filter((single)=>{
                return single.parent === 0
            }),
            gallery: gallery.data.filter((single)=>{
                return single.parent == page.data[0].id
            })
            
        }
    },
    mounted(){
        
    }
}
</script>
