<template>
    <div class="cabinet-reviews">
        <loading :loading="loading">
            <template v-if="noReviews">
                <div class="cabinet-reviews__empty text-center">
                    {{ $root.translate('No reviews.') }}

                    <div class="cabinet-reviews__empty-btn mt-32">
                        <a :href="$root.catalogUrl" class="button button-primary">
                            {{ $root.translate('Shop now') }}
                        </a>
                    </div>
                </div>
            </template>

            <template v-else>
                <reviews
                    :url="url"
                    :hide-button="true"
                ></reviews>
            </template>
        </loading>
    </div>
</template>

<script>
    import { mapState } from 'vuex'
    import Core from '../../../../scripts/core'
    import Reviews from '../../../reviews/Reviews'
    import Loading from '../../../Loading'

    export default {
        name: "CabinetReviews",

        components: {
            Reviews,
            Loading
        },

        data() {
            return {
                url: Core.siteUrl('cabinet/reviews')
            }
        },

        created() {
            this.$store.dispatch('reviews/init')
        },

        computed: {
            ... mapState({
                listEmpty: state => state.reviews.list.reviews.length === 0,
                loading: state => state.reviews.list.loading,
                error: state => state.reviews.list.error,
            }),

            noReviews() {
                return this.listEmpty && !this.loading && !this.error
            }
        }
    }
</script>
