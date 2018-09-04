<template>
    <div
        :class="classNameWithModificators('banner') + ' banner--' + id"
        :style="{backgroundImage: background}"
    >
        <div v-if="image" class="banner__image-box">
            <background-image-loader
                :image="image"
                :screen="true"
                class="banner__image"
                :alt="title"
                @onload="imageLoaded"
            ></background-image-loader>
        </div>

        <div v-else v-html="title" :style="{color: titleColor}" class="banner__title"></div>

        <div class="banner__bottom">
            <div v-html="caption" :style="{color: captionColor}" class="banner__caption"></div>

            <div class="banner__button">
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
    </div>
</template>

<script>
    import Core from '../../scripts/core'
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
            image: String,

            backgroundImage: String,

            gradientFrom: {
                default: '#fcc600'
            },

            gradientTo: {
                default: '#fdda55'
            },

            gradientIsRadial: {
                default: false
            },

            gradientType: {
                default: 'linear'
            },

            gradientAngle: {
                default: 45,
            },
            title: String,

            caption: String,

            buttonText: {
                type: String,
                // todo: Назвать правильно
                default: Core.translate('See details')
            },

            link: {
                type: String
            },
        },

        computed: {
            linkIsOuter() {
                return this.link.indexOf('http') === 0 && this.link.indexOf(window.location.host) === -1
            },
        },

        methods: {
            imageLoaded() {
                this.$emit('image-loaded')
            }
        }
    }
</script>
