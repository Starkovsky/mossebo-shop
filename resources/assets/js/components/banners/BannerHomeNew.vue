<template>
    <div>
        <div class="banner">
            <div class="button">Смотреть</div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "BannerHomeNew"
    }
</script>

<style lang="scss" scoped>

    @import "../../../sass/variables/colors";
    @import "../../../sass/variables/variables";

    .banner {
        background: #aabed6;
        background: -moz-linear-gradient(45deg, #aabed6 0%, #bce3f0 100%);
        background: -webkit-linear-gradient(45deg, #aabed6 0%,#bce3f0 100%);
        background: linear-gradient(45deg, #aabed6 0%,#bce3f0 100%);
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#aabed6', endColorstr='#bce3f0',GradientType=1 );
        width: 100%;
        height: 430px;
        padding: 20px;
        margin: 15px 0;
        border-radius: 5px;
        box-shadow: $shadows-primary;
        .button {
            width: 100%;
            text-align: center;
            box-shadow: $shadows-primary;
            background: $color-ui;
            color: $color-text-primary;
            &:hover {
                box-shadow: $shadows-hover;
            }
        }
    }

</style>
