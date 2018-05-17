<template>
    <div :class="{'bg-image-loader': true, 'animate': animate, 'loaded': loaded}" :style="{ 'background-image': `url(${image$})` }"></div>
</template>

<script>
    import ImageLoader from "../../mixins/ImageLoader";

    export default {
        name: "BackgroundImageLoader",

        mixins: [
            ImageLoader
        ],
    }
</script>

<style lang="scss" scoped>
    .bg-image-loader{
        opacity: 0;
    }

    .bg-image-loader.loaded {
        opacity: 1;
    }

    .bg-image-loader.animate {
        transition: opacity .772s;
        transform: translate3d(0, 0 ,0);
        overflow: hidden;
    }
</style>
