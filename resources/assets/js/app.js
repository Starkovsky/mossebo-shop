
/**
 * Imports
 */

import './core/use_https'

import 'bootstrap'
import Vue from 'vue'

/**
 * Components
 */

import ProductList from './components/catalog/ProductList'
import ScrollBar from './core/ScrollBar'
import ProductCard from './components/catalog/ProductCard'
import BannerHomeStock from './components/banners/BannerHomeStock'
import BannerHomeNew from './components/banners/BannerHomeNew'

/**
 * App
 */

const app = new Vue({
    el: '#app',
    components: {
        'scroll-bar': ScrollBar,
        'product-list': ProductList,
        'product-card': ProductCard,
        'banner-home-stock': BannerHomeStock,
        'banner-home-new': BannerHomeNew,
    },
    data: {
        ActionProduct: {
            'id': '60',
            'name': 'Столик-оттоманка, иск.кожа (2561BL), цвет черный',
            'image': '//admin.mossebo.market/uploads/1548/responsive-images/5ac38d730158e661077194___small_400_400.jpeg',
            'price': '1054321',
            'old_price': '1831000'
        },
    },
    props: [
        'language'
    ],
    mixins: [

    ],
    methods: {
        GetCurrentLanguage() {
            this.language = $("html").attr("lang");
        }
    },
    mounted() {
        this.GetCurrentLanguage();
    },
});



$('[data-toggle="tooltip"]').tooltip();

// TODO: Временная функция показа активной корзины
$('.mobile-cart').click(function () {
    $('.mobile-cart').toggleClass('mobile-cart-active');
})

$('#myTab').tab('show')

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
    prevArrow: '<button type="button" class="slick-prev"><i class="md-icon">keyboard_arrow_left</i></button>',
    nextArrow: '<button type="button" class="slick-next"><i class="md-icon">keyboard_arrow_right</i></button>',
    centerMode: false,
    focusOnSelect: true,
    lazyLoad: 'ondemand'
});

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
