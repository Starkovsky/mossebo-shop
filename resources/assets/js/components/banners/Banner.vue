<template>
    <component
        :is="hasButton ? 'div' : 'a'"
        :href="hasButton ? null : link"
        :style="{backgroundImage: background}"
        :class="classNameWithModificators('banner', id, type)"
        :target="hasButton && linkIsOuter ? '_blank' : null"
    >
        <div class="banner__top">
            <background-image-loader
                v-if="image && type !== 'long'"
                :image="image"
                :screen="true"
                class="banner__image"
                :alt="title"
                @onload="imageLoaded"
            ></background-image-loader>

            <div
                v-else
                :style="{color: titleColor}"
                class="banner__title"
            >
                <font-resizer
                    style="width: 100%"
                    :min-size="titleMinFontSize"
                    :max-size="titleMaxFontSize"
                >
                    <span v-html="title"></span>
                </font-resizer>
            </div>
        </div>

        <div class="banner__center">
            <div
                v-if="caption"
                :style="{color: captionColor}"
                class="banner__caption"
            >
                <font-resizer
                    style="width: 100%"
                    :min-size="captionMinFontSize"
                    :max-size="captionMaxFontSize"
                >
                    <span v-html="caption"></span>
                </font-resizer>
            </div>
        </div>

        <div class="banner__bottom">
            <a
                v-if="hasButton && link"
                :href="link"
                class="button button-long button-shadow"
                :target="linkIsOuter ? '_blank' : null"
                :style="buttonStyle"
            >
                {{ buttonText }}
            </a>
        </div>
    </component>
</template>

<script>
    import Mixin from './mixin'
    import BackgroundImageLoader from '../imageLoaders/BackgroundImageLoader'

    const fontSizes = {
        title: {
            min: {
                long: 16,
                medium: 24,
                big: 30,
            },
            max: {
                long: 24,
                medium: 130,
                big: 130,
            }
        },
        caption: {
            min: {
                long: 14,
                medium: 16,
                big: 16,
            },
            max: {
                long: 18,
                medium: 18,
                big: 18,
            }
        },
    }

    export default {
        name: "Banner",

        mixins: [
            Mixin
        ],

        components: {
            BackgroundImageLoader
        },

        props: {
            isLong: Boolean
        },

        data() {
            return {
                elWidth: 0
            }
        },

        mounted() {
            this.$root.$on('resize', this.checkElSize)

            this.$nextTick(() => {
                this.checkElSize()
            })
        },

        methods: {
            imageLoaded() {
                this.$emit('image-loaded')
            },

            checkElSize() {
                this.elWidth = this.$el.scrollWidth
            }
        },

        computed: {
            hasButton() {
                return !! this.buttonText
            },

            linkIsOuter() {
                return (
                    typeof this.link === 'string' &&
                    this.link.indexOf('http') === 0 &&
                    this.link.indexOf(window.location.host) === -1
                )
            },

            titleLength() {
                return this.title.length
            },

            captionLength() {
                return Math.ceil(this.caption.length / 5)
            },

            type() {
                if (this.isLong && this.$root.windowMoreThan('sm')) {
                    return 'long'
                }

                return this.elWidth > 418 ? 'big' : 'medium'
            },

            titleMinFontSize() {
                return fontSizes.title.min[this.type]
            },

            titleMaxFontSize() {
                return fontSizes.title.max[this.type]
            },

            captionMinFontSize() {
                return fontSizes.caption.min[this.type]
            },

            captionMaxFontSize() {
                return fontSizes.caption.max[this.type]
            },

            background() {
                if (this.type === 'long' && this.backgroundImage2) {
                    return this.makeBackgroundUrl(this.backgroundImage2)
                }

                if (this.backgroundImage1) {
                    return this.makeBackgroundUrl(this.backgroundImage1)
                }

                return this.gradient
            },
        },
    }
</script>
