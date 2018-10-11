<template>
    <div class="ht-popup-wrap" v-if="ready && false">
        <a href="javascript:void(0);" class="location js-ht"
        >
            <div class="location-icon">
                <svg class="symbol-icon symbol-location">
                    <use xlink:href="/assets/images/icons.svg#symbol-location"></use>
                </svg>
            </div>

            <div>
                <div class="location-name">
                    {{ cityName }}
                </div>

                <div class="location-phone">
                    {{ $root.config('main-phone') }}
                </div>
            </div>

            <svg class="symbol-icon symbol-keyboard-down">
                <use xlink:href="/assets/images/icons.svg#symbol-keyboard-down"></use>
            </svg>
        </a>

        <div class="ht-container ht-container--popup ht-container--right ht-container--cities">
            <div class="ht-inner">
                <template v-if="! selected && ! rejected">
                    <city-popup-confirm
                        :close="close"
                        @reject="reject"
                        class="block-ui"
                    ></city-popup-confirm>
                </template>

                <template v-else>
                    <city-popup-search
                        :close="close"
                        class="block-ui"
                    ></city-popup-search>
                </template>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapState } from 'vuex'
    import CityPopupSearch from './CityPopupSearch'
    import CityPopupConfirm from './CityPopupConfirm'

    export default {
        name: 'CitiesSelect',

        components: {
            CityPopupSearch,
            CityPopupConfirm
        },

        data() {
            return {
                rejected: false,
            }
        },

        watch: {
            ready: 'init'
        },

        beforeCreate() {
            this.$store.dispatch('city/init')
        },

        beforeDestroy() {
            if (this.btn) {
                this.btn.heightToggle.destroy()
            }
        },

        methods: {
            init() {
                this.$nextTick(() => {
                    this.btn = this.$el.querySelector('.js-ht')

                    heightToggle(this.btn, {
                        bindCloseEvents: true,
                        isOpened: !this.selected
                    })
                })
            },

            reject() {
                this.rejected = true
            },

            setCity(city) {
                this.$store.dispatch('city/setCity', city)
                this.btn.heightToggle.close()
            },

            close() {
                this.btn.heightToggle.close()
            }
        },

        computed: {
            selectedCity() {
                return true
            },

            ... mapState({
                ready:    state => state.city.ready,
                cityName: state => state.city.name,
                selected: state => state.city.selected
            })
        }
    }
</script>
