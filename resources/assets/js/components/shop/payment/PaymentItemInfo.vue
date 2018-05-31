<template>
    <div class="payment-item-info" v-if="paymentData">
        <template v-if="imageExist">
            <background-image-loader
                :image="paymentData.image.src"
                :retinaImage="paymentData.image.srcset"
                class="payment-item-info__image"
            ></background-image-loader>
        </template>

        <template v-else>
            <div class="payment-item-info__title">
                {{ paymentTitle }}
            </div>
        </template>
    </div>
</template>

<script>
    import { mapState } from 'vuex'

    import BackgroundImageLoader from '../../imageLoaders/BackgroundImageLoader'

    export default {
        name: "PaymentItemInfo",

        props: {
            'paymentType': String
        },

        components: {
            BackgroundImageLoader
        },

        methods: {
            isActive(type) {
                return this.activeType === type
            },

            setType(type) {
                this.$store.dispatch('payments/setType', type)
            }
        },

        computed: {
            ... mapState({
                paymentData({payments}) {
                    return payments.types[this.paymentType]
                },
            }),

            imageExist() {
                return 'image' in this.paymentData
            },

            paymentTitle() {
                if (this.paymentData.infoTitle) {
                    return this.paymentData.infoTitle
                }

                return this.paymentData.title
            }
        }
    }
</script>
