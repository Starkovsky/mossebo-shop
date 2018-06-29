<template>
    <div v-if="index === 24" class="col-12">
        <banner-random
            is-long
        ></banner-random>
    </div>
</template>

<script>
    import BannerRandom from '../../../banners/BannerRandom'

    export default {
        name: 'CatalogBanner',

        props: {
            index: null
        },

        components: {
            BannerRandom
        },
    }
</script>
