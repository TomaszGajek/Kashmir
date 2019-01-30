<template>
    <header>
    <nav class="navigation">
        <div class="container navigation__container">
            <nuxt-link to="/" ><img  class="navigation__logo" src="~/assets/images/logo.png"/></nuxt-link>
            <div class="navigation__wrapper">
                <ul class="navigation__list">
                    <li class="navigation__item" v-for="(page,index) in pages" :key="index">
                        <nuxt-link :to="page.link" class="navigation__link">{{page.title}}</nuxt-link>
                    </li>
                </ul>
                <Reservation/>
                <Socials/>
            </div>
        </div>
    </nav>
    </header>
</template>

<script>
import axios from 'axios';
import Config from '@/config.js';
import Socials from '@/components/Socials';
import Reservation from '@/components/Reservation';

export default {
    components:{
        Socials,
        Reservation
    },
    created(){
        axios.get(`${Config.root}/wp-json/menus/v1/menus/primary`)
            .then((response)=>{                
                this.pages = response.data.items;               
            })
    },
    data(){
        return{            
            pages:[]
        }
    }
}
</script>

<style lang="scss">
    @import '@/assets/css/components/Header.scss';

</style>
