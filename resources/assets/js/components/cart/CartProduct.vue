<template>
    <tr :class="{'cart-table__ghost': isGhost}">
        <td>
            <img-image-loader :image="prepareImage(product.image.src)" :retina-image="prepareImage(product.image.srcset)" />
        </td>

        <td>
            <div class="product-short-description">
                <div class="product-short-description__category">
                    {{ product.category }}
                </div>
                <div class="product-short-description__title">
                    {{ product.name }}
                </div>
                <div class="product-short-description__attributes">
                    {{ product.attributes }}
                </div>
            </div>
        </td>

        <td>
            <formatted-price :price="product.price"></formatted-price>
        </td>

        <td>
            <div class="num-control">
                <div class="num-control__minus" @mousedown="minus" @mouseup="quantityFlowStop" @mouseout="quantityFlowStop">
                    <svg class="symbol-icon symbol-remove">
                        <use xlink:href="/assets/images/icons.svg#symbol-remove"></use>
                    </svg>
                </div>

                <input type="text" class="num-control__input" :value="product.quantity" @change="set" @keydown="handleInputArrows" @keyup="quantityFlowStop">

                <div class="num-control__plus" @mousedown="plus" @mouseup="quantityFlowStop" @mouseout="quantityFlowStop">
                    <svg class="symbol-icon symbol-add">
                        <use xlink:href="/assets/images/icons.svg#symbol-add"></use>
                    </svg>
                </div>
            </div>
        </td>

        <td>
            <formatted-price :price="totalPrice"></formatted-price>
        </td>

        <td>
            <button class="cart-table__remove" @click="remove()">
                <svg class="symbol-icon">
                    <use xlink:href="/assets/images/icons.svg#symbol-trash"></use>
                </svg>
            </button>
        </td>
    </tr>
</template>

<script>
    import FormattedPrice from '../../core/FormattedPrice'
    import ImgImageLoader from '../imageLoaders/ImgImageLoader'
    import ProductImagesHat from '../../mixins/ProductImagesHat'

    export default {
        name: "CartProduct",

        mixins: [
            ProductImagesHat
        ],

        components: {
            FormattedPrice,
            ImgImageLoader
        },

        props: {
            product: {
                type: Object,
            }
        },

        data() {
            return {
                /**
                 * интервал, нужный для обработки зажимания кнопок +/-
                 */
                quantityFlowInterval: null,
                /**
                 * таймаут, который увеличивает запускает интервал,
                 * чтобы при единичном клике не было изменения количества товаров на несколько шт.
                 */
                quantityFlowTimeout: null,
            }
        },

        methods: {
            set(e) {
                this.updateQuantity(e.target.value)
            },

            plus() {
                this.quantityFlowStart(1)
            },

            minus() {
                this.quantityFlowStart(-1)
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

            quantityFlowStart(augend) {
                let qty = this.product.quantity + augend

                this.updateQuantity(qty)

                clearTimeout(this.quantityFlowTimeout)
                clearInterval(this.quantityFlowInterval)

                this.quantityFlowTimeout = setTimeout(() => {
                    this.quantityFlowInterval = setInterval(() => {
                        qty += augend
                        this.updateQuantity(qty)
                    }, 50)
                }, 300)
            },

            quantityFlowStop() {
                clearTimeout(this.quantityFlowTimeout)
                clearInterval(this.quantityFlowInterval)
            },

            updateQuantity(qty) {
                qty = Math.min(Math.max(0, qty), 99)

                this.$emit('update:quantity', qty)
            },

            remove() {
                this.$emit('remove', this)
            }
        },

        computed: {
            totalPrice() {
                return Math.max(this.product.quantity, 1) * this.product.price
            },

            isGhost() {
                return this.product.quantity === 0
            },
        }
    }
</script>

<style scoped>

</style>
