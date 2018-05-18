<template>
    <img :src="image$" :class="{'image-loader': true, 'animate': animate, 'loaded': loaded}">
</template>

<script>
    import ImageLoader from "../../mixins/ImageLoader";

    export default {
        name: "ImgImageLoader",

        mixins: [
            ImageLoader
        ],
    }
</script>

<style lang="scss" scoped>
    .image-loader{
        opacity: 0;
    }

    .image-loader.loaded {
        opacity: 1;
    }

    .image-loader.animate {
        transition: opacity .772s;
        transform: translate3d(0, 0 ,0);
        overflow: hidden;
    }
</style>
