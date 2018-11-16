<template>
    <div class="cabinet-order-panel">
        <div class="cabinet-order-panel__left">
            <div class="cabinet-order-panel__num">
                {{ $root.translate('Order №') }}&nbsp;{{ id }}
            </div>

            <div v-if="status" class="cabinet-order-panel__status">
                <span class="cabinet-order-panel__status-label">
                    {{ $root.translate('Status') }}:
                </span>

                <span :style="{color: status.color || false}">
                    {{ status.name }}
                </span>
            </div>
        </div>

        <div class="cabinet-order-panel__right">
            <div class="cabinet-order-panel__button">
                <div class="cabinet-order-button">
                    <svg class="cabinet-order-button__icon">
                        <use xlink:href="/assets/images/icons.svg#symbol-keyboard-down"></use>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
    export default {
        name: 'CabinetOrderPanel',

        props: [
            'id',
            'status'
        ],
    }
</script>
