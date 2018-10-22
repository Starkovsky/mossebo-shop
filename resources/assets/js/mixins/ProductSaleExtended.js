import Product from '../scripts/shop/Product'
import Core from '../scripts/core'
import { parseTime } from '../scripts/core/time'

export default {
    props: [
        'product'
    ],

    data() {
        return {
            preparedProduct: {},
            productPrice: 0,
            badges: []
        }
    },

    watch: {
        'preparedProduct.sale.timeLeft': function(value) {
            this.updateBadges()
        }
    },

    created() {
        if (this.product instanceof Product) {
            this.preparedProduct = this.product
        }
        else {
            this.preparedProduct = new Product(this.product)
        }

        this.productPrice = this.preparedProduct.getPrice()

        this.updateBadges()

        if (this.preparedProduct.hasSale()) {
            this.$watch('preparedProduct.sale.status', () => {
                this.$nextTick(() => {
                    this.productPrice = this.preparedProduct.getPrice()
                })
            })
        }
    },

    methods: {
        updateBadges() {
            let badges = []

            if (this.timeLeftShort) {
                badges.push({
                    id: 'discount',
                        color: '#FF1B51',
                    text: this.discountPercent
                })

                badges.push({
                    id: 'timer',
                    modif: 'timer',
                    color: '#323F4C',
                    icon: 'symbol-clock-alarm',
                    title: 'Акция закончится через',
                    text: this.timeLeftShort
                })
            }

            this.setBadges(badges)
        },

        setBadges(badges) {
            if (this.preparedProduct.badges) {
                badges = [
                    ... badges,
                    ... this.preparedProduct.badges
                ]
            }

            this.badges = badges
        },

        formatBadgeNum(num) {
            return num.toString()
                .split('')
                .map(n => '<span class="badge-num">' + n + '</span>')
                .join('')
        }
    },

    computed: {
        minPrice() {
            return this.preparedProduct.getMinPrice()
        },

        maxPrice() {
            return this.preparedProduct.getMaxPrice()
        },

        discountValue() {
            return this.preparedProduct.getDiscount()
        },

        discountPercent() {
            let discount = this.preparedProduct.getDiscountPercent()

            return '-&thinsp;' + discount.toFixed(0) + '&thinsp;%'
        },

        timeLeftShort() {
            let timeLeft = this.preparedProduct.hasSale() ? this.preparedProduct.sale.timeLeft : 0

            if (timeLeft <= 0) {
                return false
            }

            let result = parseTime(timeLeft)

            if (result.days > 0) {
                return this.formatBadgeNum(result.days) + ' ' + Core.translate('days.short')
            }

            if (result.hours > 0) {
                return this.formatBadgeNum(result.hours) + ' ' + Core.translate('hours.short')
            }

            if (result.minutes > 0) {
                return this.formatBadgeNum(result.minutes) + ' ' + Core.translate('minutes.short')
            }

            if (result.seconds > 0) {
                return this.formatBadgeNum(result.seconds) + ' ' + Core.translate('seconds.short')
            }
        },

        product$() {
            return {
                ... this.preparedProduct,
                price: this.minPrice,
                old_price: this.maxPrice,
                badges: this.badges
            }
        }
    }
}
