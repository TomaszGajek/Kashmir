<template>
    <section>
        <div class="page-baner">
            <h1>{{this.page.title.rendered}}</h1>
            <div class="bread-crumbs">
                <nuxt-link to="/">Start</nuxt-link>
                <span>/</span>
                <nuxt-link to="/o-nas">O nas</nuxt-link>
                <span>/</span>
                <nuxt-link :to="`/${page.slug}`" style="color:#555555;">{{this.page.title.rendered}}</nuxt-link>
            </div>
        </div>
        <div class="container">
            <div class="member">
                <!-- <div class="member__photo" v-lazy:background-image="this.page.featured_image.url_large[0]"></div> -->
                <clazy-load :src="this.page.featured_image.url_large[0]">
                    <transition name="fade">
                        <div class="member__photo" :style="{backgroundImage:`url('${this.page.featured_image.url_large[0]}')`}"></div>
                    </transition>
                    <transition name="fade" slot="placeholder">
                        <div slot="placeholder">
                            Ładowanie....
                        </div>
                    </transition>
                </clazy-load>

                <h2>{{this.page.acf.role}}</h2>
                <img class="member__symbol" src="~/assets/images/symbol.png"/>
                <div class="member__description" v-html="this.page.content.rendered"></div>
                
            </div>
        </div>
    </section>
</template>

<script>
import axios from 'axios';
import Config from '@/config.js';

export default {
    // transition: '',
    head () {
        
        return {
            title: this.page._yoast_wpseo_title,
            meta: [
                { hid: 'description', id: 'description', name: 'description', content: this.page._yoast_wpseo_metadesc }
            ]
        }
    },
    
    asyncData ({params}) {
        return axios.get(`${Config.root}/wp-json/wp/v2/zespol/?slug=${params.slug}`)
        .then(response => {
           
            return { page: response.data[0] }
        })
        .catch((error) => {
            return { error: error }
        })
    },
}
</script>

<style scoped>
    
    @keyframes acrossIn {
      0% {
        transform: translate3d(-10%, 0, 0);
      }
      100% {
        transform: translate3d(0, 0, 0);
      }
    }
    @keyframes acrossOut {
      0% {
        transform: translate3d(0, 0, 0);
      }
      100% {
        transform: translate3d(10%, 0, 0);
      }
    }

    .page-enter-active {
      animation: acrossIn .40s ease-out both;
    } 
    .page-leave-active {
      animation: acrossOut .60s ease-in both;
    } 
</style>

