<template>
    <div>
        <div class="banner">
            <div class="image">
                <div class="img"
                     style="background-image: url(/assets/images/tmp/banner_new.png);"
                >
                </div>
            </div>
            <div class="title">Дизайн интерьера  от Mossebo</div>
            <a class="button" href="https://mossebo.studio/" target="_blank">Заказать</a>
        </div>
    </div>
</template>

<script>
    export default {
        name: "BannerHomeNew",
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
        height: 420px;
        padding: 20px;
        margin: 15px 0;
        border-radius: 5px;
        box-shadow: $shadows-primary;
        .image {
            position: relative;
            width: calc(100% + 40px);
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
                background-position: center left;
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
