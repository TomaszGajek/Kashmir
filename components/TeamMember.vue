<template>
    <nuxt-link :to="`/o-nas/${member.slug}`" class="team-preview" v-in-viewport.once>
        <div class="team-preview__line">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <clazy-load :src="this.member.featured_image.url_large[0]">
                <transition name="fade">
                    <div class="team-preview__image" :style="{backgroundImage:`url('${this.member.featured_image.url_large[0]}')`}"></div>
                </transition>
                <transition name="fade" slot="placeholder">
                    <div slot="placeholder">
                        Ładowanie....
                    </div>
                </transition>
            </clazy-load>
        </div>
        <h4 class="team-preview__title">{{this.member.title.rendered}}</h4>
        <h4 class="team-preview__role" >{{this.member.acf.role}}</h4>
        <!-- <p>{{this.member.acf.preview}}</p> -->
        <div class="link-button">
            <span class="link-button__text">Czytaj więcej</span>
        </div>        
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
