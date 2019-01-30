
import Config from '@/config.js';
import axios from 'axios';
import Vuex from 'vuex';


const createStore = () => {

    return new Vuex.Store({

        state: {
            page: {
                loading: true
            }
        },
        actions: {
            loadPage({commit},slug){
                let path = `${Config.root}/wp-json/wp/v2/pages/?slug=${slug}`;
                axios.get(path)
                    .then(response=>response.data[0])
                    .then(page=>{
                        commit('SET_PAGE',page)
                    })                
            }
        },
        mutations: {
            SET_PAGE(state,page){
                state.page = page
                state.page.loading = false
                
            }
        },
    
    })


}

export default createStore;