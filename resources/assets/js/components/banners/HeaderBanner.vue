<template>
    <component
        :is="buttonText ? 'div' : 'a'"
        :href="buttonText ? null : link"
        :class="classNameWithModificators('header-banner') + ' header-banner--' + id"
    >
        <template v-if="backgroundImage">
            <background-image-loader
                :key="$root.isMobile ? 'header-banner-mobile' : 'header-banner-desktop'"
                :image="backgroundImage"
                :screen="true"
                class="header-banner__bg"
            >
                <div v-html="title" :style="{color: titleColor}" class="header-banner__title"></div>

                <div v-if="buttonText" class="header-banner__button">
                    <a :style="buttonStyle" :href="link" class="button button-long button-small button-shadow">
                        {{ buttonText }}
                    </a>
                </div>

            </background-image-loader>
        </template>

        <template v-else>
            <div
                :style="{backgroundImage: gradient}"
                class="header-banner__bg"
            >
                <div v-html="title" :style="{color: titleColor}" class="header-banner__title"></div>

                <div v-if="buttonText" class="header-banner__button">
                    <a :style="buttonStyle" :href="link" class="button button-long button-small button-shadow">
                        {{ buttonText }}
                    </a>
                </div>
            </div>
        </template>
    </component>

</template>

<script>
    import Mixin from './mixin'
    import BackgroundImageLoader from '../imageLoaders/BackgroundImageLoader'

    export default {
        name: 'header-banner',

        mixins: [
            Mixin
        ],

        components: {
            BackgroundImageLoader
        },

        props: [
            'mobileImage'
        ],

        computed: {
            backgroundImage() {
                if (this.$root.isMobile) {
                    if (this.mobileImage) {
                        return this.mobileImage
                    }

                    if (this.image) {
                        return this.image
                    }
                }
                else {
                    if (this.image) {
                        return this.image
                    }

                    if (this.mobileImage) {
                        return this.mobileImage
                    }
                }

                return false
            },
        }
    }
</script>
