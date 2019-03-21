<template>
    <aside class="aside">
        <h4 v-if="parent[0].title.rendered"><p v-html="parent[0].title.rendered"></p></h4>
        <nuxt-link 
            class="link-button"
            :to="`/oferta/${parent[0].slug}/${item.slug}`"
            v-for="(item,index) in this.links"
            :key="index">
              <span class="link-button__text" v-html="item.title.rendered"></span>                     
        </nuxt-link>
    </aside>
</template>

<script>
export default {
    props:{
        links:{},
        parent:{}
    },
    mounted(){

    }
}
</script>

<style lang="scss">
    @import '@/assets/css/components/AsideMenu.scss';
</style>

