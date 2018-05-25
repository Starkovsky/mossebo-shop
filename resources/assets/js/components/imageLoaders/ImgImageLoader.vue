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
