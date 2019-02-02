<template>
    <header>
    <nav class="navigation">
        <div class="container navigation__container">
            <nuxt-link to="/" ><img  class="navigation__logo" src="~/assets/images/logo.png"/></nuxt-link>
            <div class="navigation__wrapper">
                <ul class="navigation__list">
                    <li class="navigation__item" v-for="page in parent" :key="page.ID">
                        <nuxt-link 
                            class="navigation__link"
                            :to="page.link" 
                            :id="page.ID" 
                            @click.native="toggleSubMenu" >
                            {{page.title}}                            
                        </nuxt-link>
                        <transition name="slide">
                        <ul>                
                            <li class="navigation__sub-item" 
                                v-for="item in pages" 
                                v-if="item.menu_item_parent == page.ID">
                                <nuxt-link :to="item.link">{{item.title}}</nuxt-link>
                            </li>
                        </ul>   
                        </transition>                 
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
// import { Promise } from 'q';


export default {
    components:{
        Socials,
        Reservation
    },
    created(){
        axios.get(`${Config.root}/wp-json/menus/v1/menus/primary`)
            .then((response)=>{                
                this.pages = response.data.items;      
                // console.log(this.pages);          
            }).then(()=>{
                const items = document.querySelectorAll('.navigation__sub-item');
                if(items.length>0){
                    items.forEach((elem)=>{
                        // console.log(elem.parentNode.parentNode.firstChild);
                        elem.parentNode.classList.add('navigation__sub-list');
                        elem.parentNode.parentNode.firstChild.classList.add('navigation__link-dropdown')
                    })
                }
            })
    },
    methods:{
        toggleSubMenu(e){
            let parent = e.currentTarget.parentNode;
            let child = parent.querySelector('.navigation__sub-list')
            console.log( child);
            if(child != null){
                child.classList.toggle('open');
            }
            // if(e.currentTarget.classList.contains('navigation__link-dropdown')){
            //     console.log(e.currentTarget.parentNode.querySelector('.navigation__sub-list'));
            //     // e.currentTarget.nextSibling.classList.toggle('active');
            // }
        }
    },
    computed:{
        parent(){
            return this.pages.filter((elem)=>{
                return elem.menu_item_parent == 0
            });
        },
    },
    data(){
        return{            
            pages:[],
            isDropped: false
            
        }
    }
}
</script>

<style lang="scss">
    @import '@/assets/css/components/Header.scss';

</style>

