<template>
    <product-card-mobile
        v-if="type === 'mobile'"
        :product="product$"
        :no-image-loading="noImageLoading"
        class="product-card-mobile--promo"
    ></product-card-mobile>

    <product-card-long
        v-else-if="type === 'long'"
        :product="product$"
        :no-image-loading="noImageLoading"
        class="product-card-long--promo"
    ></product-card-long>

    <product-card
        v-else
        :product="product$"
        :no-image-loading="noImageLoading"
        class="product-card--promo"
    ></product-card>
</template>

<script>
    import ProductCard from './ProductCard'
    import ProductCardLong from './ProductCardLong'
    import ProductCardMobile from './ProductCardMobile'
    import Core from '../../../../../scripts/core'

    import { parseTime } from '../../../../../scripts/core/time'

    export default {
        name: "ProductCardSale",

        components: {
            ProductCard,
            ProductCardLong,
            ProductCardMobile
        },

        props: {
            type: null,
            product: null,
            noImageLoading: null,
        },

        data() {
            return {
                startTime: null,
                elapsed: 0,
                stopped: false,
                timeLeft: this.product.sale.remainedTime(),
                start: null,
                badges: []
            }
        },

        created() {
            this.updateBadges()
            this.startTime = performance.now()
        },

        mounted() {
            this.$nextTick(() => {
                this.startTimer()
            })
        },

        beforeDestroy() {
            this.stopped = true
        },

        methods: {
            setImage(id) {
                this.image = this.previews.find(image => image.id === id)
            },

            checkSize() {
                if (this.$el.clientWidth > 485) {
                    if (this.isSmall) {
                        this.isSmall = false
                    }
                }
                else {
                    if (! this.isSmall) {
                        this.isSmall = true
                    }
                }
            },

            startTimer() {
                this.start = new Date().getTime()

                let animate = () => {
                    let elapsed = (new Date().getTime() - this.start) / 1000

                    if (elapsed - this.elapsed > 0.1) {
                        this.elapsed = elapsed
                        this.timeLeft = this.product.sale.remainedTime()

                        if (this.timeLeft <= 0) {
                            this.$emit('sale-time-end')
                        }

                        this.updateBadges()
                    }

                    if (! this.stopped && this.timeLeft > 0) {
                        requestAnimationFrame(animate)
                    }
                }

                requestAnimationFrame(animate)
            },

            updateBadges() {
                let badges = [
                    {
                        id: 'discount',
                        color: '#FF1B51',
                        text: this.discountPercent
                    }
                ]

                if (this.timeLeftShort) {
                    badges.push({
                        id: 'timer',
                        modif: 'timer',
                        color: '#323F4C',
                        icon: 'symbol-clock-alarm',
                        title: 'Акция закончится через',
                        text: this.timeLeftShort
                    })
                }

                if (this.badges.length !== badges.length) {
                    this.badges = badges
                }
                else if (this.badges.length === 2 && this.badges[1].text !== badges[1].text) {
                    this.badges = badges
                }
            },
        },

        computed: {
            previews() {
                if (! (this.product && this.product.previews && this.product.previews.length)) return false

                return this.product.previews.slice(0, 3)
            },

            maxPrice() {
                return this.product.old_price ? this.product.old_price : this.product.price
            },

            minPrice() {
                return this.product.sale.getPrice()
            },

            discountPercent() {
                let discount = (this.maxPrice - this.minPrice) / this.maxPrice * 100

                return '-&thinsp;' + discount.toFixed(0) + '&thinsp;%'
            },

            timeLeftShort() {
                if (this.timeLeft <= 0) {
                    return false
                }

                let result = parseTime(this.timeLeft)

                if (result.days > 0) {
                    return result.days + ' ' + Core.translate('days.short')
                }

                if (result.hours > 0) {
                    return result.hours + ' ' + Core.translate('hours.short')
                }

                if (result.minutes > 0) {
                    return result.minutes + ' ' + Core.translate('minutes.short')
                }

                if (result.seconds > 0) {
                    return result.seconds + ' ' + Core.translate('seconds.short')
                }
            },

            product$() {
                return {
                    ... this.product,
                    price: this.minPrice,
                    old_price: this.maxPrice,
                    previews: this.previews,
                    badges: this.badges
                }
            }
        }
    }
</script>
