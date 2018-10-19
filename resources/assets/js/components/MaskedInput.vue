<template>
    <masked-input-base
        :value="value"
        :mask="mask"
        :guide="guide"
        :placeholder-char="placeholderChar"
        :keep-char-positions="keepCharPositions"
        :pipe="pipe"
        :show-mask="showMask"
        @input="input"
        @focus="maskFieldFocus"
        @click="maskFieldFocus"
        @keydown="maskFieldFocus"
    ></masked-input-base>
</template>

<script>
    import MaskedInputBase from 'vue-text-mask'

    export default {
        name: "MaskedInput",

        props: [
            'value',
            'mask',
            'guide',
            'placeholderChar',
            'keepCharPositions',
            'pipe',
            'showMask'
        ],

        components: {
            MaskedInputBase,
        },

        methods: {
            input() {
                this.$emit.apply(this, ['input', ... arguments])
            },

            maskFieldFocus(e) {
                let diff = function (arr, arr2) {
                    for (let i = 0; i < arr.length; i++) {
                        if (arr[i] !== arr2[i]) {
                            return arr.length - i
                        }
                    }
                }

                this.$nextTick(() => {
                    let value = e.target.value.split('').reverse()
                    let placeholder = e.target.placeholder.split('').reverse()

                    let pos = diff(value, placeholder)

                    if (pos < e.target.selectionStart) {
                        setCaretPosition(e.target, pos)
                    }
                })
            }
        },
    }
</script>
