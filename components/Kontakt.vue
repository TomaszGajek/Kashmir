<template>
    <div class="contact-form">        
        <form>
            <div class="field">
                <input type="text" class="input" placeholder="Name" v-model="form.full_name">
            </div>
            <div class="field">
                <input type="email" class="input" placeholder="Email" v-model="form.email">
            </div>
            <div class="field">
                <textarea  class="textarea" cols="30" rows="10" placeholder="Your message" v-model="form.body"></textarea>            
            </div>
            <div class="field field-button">
                <button v-on:click.prevent="submitForm">WYŚLIJ</button>
            </div>
        </form>
        <MessageModal :errors="errors" v-if="active" @close="closeModal" :message="message"/>
    </div>
</template>

<script>
import axios from 'axios';
import Config from '@/config.js';
import MessageModal from '@/components/MessageModal';

export default {
    components:{
        MessageModal
    },
    data(){        
        return{            
            url: `${Config.root}/wp-json/send-contact-form/v1/contact`,
            form:{
                full_name: '',
                email:'',
                body:''
            },
            active:false,
            errors:[],
            message:false
                      
        } 
    },
    methods:{
        submitForm(){
            axios.post(this.url,this.form)
                .then((response)=>{
                    console.log(response);
                    this.erros = [];
                    this.active = true;
                    this.message = true;
                })
                .catch((error)=>{
                    this.active = true;
                    this.message = false;
                    this.errors = error.response.data.message;
                });
        },
        closeModal(){
            this.active=false;
            this.errors = [];

        }
    }
}
</script>

<style lang="scss">
    @import '@/assets/css/components/Kontakt.scss';
</style>
