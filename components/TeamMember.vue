<template>
    <nuxt-link :to="`/o-nas/${member.slug}`" class="team-preview">
        <div class="team-preview__line">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <div class="team-preview__image" v-lazy:background-image="this.member.featured_image.url_large[0]"></div>
        </div>
        <h4 class="team-preview__title">{{this.member.title.rendered}}</h4>
        <h4 class="team-preview__role" >{{this.member.acf.role}}</h4>
        <p>{{this.member.acf.preview}}</p>        
    </nuxt-link>
</template>

<script>

export default {
    props:{
        member:{
            type:Object
        }
    }
}
</script>

<style lang="scss">
    @import '@/assets/css/components/TeamMember.scss';
</style>
