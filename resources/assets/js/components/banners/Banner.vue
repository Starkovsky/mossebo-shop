<template>
    <component
        :is="hasButton ? 'div' : 'a'"
        :href="hasButton ? null : link"
        :class="classNameWithModificators('banner', id, type)"
        :style="{backgroundImage: background}"
    >
        <div class="banner__accent-box">
            <background-image-loader
                v-if="image"
                :image="image"
                :screen="true"
                class="banner__image"
                :alt="title"
                @onload="imageLoaded"
            ></background-image-loader>

            <div
                v-else
                v-html="title"
                :style="{color: titleColor}"
                :class="classNameWithModificators('banner__title', titleLength)"
            ></div>
        </div>

        <div class="banner__bottom">
            <div
                v-html="caption"
                :style="{color: captionColor}"
                :class="classNameWithModificators('banner__caption', captionLength)"
            ></div>

            <div v-if="hasButton && link" class="banner__button">
                <a
                    class="button button-long button-shadow"
                    :href="link"
                    :target="linkIsOuter ? '_blank' : '_self'"
                    :style="buttonStyle"
                >
                    {{ buttonText }}
                </a>
            </div>
        </div>
    </component>
</template>

<script>
    import Mixin from './mixin'
    import BackgroundImageLoader from '../imageLoaders/BackgroundImageLoader'

    export default {
        name: "Banner",

        mixins: [
            Mixin
        ],

        components: {
            BackgroundImageLoader
        },

        props: {
            isLong: false,
            backgroundImage: String,
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
            linkIsOuter() {
                return this.link.indexOf('http') === 0 && this.link.indexOf(window.location.host) === -1
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
            }
        },
    }
</script>
