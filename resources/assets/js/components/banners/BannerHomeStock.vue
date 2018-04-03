<template>
    <div>
        <div class="banner">
            <div class="button">Смотреть</div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "BannerHomeStock"
    }
</script>

<style lang="scss" scoped>

    @import "../../../sass/variables/colors";
    @import "../../../sass/variables/variables";

    .banner {
        background: $color-primary;
        background: -moz-linear-gradient(45deg, $color-primary 0%, $color-primary-2 100%);
        background: -webkit-linear-gradient(45deg, $color-primary 0%,$color-primary-2 100%);
        background: linear-gradient(45deg, $color-primary 0%,$color-primary-2 100%);
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='$color-primary', endColorstr='$color-primary-2',GradientType=1 );
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
