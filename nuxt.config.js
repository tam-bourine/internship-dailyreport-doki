const config = {
    mode: 'spa',
    srcDir: 'client/',
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
                        url: '/login',
                        method: "post",
                        propertyName: false
                    },
                    user: {
                        url: '/user',
                        method: 'get',
                        propertyName: false
                    },
                    logout: {
                        url: '/logout',
                        method: 'post'
                    }

                }


            },

            tokenRequired: true,
            tokenType: 'bearer'

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

    generate: {
        dir: 'public/dist'
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
};

if (process.env.APP_ENV === 'local') {
    /*
     ** Axios module configuration
     ** See https://axios.nuxtjs.org/options
     */
    config.axios = {
        proxy: true
    };

    config.proxy = {
        '/api/': process.env.APP_URL
    };
}

export default config;
