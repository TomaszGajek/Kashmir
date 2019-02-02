<template>
    <div class="page-baner">
        <h1>{{this.page.title.rendered}}</h1>
        <div class="bread-crumbs">
            <nuxt-link to="/">Start</nuxt-link>
            <span>/</span>
            <nuxt-link :to="`/${page.slug}`">{{this.page.title.rendered}}</nuxt-link>
        </div>
    </div>
</template>

<script>
export default {
    props:{
        page:{

        }
    },
    mounted(){
        console.log(this.page);
    }
}
</script>
<style lang="scss">
    @import '@/assets/css/components/PageHeader.scss';
</style>
