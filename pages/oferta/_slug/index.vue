<template>
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
        <div class="container content" v-html="page.content.rendered"></div> 
    </section>
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
    asyncData ({ params }) {
        return axios.get(`${Config.root}/wp-json/wp/v2/oferta/?slug=${params.slug}`)
            .then(response => {
                console.log(response.data);
                return { page: response.data[0] }
            })
            .catch((error) => {
                return { error: error }
            })
    },
    data() {
        return {
        page: {},
        error: []
        }
    }

}
</script>
<style lang="scss">
    @import '@/assets/css/pages/offer-single.scss';
</style>
