<template>
    <div class="cabinet block-ui">
        <div class="cabinet__tabs">
            <tabs
                :tabs="pages"
                :active="activePage"
                :class-name-modificators="['center', 'underline']"
                @activation="to"
            ></tabs>
        </div>

        <div class="cabinet__content">
            <cabinet-orders v-if="activePage === 'orders'"></cabinet-orders>

            <cabinet-profile v-if="activePage === 'profile'"></cabinet-profile>

            <cabinet-reviews v-if="activePage === 'reviews'"></cabinet-reviews>
        </div>
    </div>
</template>

<script>
    import { mapState } from 'vuex'
    import Tabs from '../../Tabs'
    import CabinetProfile from './components/CabinetProfile'
    import CabinetReviews from './components/CabinetReviews'
    import CabinetOrders from './components/CabinetOrders'

    export default {
        name: "Cabinet",

        components: {
            Tabs,
            CabinetProfile,
            CabinetReviews,
            CabinetOrders
        },

        mounted() {
            this.$store.dispatch('cabinet/init')

            document.addEventListener('click', this.linkClick)
        },

        beforeDestroy() {
            document.removeEventListener('click', this.linkClick)
        },

        methods: {
            to(pageName) {
                this.$store.dispatch('cabinet/setPage', pageName)
            },

            linkClick(e) {
                let link = e.target.href
                if (! (typeof link === 'string')) return

                for (let key in this.pages) {
                    if (link.indexOf('cabinet#' + key) !== -1) {
                        e.preventDefault()
                        this.to(key)
                        break
                    }
                }
            }
        },

        computed: {
            ... mapState({
                pages: state => state.cabinet.pages,
                activePage: state => state.cabinet.active
            }),
        }
    }
</script>
