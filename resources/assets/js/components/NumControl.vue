<template>
    <div :class="{'num-control': true, 'num-control--small': small}">
        <button
            class="num-control__minus"
            @mousedown="minusEventHandle"
            @mouseup="numberFlowStop"
            @mouseout="numberFlowStop"
            style="z-index: 1"
        >
            <svg class="symbol-icon symbol-remove" style="z-index: -1">
                <use xlink:href="/assets/images/icons.svg#symbol-remove"></use>
            </svg>
        </button>

        <input
            type="text"
            class="num-control__input js-num-control-input"
            :value="number"
            @change="set"
            @keydown="handleInputArrows"
            @keyup="numberFlowStop"
            style="z-index: 1"
        >

        <button
            class="num-control__plus"
            @mousedown.stop="plusEventHandle"
            @mouseup.stop="numberFlowStop"
            @mouseout.stop="numberFlowStop"
            style="z-index: 1"
        >
            <svg class="symbol-icon symbol-add" style="z-index: -1">
                <use xlink:href="/assets/images/icons.svg#symbol-add"></use>
            </svg>
        </button>
    </div>
</template>

<script>
    import PendingLoader from '../scripts/PendingLoader'

    export default {
        name: "NumControl",

        props: {
            number: Number,
            small: Boolean,
            min: Number,
            max: Number,
        },

        data() {
            return {
                focusPendingHandler: false
            }
        },

        methods: {
            set(e) {
                this.updateNumber(e.target.value)
            },

            plus() {
                this.numberFlowStart(1)
            },

            minus() {
                this.numberFlowStart(-1)
            },

            plusEventHandle(e) {
                if (e.button === 0) {
                    return this.plus()
                }
            },

            minusEventHandle(e) {
                if (e.button === 0) {
                    return this.minus()
                }
            },

            handleInputArrows(e) {
                switch(e.keyCode) {
                    case 38:
                        this.plus()
                        break

                    case 40:
                        this.minus()
                        break
                }
            },

            numberFlowStart(augend) {
                let number = this.number + augend

                this.updateNumber(number)
                this.focusInput()

                clearTimeout(this.numberFlowTimeout)
                clearInterval(this.numberFlowInterval)

                this.numberFlowTimeout = setTimeout(() => {
                    this.numberFlowInterval = setInterval(() => {
                        number += augend
                        this.updateNumber(number)
                    }, 50)
                }, 300)
            },

            // todo: Событие срабатывает на вложенные элементы style="z-index: -1"

            numberFlowStop() {
                clearTimeout(this.numberFlowTimeout)
                clearInterval(this.numberFlowInterval)

                this.blurInput()
            },

            updateNumber(num) {
                if (typeof this.min !== 'undefined') {
                    num = Math.max(this.min, num)
                }

                if (typeof this.max !== 'undefined') {
                    num = Math.min(this.max, num)
                }

                if (this.number !== num) {
                    this.$emit('update:number', num)
                }
            },

            focusInput() {
                if (this.focusPendingHandler !== false) {
                    this.focusPendingHandler.cancel()
                }

                this.focusPendingHandler = new PendingLoader(300)
                this.getInputEl().classList.add('is-focused')
            },

            blurInput() {
                if (this.focusPendingHandler === false) return

                this.focusPendingHandler.finish(() => {
                    this.getInputEl().classList.remove('is-focused')
                    this.focusPendingHandler = false
                })
            },

            getInputEl() {
                return this.$el.querySelector('.js-num-control-input')
            }
        }
    }
</script>
