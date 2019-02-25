
<template>
    <div>
        <section>
            <PageHeader :page="page"/>
            <div class="container container--narrow">
                <div class="content content--default" v-html="page.content.rendered"></div> 
            </div>
        </section>
    </div>
</template>

<script>

import axios from 'axios';
import Config from '@/config.js';
import PageHeader from '@/components/PageHeader';

export default {
    components:{
        PageHeader
    },
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
            return { page: response.data[0] }                     
        })
        .catch((error) => {
            return { error: error }
        })
    },
    data() {
        return {
            page: {},
            error: [],
            empty: false
        }
    }

}
</script>
