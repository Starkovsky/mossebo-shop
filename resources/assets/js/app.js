/**
 * GLOBAL
 */
import './core/use_https'
import svg4everybody from './core/svg4everybody.legacy.min'
import './common'

/**
 * Imports
 */

import 'bootstrap'
import Vue from 'vue'


/**
 * Components
 */

import ScrollBar from './core/ScrollBar'
import Catalog from './components/shop/catalog/Catalog'
import ProductList from './components/shop/catalog/ProductList'
import ProductCard from './components/shop/catalog/ProductCard'
import FormattedPrice from './core/FormattedPrice'
import BannerHomeStock from './components/banners/BannerHomeStock'
import BannerHomeNew from './components/banners/BannerHomeNew'
import Cart from './components/shop/cart/Cart'



/**
 * App
 */

const app = new Vue({
    el: '#app',
    components: {
        ScrollBar,
        Catalog,
        ProductList,
        ProductCard,
        FormattedPrice,
        BannerHomeStock,
        BannerHomeNew,
        Cart
    },
    data: {
        ActionProduct: {
            'id': '100028',
            'name': 'Настольная лампа CHESTER 49385',
            'image': {
                src: '/uploads/media/product/467/responsive-images/5af5556b838f3777579684___small_200_200.jpg',
                srcset: '/uploads/media/product/467/responsive-images/5af5556b838f3777579684___small_400_400.jpg',
            },
            'price': '3490',
            'old_price': '4120'
        },
        mossebo: window.mossebo,
    },
    mixins: [
    ],
    methods: {
    },
    mounted() {
        // Tooltip
        $('[data-toggle="tooltip"]').tooltip();
        $('.dropdown-toggle').dropdown();
    },
});


// All Browser support SVG
// https://github.com/jonathantneal/svg4everybody
svg4everybody();


// TODO: Временная функция показа меню
$('.header-navigation-catalog').click(function (event) {
    $('.catalog-nav').toggleClass('catalog-nav-active');
    event.preventDefault();
});
$('.catalog-nav').click(function () {
    $('.catalog-nav').removeClass('catalog-nav-active');
});


// TODO: Временная функция показа активной корзины
$('.mobile-cart').click(function () {
    $('.mobile-cart').toggleClass('mobile-cart-active');
});


// Product Tabs
//$('#ProductTabs').tab('show');
$('#ProductTabs li:first-child a').tab('show');

// Product Slider
$('.slider-for').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: false,
    fade: true,
    asNavFor: '.slider-nav',
    lazyLoad: 'ondemand'
});

$('.slider-nav').slick({
    slidesToShow: 4,
    slidesToScroll: 1,
    asNavFor: '.slider-for',
    dots: false,
    //arrows: true,
    prevArrow: '<button type="button" class="slick-prev"><svg class="symbol-icon symbol-arrow-back"><use xlink:href="/assets/images/icons.svg#symbol-arrow-back"></use></svg></button>',
    nextArrow: '<button type="button" class="slick-next"><svg class="symbol-icon symbol-arrow-forward"><use xlink:href="/assets/images/icons.svg#symbol-arrow-forward"></use></svg></button>',
    centerMode: false,
    focusOnSelect: true,
    lazyLoad: 'ondemand'
});

// Product gallery
$('.zoom-gallery').magnificPopup({
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
    zoom: {
        enabled: true,
        duration: 300, // don't foget to change the duration also in CSS
        opener: function(element) {
            return element.find('img');
        }
    }
});

