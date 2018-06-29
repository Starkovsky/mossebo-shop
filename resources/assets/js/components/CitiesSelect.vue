<template>
    <div class="ht-popup-wrap">
        <a href="javascript:void(0);" class="location js-ht"
        >
            <div class="location-icon">
                <svg class="symbol-icon symbol-location">
                    <use xlink:href="/assets/images/icons.svg#symbol-location"></use>
                </svg>
            </div>

            <div>
                <div class="location-name">
                    {{ currentCity.name }}
                </div>

                <div class="location-phone">
                    {{ currentCity.phone }}
                </div>
            </div>

            <svg class="symbol-icon symbol-keyboard-down">
                <use xlink:href="/assets/images/icons.svg#symbol-keyboard-down"></use>
            </svg>
        </a>

        <div class="ht-container ht-container--popup ht-container--right">
            <div class="ht-inner block-ui">
                <template v-for="city in cities">
                    <a
                        href="javascript:void(0);"
                        class="dropdown-item"
                        @click="setCity(city.id)"
                    >
                        {{ city.name }}
                    </a>
                </template>
            </div>
        </div>
    </div>
</template>

<script>
    import Core from '../scripts/core'

    export default {
        name: 'CitiesSelect',

        data() {
            return {
                currentCityId: Core.config('location.userCity'),
                cities: Core.config('location.cities'),
                btn: null,
            }
        },

        mounted() {
            this.btn = this.$el.querySelector('.js-ht')

            heightToggle(this.btn, {
                bindCloseEvents: true
            })
        },

        beforeDestroy() {
            this.btn.heightToggle.destroy()
        },

        methods: {
            setCity(cityId) {
                Core.cookie.set('city', this.currentCityId = cityId)
                this.btn.heightToggle.close()
            }
        },

        computed: {
            currentCity() {
                return this.cities.find(city => city.id === this.currentCityId)
            }
        }
    }
</script>
