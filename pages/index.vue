<template>
  <section class="container">
      <MainSlider :page="page"/>
  </section>
</template>

<script>

import Config from '@/config.js';
import axios from 'axios';
import MainSlider from '@/components/MainSlider';

export default {
    components:{
        MainSlider
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
            return axios.get(`${Config.root}/wp-json/wp/v2/pages/?slug=strona-glowna`)
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

