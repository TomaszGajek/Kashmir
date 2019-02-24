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
    </div>
</template>

<script>
import axios from 'axios';
import Config from '@/config.js';
import Gallery from '@/components/Gallery';
import AsideMenu from '@/components/AsideMenu';

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
            axios.get(`${Config.root}/wp-json/wp/v2/galeria/?slug=${params.slug}`),
            axios.get(`${Config.root}/wp-json/wp/v2/galeria/?per_page=100`)
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
    },
    mounted(){

    }
}
</script>
