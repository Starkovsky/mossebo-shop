<template>
    <div class="d-none">
        <slot></slot>
    </div>
</template>

<script>
    import SidePopupper from '../scripts/SidePopupper'

    export default {
        name: "SidePopup",

        data() {
            return {
                popup: null
            }
        },

        mounted() {
            this.popup = new SidePopupper(this.$el.firstChild)
        },

        methods: {
            open() {
                if (this.popup) {
                    this.$nextTick(() => {
                        this.popup.open()
                    })
                }
            }
        }
    }
</script>
