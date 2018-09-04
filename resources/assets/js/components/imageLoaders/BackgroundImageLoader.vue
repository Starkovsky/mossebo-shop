<template>
    <div :class="{'bg-image-loader': true, animate: animate, loaded: loaded, empty: empty}" :style="style">
        <slot></slot>
    </div>
</template>

<script>
    import mixin from "./mixin";

    export default {
        name: "BackgroundImageLoader",

        mixins: [
            mixin
        ],

        computed: {
            style() {
                if (this.image$) {
                    return {
                        'background-image': `url('${this.image$}')`
                    }
                }

                return ''
            }
        }
    }
</script>
