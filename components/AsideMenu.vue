<template>
    <aside class="aside">
        <h4 v-if="parent[0].title.rendered">{{parent[0].title.rendered}}</h4>
        <nuxt-link 
            class="aside__link"
            :to="`/oferta/${parent[0].slug}/${item.slug}`"
            v-for="(item,index) in this.links"
            :key="index" v-html="item.title.rendered">
                                  
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
        console.log(this.parent);
        console.log(this.links);
    }
}
</script>

<style lang="scss">
    @import '@/assets/css/components/AsideMenu.scss';
</style>

