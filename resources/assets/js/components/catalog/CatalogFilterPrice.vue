<template>
    <div>
        <a
            class="filter-name"
            data-toggle="collapse"
            :href="'#filerCollapsePrice'"
            role="button"
            aria-expanded="true"
            :aria-controls="'filerCollapsePrice'"
        >
            Цена
            <svg class="symbol-icon symbol-keyboard-down">
                <use xlink:href="/assets/images/icons.svg#symbol-keyboard-down"></use>
            </svg>
        </a>
        <div class="filter-desc collapse multi-collapse show" :id="'filerCollapsePrice'">

            <vue-slider v-bind="PriceFilter" v-model="PriceFilter.value"></vue-slider>
            <div class="price-group">
                <input type="number" v-bind:value="PriceFilter.value[0]">
                <div> &#8212; </div>
                <input type="number" v-bind:value="PriceFilter.value[1]">
            </div>
        </div>
    </div>
</template>

<script>

    import vueSlider from 'vue-slider-component';

    export default {
        name: "CatalogFilterPrice",
        components: {
            vueSlider
        },
        data () {
            return {
                PriceFilter: {
                    value: ['5000', '120000'],
                    width: '90%',
                    height: 5,
                    dotSize: 15,
                    min: 5000,
                    max: 120000,
                    interval: 10,
                    disabled: false,
                    show: true,
                    formatter: "{value} ₽",
                    tooltip: 'always',
                    piecewise: false,
                    style: {
                        "marginTop": "30px",
                        "marginBottom": "0px",
                        "marginLeft": "auto",
                        "marginRight": "auto"
                    },
                    bgStyle: {
                        "backgroundColor": "#ecedf3",
                    },
                    sliderStyle: [
                        {
                            "backgroundColor": "#fcc600",
                            "boxShadow": "none"
                        },
                        {
                            "backgroundColor": "#fcc600",
                            "boxShadow": "none"
                        }
                    ],
                    tooltipStyle: [
                        {
                            "backgroundColor": "#ecedf3",
                            "borderColor": "#ecedf3",
                            "fontSize": "12px",
                            "color": "#969CA3",
                            "paddingLeft": "6px",
                            "paddingRight": "6px",
                            "borderRadius":"3px"
                        },
                        {
                            "backgroundColor": "#ecedf3",
                            "borderColor": "#ecedf3",
                            "fontSize": "12px",
                            "color": "#969CA3",
                            "boxShadows": "none",
                            "paddingLeft": "6px",
                            "paddingRight": "6px",
                            "borderRadius":"3px"
                        }
                    ],
                    processStyle: {
                        "backgroundColor": "#fcc600"
                    },
                    // data: [
                    //     '8560',
                    //     '8960',
                    //     '1060',
                    //     '1160',
                    //     '1260',
                    //     '1360',
                    //     '1460',
                    //     '1560',
                    //     '1660',
                    //     '1760',
                    //     '1860',
                    //     '1960',
                    //     '108700'
                    // ]
                },
            }
        },
    }
</script>

<style lang="scss" scoped>

    @import "../../../sass/variables/colors";

    .filter-name {
        display: block;
        position: relative;
        padding: 20px;
        color: $color-text-primary;
        &:hover {
            text-decoration: none;
            .symbol-icon {
                fill: $color-text-primary;
            }
        }
        .symbol-icon {
            float: right;
        }
        &[aria-expanded="false"] {
            .symbol-icon {
                transform: rotate(0deg);
            }
        }
        &[aria-expanded="true"] {
            .symbol-icon {
                transform: rotate(180deg);
            }
        }
    }
    .filter-desc {
        padding: 0 20px 20px;
    }

    .price-group {
        margin-top: 15px;
        position: relative;
        display: flex;
        justify-content: space-between;
        align-items: center;
        input[type="number"] {
            font-size: 14px;
            color: $color-text-primary;
            line-height: normal;
            padding: 6px 5px;
            text-align: center;
            display: inline-block;
            width: 90px;
            box-sizing: border-box;
            border: 1px solid $color-border;
            border-radius: 3px;
        }
    }

</style>
