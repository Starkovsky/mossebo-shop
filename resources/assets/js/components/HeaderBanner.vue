<template>
    <a :href="link">
        <background-image-loader
            :key="$root.isMobile ? 'header-banner-mobile' : 'header-banner-desktop'"
            :image="$root.isMobile ? mobileImage : image"
            :screen="true"
            class="header-banner"
        ></background-image-loader>
    </a>
</template>

<script>
    import BackgroundImageLoader from './imageLoaders/BackgroundImageLoader'

    export default {
        name: 'HeaderBanner',

        components: {
            BackgroundImageLoader
        },

        props: [
            'link',
            'image',
            'mobileImage'
        ],
    }
</script>
