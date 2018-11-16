<template>
    <div>
        <slot></slot>
    </div>

</template>

<script>
    import Fixer from '../scripts/Fixer'

    export default {
        name: 'Fixer',

        data() {
            return {
                fixer: null
            }
        },

        mounted() {
            this.fixer = Fixer(this.$el)
            this.fixer.containerEl.classList.add(this.$el.className)
            this.$el.className = ''

            this.fixer.on('fix', e => this.$emit('fix', e))
            this.fixer.on('unfix', e => this.$emit('unfix', e))
        },

        beforeDestroy() {
            this.fixer.destroy()
            this.fixer = null

            this.$root.$off('resize', this.setWidth)
        },
    }
</script>
