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
});


/**
 * Components
 */

import Catalog from './components/shop/catalog/Catalog'
import ProductList from './components/shop/catalog/ProductList'
import ProductCard from './components/shop/catalog/product-cards/ProductCard'
import FormattedPrice from './components/shop/price/FormattedPrice'
import BannerHomeStock from './components/banners/BannerHomeStock'
import BannerHomeNew from './components/banners/BannerHomeNew'
import Checkout from './components/shop/checkout/Checkout'
import CartBtn from './components/shop/cart/CartBtn'


import ProductControls from './components/shop/product/ProductControls'
import TabsHtml from './components/TabsHtml'
import Rating from './components/Rating'
import ProductActions from './components/shop/product/ProductActions'
import ProductSale from './components/shop/sale/ProductSale'

import CitiesSelect from './components/CitiesSelect'
import HeaderBanner from './components/HeaderBanner'
import BackgroundImageLoader from './components/imageLoaders/BackgroundImageLoader'

import Core from './scripts/core'
import './scripts/HeightToggle'
import './bootstrap/tooltip'

import initFixedMenu from './scripts/FixedMenu'
import initMainMenu from './scripts/MainMenu'
import setMeta from './scripts/MetaSetter'



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
        ProductSale,
        Catalog,
        ProductList,
        ProductCard,
        FormattedPrice,
        BannerHomeStock,
        BannerHomeNew,
        Checkout,
        CartBtn,
        ProductControls,
        TabsHtml,
        Rating,
        ProductActions,
        CitiesSelect,
        HeaderBanner,
        BackgroundImageLoader
    },
    data: {
        windowWidth: window.innerWidth,

        mossebo: window.mossebo,
    },
    mixins: [
    ],
    methods: {
        windowLessThan(size) {
            return this.windowWidth < breakpoints[size]
        },

        windowMoreThan(size) {
            return this.windowWidth >= breakpoints[size]
        },

        windowBetween(from, to) {
            return this.windowWidth >= breakpoints[from] && this.windowWidth < breakpoints[to]
        },

        translate() {
            return Core.translate.apply(null, arguments)
        },

        initTooltips() {
            $('[data-toggle="tooltip"]').tooltip()
        },

        setMeta
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
    },

    created() {
        this.resizeHandler = _.debounce(() => {
            this.windowWidth = window.innerWidth
            this.$emit('resize')
        }, 50)

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

// Product gallery
$('.js-zoom-gallery').magnificPopup({
    delegate: 'a',
    type: 'image',
    closeOnContentClick: false,
    closeBtnInside: false,
    mainClass: 'mfp-with-zoom mfp-img-mobile',
    image: {
        verticalFit: true,
        titleSrc: function(item) {
            return item.el.attr('title');
        }
    },
    gallery: {
        enabled: true
    },
});

// From an element with ID #popup
$('.js-pop-up-call').magnificPopup({
    items: {
        src: '#pop-up-call',
        type: 'inline'
    }
});
// From an element with ID #popup
$('.js-pop-up-message').magnificPopup({
    items: {
        src: '#pop-up-message',
        type: 'inline'
    }
});


// setMeta({
//     title: 'Azazazium',
//     breadcrumbs: [
//         {
//             title: 'Главная',
//             link: '/',
//         },
//         {
//             title: 'Комнаты',
//             link: '',
//         },
//     ],
//     'og:title': 'aza'
// })
