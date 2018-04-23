
/**
 * Imports
 */

import './core/use_https'

import 'bootstrap'
import Vue from 'vue'

/**
 * Components
 */

import ScrollBar from './core/ScrollBar'
import ProductList from './components/catalog/ProductList'
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

        // Tooltip
        $('[data-toggle="tooltip"]').tooltip();
    },
});




// TODO: Временная функция показа активной корзины
$('.mobile-cart').click(function () {
    $('.mobile-cart').toggleClass('mobile-cart-active');
})


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
    prevArrow: '<button type="button" class="slick-prev"><i class="md-icon">arrow_back</i></button>',
    nextArrow: '<button type="button" class="slick-next"><i class="md-icon">arrow_forward</i></button>',
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
