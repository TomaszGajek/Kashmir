<template>
    <div class="offer-single__tabs-title" @click="isOpen = !isOpen"><p>+ {{item.title.rendered}}</p>
        <transition 
            name="expand"
            @enter="enter"
            @after-enter="afterEnter"
            @leave="leave"
        >
        <div class="offer-single__tabs-content" v-show="isOpen">
        <nuxt-link
            :to="`/oferta/${page.slug}/${i.slug}`"            
            v-for="i in sectionLinks(item.id)"
            :key="i.id"
            class="offer-single__tabs-link">
                <div class="offer-single__tabs-overlay" :style="{ backgroundImage: 'url(' + i.featured_image.url_large[0] + ')' }">
                <div class="offer-single__title-wrapper">
                    <h2 class="offer-single__title-item">{{i.title.rendered}}</h2>
                </div>
                </div>
            </nuxt-link>
        </div>    
        </transition>
    </div>
</template>

<script>
export default {
    props:{
        children:{},
        item:{},
        page:{}

    },
    name: 'TransitionExpand',
    methods:{
        sectionLinks(itemId){
            return this.children.filter((link)=>{
                return link.parent === itemId;
            })
        },

        enter(element) {
            const width = getComputedStyle(element).width;

            element.style.width = width;
            element.style.position = 'absolute';
            element.style.visibility = 'hidden';
            element.style.height = 'auto';

            const height = getComputedStyle(element).height;

            element.style.width = null;
            element.style.position = null;
            element.style.visibility = null;
            element.style.height = 0;

            getComputedStyle(element).height;

            setTimeout(() => {
                element.style.height = height;
            });
        },

        afterEnter(element) {
            element.style.height = 'auto';
            },
            leave(element) {
            const height = getComputedStyle(element).height;
            
            element.style.height = height;

            getComputedStyle(element).height;

            setTimeout(() => {
                element.style.height = 0;
            });
        },

    },
    data(){
        return{
             isOpen:false
        }
    }
}
</script>

<style lang="scss">
     @import '@/assets/css/pages/offer-single.scss';

    

    // * {
    //     will-change: height;
    //     transform: translateZ(0);
    //     backface-visibility: hidden;
    //     perspective: 1000px;
    // }
     
</style>
