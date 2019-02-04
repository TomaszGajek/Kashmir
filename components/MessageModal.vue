<template>
    <transition name="fade">
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close" @click="$emit('close')">&times;</span>
            <ul class="message-error" v-if="errors.length">
                <li v-for="(error, index) in errors" :key="index">{{error}}</li>
            </ul>
            <div class="message-ok" v-if="message">
                <p>Dziękujemy, Twoja wiadomość została wysłana</p>
            </div>
        </div>
    </div>
    </transition>
</template>

<script>
export default {
    props:{
        errors:{
            type:Array
        },
        message:{}
    }
}
</script>

<style lang="scss">
    @import '@/assets/css/components/MessageModal.scss';
</style>

