<template>
    <div>
        <div class="page-baner">
            <h1 v-html="this.page.title.rendered"></h1>
            <div class="bread-crumbs">
                <nuxt-link to="/">Start</nuxt-link>
                <span>/</span>
                <nuxt-link to="/galeria">Galeria</nuxt-link>
                <span>/</span>
                <nuxt-link :to="`/galeria/${parent[0].slug}`" class="">{{this.parent[0].title.rendered}}</nuxt-link>
                <span>/</span>
                <span class="bread-crumbs__destiny" v-html="this.page.title.rendered"></span>
            </div>
        </div>
        <div class="gallery-box" v-if="page.acf.gallery">
            <img class="symbol-bottom" src="~/assets/images/flower.png"/>  
            <Gallery :page="page.acf.gallery"/>
            <img class="symbol-bottom" src="~/assets/images/symbol.png"/>
        </div>
        <div v-else><h2 style="text-align:center;">Brak galerii</h2></div>
    </div>
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
    async asyncData({params}){
        let[page,gallery] = await Promise.all([
            axios.get(`${Config.root}/wp-json/wp/v2/galeria/?slug=${params.slug}`),
            axios.get(`${Config.root}/wp-json/wp/v2/galeria/?per_page=100`)
        ])
        return {
             page: page.data[0],
             parent:gallery.data.filter((parent)=>{
                return parent.id == page.data[0].parent
            }),
        }
    },
    mounted(){
        console.log(this.page.acf.gallery);
    }    
}
</script>
