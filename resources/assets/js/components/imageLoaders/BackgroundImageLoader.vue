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
