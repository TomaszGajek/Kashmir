<template>
    <div>
        <Map/> 
        <footer class="footer" v-if="logo.acf">
            
            <img class="footer__logo" :src="logo.acf.footer_logo"/>
            <div class="footer__contact" v-html="logo.acf.footer_data"></div>
            <Socials/>
            <div class="rights">
                <p>Kashmir SPA - Malwina Markowska. © 2018</p>
                <p>realizacja: <a title="agencja interaktywna gdańsk" href="https://noveo.pl" target="_blank">Tworzenie stron - NOVEO</a></p>
            </div>
        </footer>
    </div>
</template>

<script>
import axios from 'axios';
import Config from '@/config.js';
import Socials from '@/components/Socials';
import Map from '@/components/Map';

export default {
    components:{
        Socials,
        Map
    },
    mounted(){
        axios.get(`${Config.root}/wp-json/acf/v3/options/options`)
            .then((response)=>{                
                this.logo= response.data;             
            })
    },
    data(){
        return{            
            logo:{}
        }
    },
}
</script>
<style lang="scss">
    @import '@/assets/css/components/Footer.scss';
</style>
