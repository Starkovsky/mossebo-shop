<template>
    <div
        v-if="banner"
    >
        <banner
            :id="banner.id"

            :is-long="isLong"
            :link="banner.link"
            :title="banner.title"
            :caption="banner.caption"
            :button-text="banner.button"

            :title-color="banner.title_color"
            :caption-color="banner.caption_color"
            :button-color="banner.button_color"
            :button-background="banner.button_background"

            :image="banner.small_image"
            :background-image="banner.background_image"

            :gradient-from="banner.gradient.color_from"
            :gradient-to="banner.gradient.color_to"
            :gradient-type="banner.gradient.type"
            :gradient-angle="banner.gradient.angle"
        ></banner>
    </div>
</template>

<script>
    import Mixin from './mixin'
    import {getRandomInt} from '../../../scripts/functions'

    export default {
        name: "banner-random",

        mixins: [
            Mixin
        ],

        props: {
            isLong: {
                type: Boolean,
                default: false,
            }
        },

        data() {
            return {
                banner: null
            }
        },

        created() {
            this.loadBanners()
        },

        methods: {
            setBanners(banners) {
                if (! banners) return

                this.banner = banners[getRandomInt(0, banners.length - 1)]
            }
        }
    }
</script>
