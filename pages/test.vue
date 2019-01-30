<template>
    <section class="offer">
        <div v-for="(item,index) in offer" :key="index">
            {{item.title.rendered}}
        </div>
    </section>
</template>

<script>
import axios from 'axios';
import Config from '@/config.js';

export default {

    asyncData({params}){
        return axios.get(`${Config.root}/wp-json/wp/v2/oferta/`)
            .then((response)=>{
                console.log(response.data);
                return {
                    offer: response.data
                }
            })
    },
    data(){
        return{
            offer: {},
            error: []        
        }
    }
}
</script>

<style>

</style>
