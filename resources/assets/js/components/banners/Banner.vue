<template>
    <div
        :class="'banner banner--' + id"
        :style="{backgroundImage: gradient}"
    >
        <div class="banner__image-box">
            <background-image-loader
                :image="image"
                :screen="true"
                class="banner__image"
            ></background-image-loader>
        </div>

        <div class="banner__bottom">
            <div v-html="title" class="banner__title"></div>

            <div class="banner__button">
                <a
                    class="button button-long button-shadow"
                    :href="preparedLink"
                    :target="linkIsOuter ? '_blank' : '_self'"
                >
                    {{ buttonText }}
                </a>
            </div>
        </div>
    </div>
</template>

<script>
    import Core from '../../scripts/core'
    import BackgroundImageLoader from '../imageLoaders/BackgroundImageLoader'

    export default {
        name: "Banner",

        components: {
            BackgroundImageLoader
        },

        props: {
            id: Number,

            image: String,

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

            buttonText: {
                type: String,
                // todo: Назвать правильно
                default: Core.translate('See details')
            },

            link: {
                type: String
            }
        },

        computed: {
            linkIsOuter() {
                return this.link.indexOf('http') === 0 && this.link.indexOf(window.location.host) === -1
            },

            preparedLink() {
                return this.linkIsOuter ? this.link : Core.siteUrl(this.link)
            },

            gradient() {
                if (this.gradientIsRadial) {
                    return `radial-gradient(${this.gradientFrom}, ${this.gradientTo})`
                }

                return `linear-gradient(${this.gradientAngle}deg, ${this.gradientFrom} 0%, ${this.gradientTo} 100%)`
            }
        }
    }
</script>
