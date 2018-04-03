
/**
 * Imports
 */

//import './core/use_https'

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
            'name': 'Столик-оттоманка, иск.кожа (2561BL), цвет черный',
            'image': '/uploads/276/responsive-images/5ac38c6e80a89951043818___medium_300_300.jpeg',
            'price': '1631000',
            'old_price': '1831000'
        }
    },
});

$('[data-toggle="tooltip"]').tooltip();
