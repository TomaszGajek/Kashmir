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
                <nuxt-link :to="`/oferta/${parent[0].slug}/${page.slug}`" class="">{{this.page.title.rendered}}</nuxt-link>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import Config from '@/config.js';
export default {
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
    }
}
</script>
