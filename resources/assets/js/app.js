
/**
 * Imports
 */

import 'bootstrap'
import Vue from 'vue'

/**
 * Components
 */

import ProductList from './components/ProductList'

/**
 * App
 */

const app = new Vue({
    el: '#app',
    components: {
        'product-list': ProductList,
    }
});
