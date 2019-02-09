<template>
    <section>
        <PageHeader :page="page" />    
        <section class="about">
            <div class="container about__container">
                <img src="~/assets/images/flower.png" />
                <h4 class="text">{{this.page.acf.text}}</h4>
                <h2>{{this.page.acf.slogan}}</h2>
                <img src="~/assets/images/symbol.png"/>
                <p>{{this.page.acf.description}}</p>
                <LinkButton :link="page.acf.link"/>
            </div>
            <div class="container">
                <div class="about-bg" v-lazy:background-image="page.acf.background"></div>
            </div>
            <div class="container about__container">
                <img src="~/assets/images/flower.png" />
                <h4 class="text">{{this.page.acf.team_text}}</h4>
                <h2>{{this.page.acf.team_slogan}}</h2>
            </div>
            <div class="container">
                <div class="team-wrapper">
                    <TeamMember 
                        v-for="(member,index) in team" 
                        :key="index"
                        :member="member"/>
                </div>
            </div>
            <section class="review">
            <div class="container review__container">
                <img src="~/assets/images/flower.png" />
                <h4 class="text">{{this.main.acf.review_text}}</h4>
                <h2>{{this.main.acf.review_slogan}}</h2>
                <img src="~/assets/images/symbol.png"/>
            </div>
            <ReviewSlider :page="main"/>
        </section>
        </section>
    </section>
</template>
<script>
import Config from '@/config.js';
import axios from 'axios';
import PageHeader from '@/components/PageHeader';
import LinkButton from '@/components/LinkButton';
import TeamMember from '@/components/TeamMember';
import ReviewSlider from '@/components/ReviewSlider';

export default {
    components:{
        PageHeader,
        LinkButton,
        TeamMember,
        ReviewSlider
    },
    head () {
        return {
            title: this.page._yoast_wpseo_title,
            meta: [
                { hid: 'description', id: 'description', name: 'description', content: this.page._yoast_wpseo_metadesc }
            ]
        }
    },
    async asyncData({ query, error }) {
        let [page,team,main] = await Promise.all([
            axios.get(`${Config.root}/wp-json/wp/v2/pages/15`),
            axios.get(`${Config.root}/wp-json/wp/v2/zespol`),
            axios.get(`${Config.root}/wp-json/wp/v2/pages/?slug=strona-glowna`)

        ])
        return {
            page: page.data,
            team: team.data,
            main: main.data[0]            
        }
    },
    // data(){
    //     return {
    //         page:{},
    //         team:[],
    //         main:{}
    //     }
    // },
    mounted(){
        console.log(this.main);
    }
}
</script>
<style lang="scss">
    @import '@/assets/css/components/Onas.scss';
</style>
