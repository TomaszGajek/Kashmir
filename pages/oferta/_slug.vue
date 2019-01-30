<template>
    <div>
            <h1>
                {{$route.params.slug}}
            </h1>
            <div class="content" v-html="page.content.rendered"></div> 
        </div>
    </div>
</template>

<script>

import axios from 'axios';
import Config from '@/config.js';

export default {

    head () {
        return {
            title: this.page._yoast_wpseo_title,
            meta: [
                { hid: 'description', id: 'description', name: 'description', content: this.page._yoast_wpseo_metadesc }
            ]
        }
    },
    asyncData ({ params }) {
        return axios.get(`${Config.root}/wp-json/wp/v2/oferta/?slug=${params.slug}`)
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
