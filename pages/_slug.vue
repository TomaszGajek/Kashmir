
<template>
    <div>
        <!-- <div v-if="this.$store.state.page.loading === false"> -->
            <h1>
                {{$route.params.slug}}
            </h1>
            <div class="content" v-html="page.content.rendered"></div> 
        </div>
        <!-- <div v-else>Loading...</div>  -->
    </div>
</template>

<script>

import axios from 'axios';
import Config from '@/config.js';
// import {mapState} from 'vuex';

export default {

    // created(){  
    //     console.log(this.$store.state.page.loading);
    //     this.$store.dispatch('loadPage',this.$route.params.slug);        
    // }, 

    // computed: {
    //     ...mapState([
    //         'page'
    //     ])
    // },

    // data(){
    //     return{
    //         data : '',
    //         content:''
    //     }
    // }

    head () {
        return {
            title: this.page._yoast_wpseo_title,
            meta: [
                { hid: 'description', id: 'description', name: 'description', content: this.page._yoast_wpseo_metadesc }
            ]
        }
    },
    asyncData ({ params }) {
        return axios.get(`${Config.root}/wp-json/wp/v2/pages/?slug=${params.slug}`)
        .then(response => {
            console.log(response.data);
            return { page: response.data[0] }
        })
        .catch((error) => {
            return { error: error }
        })
    },
    data() {
        return {
        page: {},
        error: []
        }
    }

}
</script>
