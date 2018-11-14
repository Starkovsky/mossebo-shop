<template>
    <loading :loading="loading">
        <div class="row">
            <div class="col-6 col-sm-4 col-md-3"
                 v-for="photo in photos"
                 :key="photo.src"
            >
                <a class="instagram-card block-ui block-ui--with-hover"
                   :href="photo.link"
                   target="_blank"
                   rel="nofollow noreferrer noopener"
                >
                    <background-image-loader
                        class="instagram-card__image image-preview image-preview--1-1"
                        :image="photo.src"
                        :retinaImage="photo.srcset"
                        :screen="true"
                    ></background-image-loader>

                    <div class="instagram-card__likes">
                        <svg class="instagram-card__icon">
                            <use xlink:href="/assets/images/icons.svg#symbol-heart"></use>
                        </svg>

                        {{ photo.likes }}
                    </div>
                </a>
            </div>
        </div>
    </loading>
</template>

<script>
    import Loading from './Loading'
    import instagramDataLoader from '../scripts/InstagramData'
    import BackgroundImageLoader from './imageLoaders/BackgroundImageLoader'

    export default {
        name: "Instagram",

        components: {
            Loading,
            BackgroundImageLoader
        },

        props: {
            profile: {
                type: String,
            },
            count: {
                type: Number,
                default: 8
            }
        },

        data() {
            return {
                loading: true,
                photos: [],
            }
        },

        mounted() {
            instagramDataLoader.getData(this.profile, this.count, images => {
                this.photos = images

                this.$nextTick(() => this.loading = false)
            })
        },
    }
</script>
