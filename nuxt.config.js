const pkg = require('./package')

module.exports = {
  mode: 'spa',

  /*
  ** Headers of the page
  */
  head: {
    title: pkg.name,
    htmlAttrs: {
      lang: 'pl-PL',
    },
    meta: [
      { charset: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      { hid: 'description', name: 'description', content: 'Zapraszam Państwa do autoryzowanego gabinetu marki Dermalogica, w którym proponujemy zarówno zabiegi kosmetologii tradycyjnej, jak i te z zakresu kosmetologii i medycyny estetycznej. ' }
    ],
    script:[
      { src:'//translate.google.com/translate_a/element.js' }
    ],
    link: [
      { rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' }
    ]
    
  },

  /*
  ** Customize the progress-bar color
  */
  loading: { color: '#466502' },

  loadingIndicator: {
    name: 'chasing-dots',
    color: '#000000',
    background: 'white'
  },

  /*
  ** Global CSS
  */
  css: [
    '@/assets/css/main.scss'
  ],

  /*
  ** Plugins to load before mounting the App
  */
  plugins: [
    { src: '~/plugins/vue-lazyload', ssr: false },
    { src: '~/plugins/vue-clazy-load', ssr: false },
    { src: '~/plugins/vue-viewport', ssr: false },
    { src: '~/plugins/vue-observer', ssr: false }
  ],

  /*
  ** Nuxt.js modules
  */
  modules: [
    // Doc: https://github.com/nuxt-community/axios-module#usage
    '@nuxtjs/axios',
    ['nuxt-sass-resources-loader','~/assets/css/variables.scss']
  ],
  /*
  ** Axios module configuration
  */
  axios: {
    // See https://github.com/nuxt-community/axios-module#options
  },

  /*
  ** Build configuration
  */
  build: {
    /*
    ** You can extend webpack config here
    */
    extractCSS: true,

    performance: { hints: false },
    

    extend(config, ctx) {
      

    },
    generate: { fallback: "404.html" }



  }
}
