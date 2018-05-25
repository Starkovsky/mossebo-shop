<template>
    <div :class="{'product-short-description': true, 'product-short-description--small': small}">
        <a
            class="product-short-description__image-wrap"
            :href="link"
            @mouseover="mouseover"
            @mouseout="mouseout"
            target="_blank"
        >
            <background-image-loader
                class="product-short-description__image"
                :image="prepareImage(product.image.src)"
                :retina-image="prepareImage(product.image.srcset)"
            ></background-image-loader>
        </a>

        <div class="product-short-description__info">
            <div v-if="product.category" class="product-short-description__category">
                {{ product.category }}
            </div>

            <a
                :href="link"
                class="product-short-description__title"
                @mouseover="mouseover"
                @mouseout="mouseout"
                target="_blank"
            >
                <span>{{ product.title }}</span>
            </a>

            <div v-if="product.attributes" class="product-short-description__attributes">
                {{ product.attributes }}
            </div>
        </div>
    </div>
</template>

<script>
    import Core from '../../scripts/core'
    import ProductImagesHat from '../../mixins/ProductImagesHat'
    import BackgroundImageLoader from '../imageLoaders/BackgroundImageLoader'

    export default {
        name: "ProductShortDescription",

        mixins: [
            ProductImagesHat
        ],

        components: {
            BackgroundImageLoader,
        },

        props: {
            product: Object,
            small: Boolean,
        },

        methods: {
            mouseover() {
                this.$el.classList.add('link-is-active')
            },

            mouseout() {
                this.$el.classList.remove('link-is-active')
            },
        },

        computed: {
            link() {
                return Core.siteUrl('goods/' + this.product.id)
            },
        }
    }
</script>
