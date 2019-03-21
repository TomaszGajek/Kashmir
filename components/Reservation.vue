<template>
        <a v-if="link.acf" :href="link.acf.reservation_link" target="_blank" class="reservation-link"><p class="reservation-text">Zarezerwuj termin</p></a>
</template>

<script>
import axios from 'axios';
import Config from '@/config.js';

export default {
    mounted(){
        axios.get(`${Config.root}/wp-json/acf/v3/options/options`)
            .then((response)=>{                
                this.link= response.data;
                             
            })
    },
    data(){
        return{            
            link:{}
        }
    },
}
</script>


<style lang="scss">
    @import '@/assets/css/components/Reservation.scss';
</style>
