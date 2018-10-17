/**
 * GLOBAL
 */
import svg4everybody from './core/svg4everybody.legacy.min'
import './common'

/**
 * Imports
 */

import './bootstrap'
import Vue from 'vue'

import Vuex from 'vuex'
Vue.use(Vuex)
import storeSkeleton from './store'
const store = new Vuex.Store(storeSkeleton)

import VeeValidate from 'vee-validate'

Vue.use(VeeValidate, {
    fieldsBagName: 'formFields',
    errorBagName: 'formErrors'
})


/**
 * Components
 */
import FontResizer from './components/FontResizer'
import SearchInput from './components/SearchInput'
import Reviews from './components/reviews/Reviews'
import Catalog from './components/shop/catalog/Catalog'
import CatalogSearch from './components/shop/catalog/CatalogSearch'
import ProductList from './components/shop/catalog/ProductList'
import ProductCard from './components/shop/catalog/product-cards/types/ProductCard'
import FormattedPrice from './components/shop/price/FormattedPrice'
import Checkout from './components/shop/checkout/Checkout'
import Cabinet from './components/shop/cabinet/Cabinet'
import CartBtn from './components/shop/cart/CartBtn'


import ProductControls from './components/shop/product/ProductControls'
import TabsHtml from './components/TabsHtml'
import Rating from './components/Rating'
import ProductActions from './components/shop/product/ProductActions'
import ProductSale from './components/shop/sale/ProductSale'

import CitiesSelect from './components/city-select/CitiesSelect'
import HeaderBanner from './components/banners/HeaderBanner'
import BannerSlider from './components/banners/BannersSet/BannerSlider'
import BackgroundImageLoader from './components/imageLoaders/BackgroundImageLoader'

import Core from './scripts/core'
import './scripts/HeightToggle'
import './bootstrap/tooltip'
import '@fancyapps/fancybox'
import 'slick-carousel'

import initFixedMenu from './scripts/FixedMenu'
import initMainMenu from './scripts/MainMenu'
import setMeta from './scripts/MetaSetter'
import FormSender from "./scripts/FormSender";


/**
 * App
 */

const breakpoints = {
    xs: 1,
    sm: 576,
    md: 768,
    lg: 992,
    xl: 1200
}

const app = new Vue({
    el: '#app',
    store,
    components: {
        Reviews,
        ProductSale,
        Catalog,
        CatalogSearch,
        ProductList,
        ProductCard,
        FormattedPrice,
        Checkout,
        Cabinet,
        CartBtn,
        ProductControls,
        TabsHtml,
        Rating,
        ProductActions,
        CitiesSelect,
        HeaderBanner,
        BackgroundImageLoader,
        SearchInput,
        BannerSlider,
        FontResizer
    },
    data: {
        windowWidth: window.innerWidth,

        mossebo: window.mossebo,
    },
    // mixins: [
    //
    // ],

    created() {
        this.resizeHandler = _.debounce(() => {
            this.windowWidth = window.innerWidth
            this.$emit('resize')
        }, 120)

        window.addEventListener('resize', this.resizeHandler, { passive: true })
    },

    mounted() {
        initFixedMenu('.js-fixed-menu')

        initMainMenu()

        heightToggle('.js-ht', {
            bindCloseEvents: true
        })
    },

    beforeDestroy() {
        window.removeEventListener('resize', this.resizeHandler)
    },

    methods: {
        touchResize() {
            this.resizeHandler()
        },

        windowLessThan(size) {
            return this.windowWidth < this.getBreakpoint(size)
        },

        windowMoreThan(size) {
            return this.windowWidth >= this.getBreakpoint(size)
        },

        getBreakpoint(size) {
            return breakpoints[size]
        },

        windowBetween(from, to) {
            return this.windowWidth >= breakpoints[from] && this.windowWidth < breakpoints[to]
        },

        translate() {
            return Core.translate.apply(null, arguments)
        },

        config() {
            return Core.config.apply(null, arguments)
        },

        initTooltips() {
            let $els = $('[data-toggle="tooltip"]')

            $els.tooltip({
                trigger: 'hover'
            })

            $els.each((index, el) => {
                let $el = $(el)

                $el.on('touchstart', () => {
                    $el.tooltip('show')
                })
                    .on('touchend', () => {
                        $el.tooltip('hide')
                    })
            })
        },

        setMeta,

        isAuthorized() {
            return !! this.userId()
        },

        userId() {
            return Core.config('user.id')
        },
    },

    computed: {
        isMobile() {
            return this.windowLessThan('sm')
        },

        isTablet() {
            return this.windowMoreThan('sm') && this.windowLessThan('lg')
        },

        isDesktop() {
            return this.windowMoreThan('lg')
        },

        catalogUrl() {
            return Core.siteUrl('/catalog')
        }
    },
});

window.app = app


// All Browser support SVG
// https://github.com/jonathantneal/svg4everybody
svg4everybody();

// Instagram Slider
$('.slider-instagram').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: false,
    fade: true,
    lazyLoad: 'ondemand',
    dots: true,
    autoplay: true,
    autoplaySpeed: 5000,
});

// Product Slider
$('.js-product-slider').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: false,
    dots: true,
    asNavFor: '.slider-nav',
    lazyLoad: 'ondemand',
    mobileFirst: true,

    responsive: [
        {
            breakpoint: 991,
            settings: {
                fade: true,
                dots: false
            }
        }
    ]
});

$('.slider-nav').slick({
    slidesToShow: 4,
    slidesToScroll: 1,
    asNavFor: '.js-product-slider',
    dots: false,
    //arrows: true,
    prevArrow: '<button type="button" class="slick-prev"><svg class="symbol-icon symbol-arrow-back"><use xlink:href="/assets/images/icons.svg#symbol-arrow-back"></use></svg></button>',
    nextArrow: '<button type="button" class="slick-next"><svg class="symbol-icon symbol-arrow-forward"><use xlink:href="/assets/images/icons.svg#symbol-arrow-forward"></use></svg></button>',
    centerMode: false,
    focusOnSelect: true,
    lazyLoad: 'ondemand',
});

(function () {
   let $slider = $('.js-studio-work-life')

    if (! $slider.length) return
    let initialized = false

    function check() {
        if (app.windowLessThan('md')) {
            if (! initialized) {
                $slider.slick({
                    prevArrow: false,
                    nextArrow: false,
                    variableWidth: true,
                    dots: true
                })

                initialized = true
            }
        }
        else {
            if (initialized) {
                $slider.slick('unslick');
                initialized = false
            }
        }
    }

    app.$on('resize', check)

    check()
}())

;[].forEach.call(document.querySelectorAll('.js-form-sender'), el => new FormSender(el))


$('.js-form-popup').fancybox(
    Core.getFancyboxConfig()
)

// ;(function () {
//     let characters = [
//         {
//             name: 'seal',
//             showed: false
//         },
//         {
//             name: 'robot',
//             showed: false
//         },
//         {
//             name: 'rabbit',
//             showed: false
//         }
//     ]
//
//     window.addEventListener('DOMContentLoaded', e => {
//         let stack = []
//         let phrase = 'mossebokids'
//
//         window.addEventListener('keydown', e => {
//             let code = e.keyCode || e.which
//             let key = String.fromCharCode(code).toLowerCase()
//
//             stack.push(key)
//
//             let joined = stack.join('')
//
//             if (phrase.indexOf(joined) === -1) {
//                 stack = [key]
//             }
//
//             if (joined === phrase) {
//                 stack = []
//                 showCharacter()
//             }
//         })
//     })
//
//     function showPromo() {
//         alert('Промокод на покупку товаров Mossebo//kids: KIDSRULETHEWORLD')
//     }
//
//     function showCharacter() {
//         let character = _.shuffle(characters).find(character => !character.showed)
//
//         if (! character) {
//             showPromo()
//             return
//         }
//
//         character.showed = true
//
//         let el = document.createElement('div')
//         el.classList.add('kids-hidden')
//         el.classList.add('kids-hidden--' + character.name)
//
//         el.addEventListener('transitionend', e => {
//             document.body.removeChild(el)
//         }, {passive: true, once: true})
//
//
//         document.body.appendChild(el)
//
//         setTimeout(() => {
//             el.classList.add('animate')
//         })
//     }
// }())


import {CookieStorageProxy} from './scripts/storage/CookieStorageProxy'

window.CookieStorageProxy = CookieStorageProxy








window.addEventListener('DOMContentLoaded', e => {
    Core.metrika.reachGoal('test', null, () => {
    })
})
