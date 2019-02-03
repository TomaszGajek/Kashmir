<template>
    <div class="thumb" :to="item.link">
        <div class="thumb__image" v-lazy:background-image="this.item.featured_image.url_large[0]"></div>
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
