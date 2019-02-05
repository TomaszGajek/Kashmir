<template>
    <header>
    <nav class="navigation" :class="[ isScrolling ? 'isScrolling' : '' ]">
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
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            {{page.title}}                          
                        </nuxt-link>
                        <transition name="slide">
                        <ul>                
                            <li class="navigation__sub-item" 
                                v-for="item in pages" 
                                v-if="item.menu_item_parent == page.ID">
                                <nuxt-link :to="item.link"><span>{{item.title}}</span></nuxt-link>
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
    <div class="arrow-down" v-if="isScrolling" @click="this.returnTop">
        <img src="~/assets/images/arrow-up.png"/>
    </div>
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
    
    methods:{
        toggleSubMenu(e){
            let parent = e.currentTarget.parentNode;
            let child = parent.querySelector('.navigation__sub-list')
            
            if(child != null){
                child.classList.toggle('open');
                parent.classList.toggle('color');
            }
        },
        handleScroll: function(e){ 
            if(window.scrollY>0){
                this.isScrolling = true
            } else {
                this.isScrolling = false
            }       
        },
        returnTop(){
            window.scrollTo({top:0,left:0,behavior:"smooth"});
        }

    },
    computed:{
        parent(){
            return this.pages.filter((elem)=>{
                return elem.menu_item_parent == 0
            });
        }
         
    },
    watch:{
        '$route'(){
            document.querySelector('.navigation__sub-list').classList.remove('open');
        }
    },
    data(){
        return{            
            pages:[],
            isDropped: false,
            isScrolling:false
            
        }
    },
    created(){
        axios.get(`${Config.root}/wp-json/menus/v1/menus/primary`)
            .then((response)=>{                
                this.pages = response.data.items;      
                         
            }).then(()=>{
                const items = document.querySelectorAll('.navigation__sub-item');
                if(items.length>0){
                    items.forEach((elem)=>{
                        
                        elem.parentNode.classList.add('navigation__sub-list');
                        elem.parentNode.parentNode.firstChild.classList.add('navigation__link-dropdown')
                    })
                }
        });
        window.addEventListener('scroll', this.handleScroll);
    },
    destroyed() {
        window.removeEventListener('scroll', this.handleScroll);
    }  
    
}
</script>

<style lang="scss">
    @import '@/assets/css/components/Header.scss';

</style>

