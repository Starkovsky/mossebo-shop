
/**
 * Imports
 */

import './core/use_https'

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

$(function () {
    $('[data-toggle="tooltip"]').tooltip()
})
