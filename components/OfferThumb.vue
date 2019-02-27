<template>
    <div class="thumb">
        <clazy-load :src="this.item.featured_image.url_large[0]">
            <transition name="fade">
                <div class="thumb__image" :style="{backgroundImage:`url('${this.item.featured_image.url_large[0]}')`}"></div>
            </transition>
            <transition name="fade" slot="placeholder">
                <div slot="placeholder">
                    Ładowanie...
                </div>
            </transition>
        </clazy-load>
        <div class="thumb__content">
            <img src="~/assets/images/symbol-2.png"/>
            <h4 class="text">Oferta</h4>
            <h2>{{this.item.title.rendered}}</h2>
            <nuxt-link class="link-button" :to="`/oferta/${item.slug}`">
                <span class="link-button__text">Sprawdź</span>
            </nuxt-link>
            </div>
    </div>
</template>


<script>
import LinkButton from '@/components/LinkButton';

export default {
    components:{
        LinkButton
    },
    props:{
        item:{
            type:Object
        }
    },
    data(){
        return{
            imgUrl: this.item.featured_image.url[0]
        }
    }
}
</script>
<style lang="scss">
    @import '@/assets/css/components/OfferThumb.scss';
</style>
