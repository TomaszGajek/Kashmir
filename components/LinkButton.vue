<template>
    <nuxt-link :to="this.link.url" class="link-button">
        <span class="link-button__text">{{this.link.title}}</span>
    </nuxt-link>
</template>

<script>

export default {
    props:{
        link:{}
    }
}
</script>

<style lang="scss">
    @import '@/assets/css/components/LinkButton.scss';
</style>
