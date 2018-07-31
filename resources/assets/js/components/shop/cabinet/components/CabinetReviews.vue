<template>
    <div class="cabinet-reviews">
        <template v-if="listEmpty">
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
    </div>
</template>

<script>
    import { mapState } from 'vuex'
    import Core from '../../../../scripts/core'
    import Reviews from '../../../reviews/Reviews'

    export default {
        name: "CabinetReviews",

        components: {
            Reviews
        },

        data() {
            return {
                url: Core.siteUrl('cabinet/reviews')
            }
        },

        computed: {
            ... mapState({
                listEmpty: state => state.reviews.list.reviews.length === 0
            })
        }
    }
</script>
