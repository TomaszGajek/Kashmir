<template>
    <section class="gallery">
        <div class="container about__container">
            <img src="~/assets/images/flower.png" />
            <h4 class="text">{{this.page.acf.text}}</h4>
            <h2>{{this.page.acf.slogan}}</h2>
            <img src="~/assets/images/symbol.png"/>
        </div>
        <div class="gallery__wrapper">
            <nuxt-link class="gallery__item" 
            v-for="item in gallery" 
            :key="item.id"
            v-lazy:background-image="item.featured_image.url[0]"
            :to="`/galeria/${item.slug}`"
            >
                <div class="gallery__overlay">
                    <div class="gallery__line">
                        <h2>{{item.title.rendered}}</h2>
                        <img src="~/assets/images/symbol.png"/>
                    </div>

                </div>
            </nuxt-link>
        </div>
    </section>
</template>
<script>
import axios from 'axios';
import Config from '@/config.js';
import Gallery from '@/components/Gallery';
import PageHeader from '@/components/PageHeader';

export default {
    components:{
        Gallery,
        PageHeader
    },

    head() {
        return {
            title: this.page._yoast_wpseo_title,
            meta: [
                { hid: 'description', id: 'description', name: 'description', content: this.page._yoast_wpseo_metadesc }
            ]
        }
    },
    async asyncData({ query, error }) {
        let [page, gallery] = await Promise.all([
            axios.get(`${Config.root}/wp-json/wp/v2/pages/?slug=galeria`),
            axios.get(`${Config.root}/wp-json/wp/v2/galeria/?per_page=100`)
        ])
        return {
            page: page.data[0],
            gallery: gallery.data.filter((single)=>{
                return single.parent === 0
            }),
            images: gallery.data.map( (elem) => {return elem.featured_image.url[0]} )

        }
    },
    mounted(){
        
    }
}
</script>
<style lang="scss">
    @import '@/assets/css/pages/gallery.scss';
</style>
