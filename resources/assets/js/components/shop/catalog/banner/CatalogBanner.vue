<template>
    <div v-if="index === 24" class="col-12">
        <banner-random
            is-long
            place="4"
        ></banner-random>
    </div>
</template>

<script>
    import BannerRandom from '../../../banners/BannersSet/BannerRandom'

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
