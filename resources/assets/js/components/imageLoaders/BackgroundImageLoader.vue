<template>
    <div :class="{'bg-image-loader': true, 'loading': loaded}" :style="{ 'background-image': `url(${image$})` }"></div>
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
    /*.bg-image-loader.loading {*/
        /*transition: background-image .772s;*/
        /*transform: translate3d(0, 0 ,0);*/
        /*overflow: hidden;*/
    /*}*/
</style>
