<script>

    import VueSlider from 'vue-slider-component';

    // Добавлены event клика по слайдеру
    VueSlider.methods.wrapClick = function(e) {
        if (this.isDisabled || !this.clickable || this.processFlag) return false
        let pos = this.getPos(e)
        if (this.isRange) {
            this.currentSlider = pos > ((this.position[1] - this.position[0]) / 2 + this.position[0]) ? 1 : 0
        }
        this.setValueOnPos(pos)
        this.$emit('click', this)
    }

    export default {
        name: "CatalogFilterPrice",

        components: {
            VueSlider
        },

        props: [
            'name',
            'prices'
        ],

        // todo: допилить

        data () {
            return {
                priceFilter: {
                    value: [... this.prices],
                    width: 'calc(100% - 30px)',
                    height: 5,
                    dotSize: 15,
                    min: this.prices[0],
                    max: this.prices[1],
                    interval: 1,
                    disabled: false,
                    show: true,
                    formatter: "{value} ₽",
                    tooltip: 'always',
                    piecewise: false,
                    // processDragable: true,
                    style: {
                        "marginTop": "30px",
                        "marginBottom": "0px",
                        "marginLeft": "auto",
                        "marginRight": "auto"
                    },
                    bgStyle: {
                        "backgroundColor": "#b4b4b4",
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
                        "backgroundColor": "transparent"
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

                filterRange: [... this.prices],
                availableRange: [... this.prices],
                cachedRange: [... this.prices],
                manualRange: [... this.prices],
                activePrices$: false
            }
        },


        methods: {
            checkProduct(product = {}) {
                let price = parseInt(product.price)

                if (price < parseInt(this.filterRange[0])) {
                    return false
                }

                if (price > parseInt(this.filterRange[1])) {
                    return false
                }

                return true
            },

            prepareActiveOptions(product) {
                if (! this.activePrices$) {
                    this.activePrices$ = [
                        product.price,
                        product.price
                    ]
                }
                else {
                    if (product.price < this.activePrices$[0]) {
                        this.activePrices$[0] = product.price
                    }
                    else if (product.price > this.activePrices$[1]) {
                        this.activePrices$[1] = product.price
                    }
                }
            },

            applyActiveOptions(filterName) {
                let prices = this.activePrices$ ? this.activePrices$ : this.prices

                this.availableRange = [... prices]

                if (filterName !== this.name) {
                    this.priceFilter.value = [
                        Math.max(prices[0], this.manualRange[0]),
                        Math.min(prices[1], this.manualRange[1]),
                    ]
                }

                this.activePrices$ = false
            },

            clear() {
                this.priceFilter.value = [... this.prices]
                this.filterRange = [... this.prices]
                this.cachedRange = [... this.prices]
                this.manualRange = [... this.prices]
                this.availableRange = [... this.prices]
            },

            inputChange() {
                let min = this.$refs.minPrice.value
                let max = this.$refs.maxPrice.value

                min = Math.max(this.priceFilter.min, min)
                min = Math.min(this.priceFilter.max, min)

                max = Math.min(this.priceFilter.max, max)
                max = Math.max(this.priceFilter.min, max)

                this.setPriceRange([min, max])
            },

            sliderValueChanged() {
                this.setPriceRange(this.priceFilter.value)
            },

            setPriceRange(prices) {
                if (this.cachedRange[0] !== prices[0] || this.cachedRange[1] !== prices[1]) {
                    this.cachedRange = [... prices]

                    this.manualRange = [... prices]

                    this.priceFilter.value = [... prices]

                    this.filterRange = [
                        Math.min(prices[0], this.manualRange[0]),
                        Math.max(prices[1], this.manualRange[1]),
                    ]

                    this.$root.$emit('filterChanged', this.name)
                }
            },

            getPercent(value) {
                return (value / this.diff * 100).toFixed(4)
            },

            isDirty() {
                return ! _.isEqual(this.priceFilter.value, this.prices)
            },
        },

        computed: {
            diff() {
                return this.prices[1] - this.prices[0]
            },

            emptyLeftStyle() {
                return {
                    left: '0',
                    width: this.getPercent(this.priceFilter.value[0] - this.prices[0]) + '%'
                }
            },

            emptyRightStyle() {
                return {
                    right: '0',
                    width: this.getPercent(this.prices[1] - this.priceFilter.value[1]) + '%'
                }
            },

            availableStyle() {
                let leftPercent = this.getPercent(this.availableRange[0] - this.prices[0])
                let rightPercent = this.getPercent(this.prices[1] - this.availableRange[1])

                return {
                    left: `calc(${leftPercent}% - 1px)`,
                    right: `calc(${rightPercent}% - 1px)`,
                }
            }
        }
    }
</script>

<template>
    <div>
        <a
            class="filter-name"
            data-toggle="collapse"
            href="#filerCollapsePrice"
            role="button"
            aria-expanded="true"
            aria-controls="filerCollapsePrice" >

            Цена
            <svg class="symbol-icon symbol-keyboard-down">
                <use xlink:href="/assets/images/icons.svg#symbol-keyboard-down"></use>
            </svg>
        </a>

        <div class="filter-desc collapse multi-collapse show" :id="'filerCollapsePrice'">
            <div class="prices-slider">
                <vue-slider
                    v-bind="priceFilter"
                    v-model="priceFilter.value"
                    @drag-end="sliderValueChanged"
                    @click="sliderValueChanged" />

                <div class="prices-slider__group">
                    <input ref="minPrice" type="number" :value="priceFilter.value[0]" @change="inputChange">
                    <div> &#8212; </div>
                    <input ref="maxPrice" type="number" :value="priceFilter.value[1]" @change="inputChange">
                </div>

                <div class="prices-slider__tube">
                    <div :style="emptyLeftStyle" class="prices-slider__empty"></div>
                    <div :style="emptyRightStyle" class="prices-slider__empty"></div>
                    <div :style="availableStyle" class="prices-slider__available-process"></div>
                </div>
            </div>

        </div>
    </div>
</template>

<style lang="scss" scoped>

    @import "../../../../../sass/variables/colors";

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

    .prices-slider {
        position: relative;

        &__group {
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

        &__tube {
            position: absolute;
            height: 5px;
            top: 7.5px;
            left: 22.5px;
            right: 22.5px;
            z-index: 1;
            overflow: hidden;
            border-radius: 15px;
        }

        &__available-process {
            background-color: $color-primary;
            position: absolute;
            height: 100%;
            top: 0;
            transform: translate3d(0,0,0);
            z-index: 1;
        }

        &__empty {
            background-color: rgba(255, 255, 255, .5);
            position: absolute;
            height: 100%;
            top: 0;
            transform: translate3d(0,0,0);
            z-index: 2;
        }
    }
</style>
