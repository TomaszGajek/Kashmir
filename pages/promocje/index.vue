<template>
    <section class="offer-single">
        <div class="page-baner">
            <h1>{{this.page.title.rendered}}</h1>
            <div class="bread-crumbs">
                <nuxt-link to="/">Start</nuxt-link>
                <span>/</span>
                <nuxt-link :to="`/${page.slug}`" class="">{{this.page.title.rendered}}</nuxt-link>
            </div>
        </div>
        <div class="container container--narrow">
            <div class="price-list">
               
                <div class="price-list__box" v-for="(title,index) in price_list" :key="index">                    
                    <div class="price-list__header" v-if="title.price_list_title" v-in-viewport.once>
                        <img  class="price-list__image" src="~/assets/images/flower.png" />
                        <h2 class="price-list__title">
                            {{title.price_list_title}}
                        </h2>
                        <img  class="price-list__image" src="~/assets/images/symbol.png"/>
                    </div>
                    <div class="price-list__content" v-for="item in title.price_list_box" v-in-viewport.once>
                        <p>{{item.price_list_name}}</p>
                        <p>{{item.price_list_cost}}</p>
                        
                    </div>
                </div>
                
            </div>
        </div>     
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
        return axios.get(`${Config.root}/wp-json/wp/v2/pages/?slug=promocje`)
            .then(response => {
                console.log(response.data);
                return { 
                    page: response.data[0],
                    price_list: response.data[0].acf.price_list
                    
                }
            })
            .catch((error) => {
                return { error: error }
            })
    },
    data() {
        return {
            page: {},
            price_list: []
        }
    },
    mounted(){
        
    }

}
</script>
<style lang="scss">
     @import '@/assets/css/pages/price-single.scss';   
</style>
