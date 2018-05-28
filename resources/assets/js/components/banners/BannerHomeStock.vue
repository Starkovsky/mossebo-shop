<template>
    <div>
        <div class="banner">
            <div class="image">
                <div class="img"
                     style="background-image: url(/assets/images/tmp/banner_action.png);"
                >
                </div>
            </div>
            <div class="title">Стань поставщиком для Mossebo.Market</div>
            <a class="button" href="https://mossebo.studio/dlya-postavshhikov/" target="_blank">Смотреть</a>
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
        height: 420px;
        padding: 20px;
        margin: 15px 0;
        border-radius: 5px;
        box-shadow: $shadows-primary;
        .image {
            position: relative;
            width: calc(100% + 40px);
            max-height: 250px;
            margin-left: -20px;
            margin-right: -20px;
            &:before {
                content: "";
                display: block;
                padding-top: 100%;
                transition: $transition-primary;
                position: relative;
            }
            .img {
                position: absolute;
                top: 0;
                left: 0;
                bottom: 0;
                right: 0;
                background-repeat: no-repeat;
                background-position: center center;
            }
        }
        .title {
            font-size: 18px;
            color: $color-ui;
            text-align: center;
            margin-bottom: 25px;
        }
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
