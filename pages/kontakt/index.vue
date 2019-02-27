<template>
    <section class="contact">
        <PageHeader :page="page" />
        <div class="container about__container">
            <img src="~/assets/images/flower.png" />
        </div>
        <div class="contact-info" v-html="this.page.content.rendered">

        </div>
        <div class="contact__container">
        <div class="contact__wrapper">
                <div class="contact__column" 
                    v-for="(item,index) in this.columns"
                    :key="index">
                        <img :src="item.icon" />
                        <div class="contact__text" v-html="item.text"></div>
                    </div>
            </div>
        </div>    
        <div class="container about__container">
            <img src="~/assets/images/flower.png" />
            <h2>{{this.page.acf.contact_slogan}}</h2>
            <img src="~/assets/images/symbol.png"/>
        </div>
        
        <Kontakt/>
        
    </section>
    
</template>

<script>
import axios from 'axios';
import Config from '@/config.js';
import PageHeader from '@/components/PageHeader';
import Kontakt from '@/components/Kontakt';


export default {
    components:{
        PageHeader,
        Kontakt
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
            axios.get(`${Config.root}/wp-json/wp/v2/pages/?slug="kontakt"`)
        ])
        return {
            page: page.data[0],
            columns: page.data[0].acf.row         
        }
    },
    mounted(){
        console.log(this.columns);
    }
}
</script>
<style lang="scss">
    @import '@/assets/css/pages/kontakt.scss';
</style>
