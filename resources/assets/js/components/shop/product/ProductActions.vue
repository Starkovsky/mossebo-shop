<template>
    <div class="product-actions">
        <div class="product-actions__container">
            <div class="product-actions__item">
                <a href="javascript:void(0);"
                   data-toggle="tooltip"
                   data-placement="top"
                   title="Данная функция в разработке"
                >
                    <svg class="symbol-icon symbol-wishlist">
                        <use xlink:href="/assets/images/icons.svg#symbol-wishlist"></use>
                    </svg>
                </a>
            </div>

            <div class="product-actions__item">
                <a href="javascript:void(0);"
                   data-toggle="tooltip"
                   data-placement="top"
                   title="Данная функция в разработке"
                >
                    <svg class="symbol-icon symbol-heart">
                        <use xlink:href="/assets/images/icons.svg#symbol-heart"></use>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ProductActions",

        mounted: function () {
            $('[data-toggle="tooltip"]').tooltip();
        },
    }
</script>
