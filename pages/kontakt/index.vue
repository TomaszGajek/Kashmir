<template>
    <div>
        <PageHeader :page="page" />
        <div class="container about__container">
            <img src="~/assets/images/flower.png" />
            <h2>{{this.page.acf.contact_slogan}}</h2>
            <img src="~/assets/images/symbol.png"/>
        </div>
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
        return axios.get(`${Config.root}/wp-json/wp/v2/pages/?slug="kontakt"`)
        .then(response => {
            console.log(response.data);
            return { 
                        page: response.data[0]                    
                    }
        })
        .catch((error) => {
            return { error: error }
        })
    },
    data() {
        return {
            page: {}
            
        }
    }
}
</script>
