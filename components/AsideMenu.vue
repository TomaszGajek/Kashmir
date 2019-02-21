<template>
    <aside class="aside">
        <h4>{{parent[0].title.rendered}}</h4>
        <img class="aside__symbol" src="~/assets/images/symbol.png"/>
        <nuxt-link 
            class="aside__link"
            :to="`/oferta/${parent[0].slug}/${item.slug}`"
            v-for="(item,index) in this.links"
            :key="index">
                {{item.title.rendered}}                      
        </nuxt-link>
    </aside>
</template>

<script>
export default {
    props:{
        links:{},
        parent:{}
    }
}
</script>

<style lang="scss">
    @import '@/assets/css/components/AsideMenu.scss';
</style>

