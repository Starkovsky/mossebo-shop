export default {
    props: [
        'product'
    ],

    data() {
        return {
            productPrice: this.product.getPrice()
        }
    },

    created() {
        if (this.product.hasSale()) {
            this.$watch('product.sale.status', () => {
                this.$nextTick(() => {
                    this.productPrice = this.product.getPrice()
                })
            })
        }
    }
}
