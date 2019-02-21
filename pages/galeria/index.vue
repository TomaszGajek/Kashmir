<template>
    <section class="gallery">
        <PageHeader :page="page" />
        <div class="container about__container">
            <img src="~/assets/images/flower.png" />
            <h2>{{this.page.acf.gallery_slogan}}</h2>
            <img src="~/assets/images/symbol.png"/>
        </div>
        <div class="gallery-buttons">
            <div class="link-button" @click="activetab=1" :class="[ activetab === 1 ? 'active' : '' ]"> 
                <span class="link-button__text">Biuro</span>
            </div>
            <div class="link-button" @click="activetab=2" :class="[ activetab === 2 ? 'active' : '' ]"> 
                <span class="link-button__text">Eventy</span>
            </div>
            <div class="link-button" @click="activetab=3" :class="[ activetab === 3 ? 'active' : '' ]"> 
                <span class="link-button__text">Praca</span>
            </div>
            <div class="link-button" @click="activetab=4" :class="[ activetab === 4 ? 'active' : '' ]"> 
                <span class="link-button__text">Dyplomy</span>
            </div>
        </div>
        <div class="container">
            <transition name="fade"> 
                <Gallery :page="page.acf.gallery_office" v-if="activetab === 1" />
            </transition>

            <transition name="fade"> 
                <Gallery :page="page.acf.gallery_events" v-if="activetab === 2" />
            </transition> 

            <transition name="fade">     
                <Gallery :page="page.acf.gallery_work" v-if="activetab === 3" />
            </transition>    

            <transition name="fade"> 
                <Gallery :page="page.acf.gallery_diploma" v-if="activetab === 4" />
            </transition>
            <img class="symbol-bottom" src="~/assets/images/symbol.png"/>
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

    head () {
        return {
            title: this.page._yoast_wpseo_title,
            meta: [
                { hid: 'description', id: 'description', name: 'description', content: this.page._yoast_wpseo_metadesc }
            ]
        }
    },
    asyncData ({ params }) {
        return axios.get(`${Config.root}/wp-json/wp/v2/pages/?slug="galeria"`)
        .then(response => {
            console.log(response.data);
            return { 
                        page: response.data[0]                    
                    }
        })
        .catch((error) => {
            return { error: error }
        })
    },
    data() {
        return {
            page: {},
            activetab:1
            
        }
    }
}
</script>
<style lang="scss">
    @import '@/assets/css/pages/gallery.scss';
</style>
