<template>
    <div class="cabinet-reviews">
        <reviews
            :url="url"
            :hide-button="true"
        ></reviews>
    </div>
</template>

<script>
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
    }
</script>
