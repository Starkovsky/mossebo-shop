<template>
    <div
        v-if="image && noImageLoading"
        class="product-image bg-image"
        :style="'background-image: url(' + prepareImage(image.srcset || image.src) + ')'"
    ></div>

    <background-image-loader
        v-else-if="image && !noImageLoading"
        class="product-image"
        :screen="true"
        :image="prepareImage(image.src)"
        :retina-image="prepareImage(image.srcset)"
    ></background-image-loader>

    <div v-else class="bg-image product-image"></div>
</template>

<script>
    import ProductImagesHat from '../../../../../mixins/ProductImagesHat'
    import BackgroundImageLoader from '../../../../imageLoaders/BackgroundImageLoader'

    export default {
        name: "ProductCardImage",

        mixins: [
            ProductImagesHat
        ],

        components: {
            BackgroundImageLoader
        },

        props: [
            'image',
            'noImageLoading'
        ],
    }
</script>
