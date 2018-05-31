<template>
    <img :src="image$" :class="{'image-loader': true, 'animate': animate, 'loaded': loaded}">
</template>

<script>
    import mixin from "./mixin";

    export default {
        name: "ImgImageLoader",

        mixins: [
            mixin
        ],
    }
</script>
