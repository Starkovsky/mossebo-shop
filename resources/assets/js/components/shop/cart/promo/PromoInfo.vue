<template>
    <div class="promo-info">
        <div v-if="accepted" class="promo-info__status promo-info__status--success">
            промокод применен
        </div>

        <div v-else class="promo-info__status promo-info__status--error">
            не выполнены условия
        </div>

        <div class="promo-info__title">
            {{ title }}
        </div>

        <div class="promo-info__text">
            {{ description }}
        </div>
    </div>
</template>

<script>
    export default {
        name: 'promo-info',

        props: [
            'accepted',
            'title',
            'description'
        ]
    }
</script>
