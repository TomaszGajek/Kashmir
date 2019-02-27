<template>
    <div>
        <div class="container about__container">
            <img src="~/assets/images/flower.png" />
            <h4 class="text">{{this.page.acf.text}}</h4>
            <h2>{{this.page.acf.slogan}}</h2>
            <img src="~/assets/images/symbol.png"/>
            <p>{{this.page.acf.description}}</p>
        </div>
        <section class="offer">
            <div class="offer__wrap" v-for="i in rowCount"> 
                <OfferThumb v-for="(item,index) in offer.slice((i-1)*6,i*6)" :key="index" :item="item" />
            </div>
        </section>

    </div>
</template>

<script>
import Config from '@/config.js';
import axios from 'axios';
import OfferThumb from '@/components/OfferThumb';
export default {
    components:{
        OfferThumb
    },
    head () {
        return {
            title: this.page._yoast_wpseo_title,
            meta: [
                { hid: 'description', id: 'description', name: 'description', content: this.page._yoast_wpseo_metadesc }
            ]
        }
    },
    async asyncData({ query, error }) {
        let [page, offer] = await Promise.all([
            axios.get(`${Config.root}/wp-json/wp/v2/pages/?slug=oferta`),
            axios.get(`${Config.root}/wp-json/wp/v2/oferta/?per_page=100`)
        ])
        return {
            page: page.data[0],
            offer: offer.data.filter((single)=>{
                return single.parent === 0
            })
        }
    },
    mounted(){
        console.log(this.offer);
    },
    computed:{
        rowCount(){
            return Math.ceil(this.offer.length / 6);
        }
        
    }
}
</script>
