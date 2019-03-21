<template>
    <header>
        <nav class="navigation" :class="[ isScrolling ? 'isScrolling' : '' ]">
            <div class="container navigation__container">
                <nuxt-link to="/" ><img  class="navigation__logo" src="~/assets/images/logo.png"/></nuxt-link>
                <div class="navigation__wrapper" :class="[isOpen ? 'isOpen':'']">
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
                    <div class="translation-links">
                        <p class="pl notranslate" data-lang="angielski" v-if="this.lang_uk" @click="this.toggleLang">
                            <img src="~/assets/images/uk.png"/>
                        </p>
                        
                        <p class="en notranslate" data-lang="polski" v-if="this.lang_pl" @click="this.closeLang">
                            <img src="~/assets/images/pl.png"/>
                        </p>
                    </div>
                </div>
            </div>
            <div class="navigation__hamburger" @click="toggleNav">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </nav>
        <div class="arrow-down" v-if="isScrolling" @click="this.returnTop">
            <img src="~/assets/images/arrow-up.png"/>
        </div>
        <nuxt-link to="/voucher" class="voucher-link">
            <p class="voucher-text">Voucher Upominkowy</p>
        </nuxt-link>

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
        simulateClick(elem){
            const evt = new MouseEvent('click', {
                bubbles: true,
                cancelable: true,
                view: window
            });

            const canceled = !elem.dispatchEvent(evt);
        },
        toggleLang(e){
            this.lang_uk = false;
            this.lang_pl = true;
            const lang = e.currentTarget.dataset.lang;
            const frame = document.querySelector('.goog-te-menu-frame');
            const content = frame.contentDocument.body;
            const elems = [...content.querySelectorAll('.goog-te-menu2-item')];
            const action = elems.filter( item => item.querySelector('.text').innerHTML === lang )

            this.simulateClick(action[0])

            return false;

        },

        closeLang(e){
            this.lang_uk = true;
            this.lang_pl = false;
            const frame = document.querySelector('.goog-te-banner-frame');
            const content = frame.contentDocument.body;
            const close = content.querySelector('.goog-close-link');
            this.simulateClick(close)
        },

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
        returnTop(){ window.scrollTo({top:0,left:0,behavior:"smooth"}); },
        toggleNav(){ this.isOpen = !this.isOpen; },
        hideMenu(){ this.isOpen = false; }
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
            this.isOpen = false;
            // document.querySelector('.navigation__wrapper').classList.remove('isOpen');
        }
    },
    data(){
        return{            
            pages:[],
            isDropped: false,
            isScrolling:false,
            isOpen:false,
            lang_uk:true,
            lang_pl: false
            
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

