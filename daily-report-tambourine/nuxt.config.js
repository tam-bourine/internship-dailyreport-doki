  export default {
    mode: 'spa',
    /*
     ** Headers of the page
     */
    head: {
      title: process.env.npm_package_name || '',
      meta: [{
          charset: 'utf-8'
        },
        {
          name: 'viewport',
          content: 'width=device-width, initial-scale=1'
        },
        {
          hid: 'description',
          name: 'description',
          content: process.env.npm_package_description || ''
        }
      ],
      link: [{
        rel: 'icon',
        type: 'image/x-icon',
        href: '/favicon.ico'
      }]
    },
    /*
     ** Customize the progress-bar color
     */
    loading: {
      color: '#fff'
    },
    /*
     ** Global CSS
     */
    css: [
      '@/assets/css/reset.css',
      '@/assets/css/index.css'
    ],
    /*
     ** Plugins to load before mounting the App
     */
    plugins: [],
    /*
     ** Nuxt.js dev-modules
     */
    buildModules: [],
    /*
     ** Nuxt.js modules
     */
    modules: [
      // Doc: https://axios.nuxtjs.org/usage
      '@nuxtjs/axios',
      '@nuxtjs/markdownit',
      'nuxt-fontawesome',
      '@nuxtjs/auth'
    ],
    /*
     ** Axios module configuration
     ** See https://axios.nuxtjs.org/options
     */
    axios: {},


    auth: {


      redirect: {

        login: '/login',
        logout: '/',
        callback: '/login',
        home: '/'

      },
      strategies: {

        local: {

          endpoints: {

            login: {
              url: 'http://localhost:5000/api/auth/login',
              method: "post",
              propertyName: 'token'
            },

            logout: {
              url: 'http://localhost:5000/api/auth/logout',
              method: false
            },

            user: {
              url: 'http://localhost:5000/api/auth/user',
              method: 'get',
              propertyName: false
            },

            tokenRequired: true,
            tokenType: 'Bearer'





          }


        },
        tokenRequired: false,
        tokenType: false


      }
    },


    /*
     ** Build configuration
     */
    build: {
      /*
       ** You can extend webpack config here
       */
      extend(config, ctx) {}
    },

    fontawesome: {

      imports: [{
        set: '@fortawesome/free-solid-svg-icons',
        icons: ['fas']
      }]

    },

    markdownit: {
      injected: true,
      breaks: true,
      html: true,
      linkify: true,
      typography: true,
      use: [
        'markdown-it-toc'
      ]
    }
  }