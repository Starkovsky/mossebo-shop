<template>
    <transition
        @before-leave="beforeLeave"
        @leave="leave"
        @after-leave="afterLeave"
    >
        <tr :class="{'cart-table__ghost': isGhost}">
            <td>
                <product-short-description
                    :product="product"
                    :small="small"
                ></product-short-description>
            </td>

            <td>
            <span class="cart-table__price">
                <formatted-price
                    class="cart-table__price"
                    :value="product.price"
                ></formatted-price>
            </span>
            </td>

            <td>
                <num-control
                    :number="product.quantity"
                    @update:number="changeQty"
                    :small="small"
                    :min="1"
                    :max="99"
                ></num-control>
            </td>

            <td>
            <span class="cart-table__price">
                <formatted-price
                    v-if="totalPrice"
                    :value="totalPrice"
                ></formatted-price>
            </span>
            </td>

            <td>
                <div class="cart-table__ghost-focus">
                    <button class="cart-trash-btn" @click="remove()">
                        <svg class="symbol-icon">
                            <use xlink:href="/assets/images/icons.svg#symbol-trash"></use>
                        </svg>
                    </button>
                </div>
            </td>
        </tr>
    </transition>

</template>

<script>
    import ProductMixin from './mixin'

    export default {
        name: "CartProductRow",

        mixins: [
            ProductMixin
        ],

        methods: {
            beforeLeave(el) {
                let plugEl = document.createElement('tr')
                let tdEl = plugEl.insertCell(0)

                tdEl.colSpan = el.cells.length
                tdEl.style.backgroundColor = '#fafbfc'
                tdEl.style.height = el.scrollHeight + 'px'
                tdEl.style.padding = '0'
                tdEl.style.position = 'relative'
                tdEl.style.overflow = 'hidden'
                tdEl.style.transition = 'height 300ms ease-in'
                tdEl.style.transform = 'translate3d(0, 0, 0)'
                tdEl.style.willChange = 'transform'

                el.style.position = 'absolute'
                el.style.width = '100%'
                el.style.left = '0'
                el.style.top = '50%'
                el.style.zIndex = '1'
                el.style.overflow = 'hidden'
                el.style.transform = 'translate3d(0, -50%, 0)'
                el.style.transition = 'all 300ms'
                el.style.willChange = 'transform, opacity'

                plugEl.appendChild(tdEl)
                el.parentNode.insertBefore(plugEl, el.nextSibling)
                tdEl.appendChild(el)


                this.plugEl = plugEl
                this.tdEl = tdEl
            },

            leave(el, done) {
                let tdEl = this.tdEl

                el.classList.add('block-ui')

                setTimeout(() => {
                    let handler = (e) => {
                        if (tdEl.isEqualNode(e.target)) {
                            done()
                            tdEl.removeEventListener('transitionend', handler)
                        }
                    }

                    tdEl.addEventListener('transitionend', handler, { passive: true })

                    el.style.transform = 'translate3d(0, -50%, 0) scale(0.9)'
                    el.style.opacity = '0.2'
                    tdEl.style.height = '0px'
                }, 0)
            },

            afterLeave() {
                this.plugEl.parentElement.removeChild(this.plugEl)
                this.plugEl = undefined
                this.tdEl = undefined
            }
        }
    }
</script>
