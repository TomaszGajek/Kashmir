<template>
    <section class="media">
        <PageHeader :page="page" />
        <h2>Piszą o nas w mediach</h2>
        <img class="symbol-bottom" src="~/assets/images/flower.png" />
        <div class="media__articles">
            <div class="media__row" v-for="i in rowCount">
                <div class="media__thumb" v-for="(item,index) in articles.slice((i-1)*3,i*3)">
                    <div class="media__thumb-image" v-lazy:background="item.img">
                        <div class="media__thumb-text">
                            <p>{{item.title}}</p>
                        </div>
                    </div>
                    
                    <a :href="item.link" target="_blank" class="link-button link-button--media">
                        <span class="link-button__text">czytaj więcej</span>
                    </a> 
                </div>
            </div>
        </div>
        <!-- <img class="symbol-bottom" src="~/assets/images/symbol.png"/> -->
        <div class="media__galleries">
            <div class="media__galleries-item" 
                v-for="(item,index) in this.galleries"
                :key="index">
                <h2 class="media__galleries-title">{{item.title}}</h2>
                <!-- <img class="symbol-bottom" src="~/assets/images/flower.png" /> -->
                <Gallery :page="item.gallery"/>
            </div>
            
        </div>
    </section>
</template>

<script>

import axios from 'axios';
import Config from '@/config.js';
import PageHeader from '@/components/PageHeader';
import Gallery from '@/components/Gallery';

export default {
    components:{
        PageHeader,
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
    async asyncData({ query, error }) {
        let [page] = await Promise.all([
            axios.get(`${Config.root}/wp-json/wp/v2/pages/?slug="media"`)
        ])
        return {
            page: page.data[0],
            articles: page.data[0].acf.media_articles,
            galleries: page.data[0].acf.galleries            
        }
    },
    computed:{
        rowCount(){
            return Math.ceil(this.articles.length / 3);
        }
    }
    
}
</script>
<style lang="scss">
    @import '@/assets/css/pages/media.scss';
</style>