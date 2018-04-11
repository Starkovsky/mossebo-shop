
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
import ProductCard from './components/catalog/ProductCard'
import BannerHomeStock from './components/banners/BannerHomeStock'
import BannerHomeNew from './components/banners/BannerHomeNew'

/**
 * App
 */

const app = new Vue({
    el: '#app',
    components: {
        'product-list': ProductList,
        'product-card': ProductCard,
        'banner-home-stock': BannerHomeStock,
        'banner-home-new': BannerHomeNew,
    },
    data: {
        ActionProduct: {
            'id': '60',
            'name': 'Столик-оттоманка, иск.кожа (2561BL), цвет черный',
            'image': 'https://admin.mossebo.market/uploads/1548/responsive-images/5ac38d730158e661077194___small_400_400.jpeg',
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
