<template>
    <component
        :is="hasButton ? 'div' : 'a'"
        :href="hasButton ? null : link"
        :class="classNameWithModificators('header-banner', id)"
    >
        <component
            :is="backgroundImage ? 'background-image-loader' : 'div'"
            class="header-banner__bg"
            :style="backgroundImage ? null : {backgroundImage: gradient}"
            :image="backgroundImage ? backgroundImage : null"
            :screen="backgroundImage ? true : null"
        >

            <div class="header-banner__content">
                <div
                    :style="{color: titleColor}"
                    class="header-banner__title"
                >
                    <font-resizer
                        :min-size="type === 'mobile' ? 12 : 14"
                        :max-size="type === 'mobile' ? 16 : 18"
                    >
                        <span v-html="title"></span>
                    </font-resizer>
                </div>

                <div v-if="buttonText" class="header-banner__button">
                    <a :style="buttonStyle" :href="link" class="button button-small button-shadow">
                        {{ buttonText }}
                    </a>
                </div>
            </div>
        </component>
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

        computed: {
            backgroundImage() {
                if (this.$root.isMobile && this.backgroundImage2) {
                    return this.backgroundImage2
                }

                if (this.backgroundImage1) {
                    return this.backgroundImage1
                }

                return false
            },

            titleLength() {
                return Math.ceil(this.title.length / 5)
            },

            type() {
                return this.$root.isMobile ? 'mobile' : 'desktop'
            }
        }
    }
</script>
