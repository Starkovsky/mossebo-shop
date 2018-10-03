<template>
    <div class="row">
        <div v-for="banner in banners" :key="banner.id" class="col-12">
            <banner
                :id="banner.id"

                :link="banner.link"
                :title="banner.title"
                :caption="banner.caption"
                :button-text="banner.button"

                :title-color="banner.title_color"
                :caption-color="banner.caption_color"
                :button-color="banner.button_color"
                :button-background="banner.button_background"

                :image="banner.image"
                :background-image1="banner.background_image_1"
                :background-image2="banner.background_image_2"

                :gradient-from="banner.gradient.color_from"
                :gradient-to="banner.gradient.color_to"
                :gradient-type="banner.gradient.type"
                :gradient-angle="banner.gradient.angle"
            ></banner>
        </div>
    </div>
</template>

<script>
    import Mixin from './mixin'

    export default {
        name: 'banner-column',

        mixins: [
            Mixin,
        ],

        created() {
            this.loadBanners()
        },
    }
</script>
