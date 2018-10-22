import { mapState } from 'vuex'

import moreBtnMixin from './mixins/moreBtnMixin'

import CatalogFilterList from './filter/CatalogFilterList'
import CatalogProductList from './product-list/CatalogProductList'

import Loading from '../../Loading'
import Tabs from '../../Tabs'
import CardTypesChanger from './CardTypesChanger'
import ButtonLoading from '../../buttons/ButtonLoading'
import BannerSlider from '../../banners/BannersSet/BannerSlider'
import BannerColumn from '../../banners/BannersSet/BannerColumn'
import SidePopup from '../../SidePopup'
import ServerError from '../../ServerError'
import CatalogSort from './CatalogSort'

export default {
    name: "Catalog",

    components: {
        Loading,
        Tabs,
        CardTypesChanger,
        ButtonLoading,
        BannerSlider,
        BannerColumn,
        SidePopup,
        CatalogFilterList,
        CatalogProductList,
        ServerError,
        CatalogSort
    },

    mixins: [
        moreBtnMixin,
    ],

    props: [
        'filterTypes'
    ],

    computed: {
        ... mapState({
            ready: state => state.catalog.ready,
            error: state => state.catalog.error,
            loading: state => state.catalog.loading,
            filtering: state => state.catalog.filtering,
            paginating: state => state.catalog.pagination.loading,
            activeSortType: state => state.catalog.sort.active,
            activeCardType: state => state.catalog.cards.active,
            allProductsQuantity: state => state.catalog.products.length,
            products: state => state.catalog.pagination.productsToShow,
            filtersExists: state => state.catalog.filters.filters.length > 0,
            filtersIsDirty: state => state.catalog.filters.isDirty,
        }),
    },

    data() {
        return {
            errorRefreshIterations: 0,
        }
    },

    created() {
        this.$store.dispatch('catalog/init', this.filterTypes)
    },

    methods: {
        refreshCatalog() {
            if (++this.errorRefreshIterations > 1) {
                window.location.reload()
            }
            else {
                this.$store.dispatch('catalog/fetchCatalog')
            }
        },

        openPopup() {
            this.$refs.popup.open()
        },

        clearFilters() {
            this.$store.dispatch('catalog/clearFilters')
        },
    },
}
