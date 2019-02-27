<template>
    <section>
        <PageHeader :page="page" />
        <div class="container container--voucher">
                <img src="~/assets/images/flower.png" />
                <div class="voucher__wrapper">
                    <clazy-load :src="this.page.acf.background">
                        <transition name="fade">
                            <img class="voucher__img"  :src="this.page.acf.background" />  
                        </transition>
                        <transition name="fade" slot="placeholder">
                            <div slot="placeholder">
                                Ładowanie....
                            </div>
                        </transition>
                    </clazy-load> 
                    <div class="voucher__content" v-html="this.page.content.rendered"></div>
                    <img src="~/assets/images/flower.png" />
                    <div class="voucher__children-wrapper">
                        <nuxt-link class="voucher__children" 
                            v-for="item in this.children"
                            :key="item.id"
                            :to="`/${item.slug}`" >
                            <p class="voucher__item-text">{{item.title.rendered}}</p>
                        </nuxt-link>
                    </div>
                </div>
                
                
            </div>
    </section>
</template>

<script>
import Config from '@/config.js';
import axios from 'axios';
import PageHeader from '@/components/PageHeader';

export default {
    components:{
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
    async asyncData({ query, error }) {
        let [page,children] = await Promise.all([
            axios.get(`${Config.root}/wp-json/wp/v2/pages/1014`),
            axios.get(`${Config.root}/wp-json/wp/v2/pages`)

        ])
        return {
            page: page.data,
            parent:page.data.id,
            children: children.data.filter((child)=>{ return child.parent === page.data.id })                  
        }
    },
    mounted(){
        console.log(this.children);
    }
}

</script>

<style lang="scss">
     @import '@/assets/css/pages/voucher.scss';
</style>
