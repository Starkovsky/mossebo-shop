<template>
    <div :class="{'bg-image-loader': true, 'animate': animate, 'loaded': loaded}" :style="{ 'background-image': `url(${image$})` }"></div>
</template>

<script>
    import mixin from "./mixin";

    export default {
        name: "BackgroundImageLoader",

        mixins: [
            mixin
        ],
    }
</script>
