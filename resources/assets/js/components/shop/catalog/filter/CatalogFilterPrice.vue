<script>
    import VueSlider from 'vue-slider-component'
    import CatalogFilterMixin from './CatalogFilterMixin'

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

        mixins: [
            CatalogFilterMixin
        ],

        data () {
            return {
                priceFilter: {
                    value: [... this.filter.pricesRange],
                    width: 'calc(100% - 30px)',
                    height: 5,
                    dotSize: 15,
                    min: this.filter.pricesRange[0],
                    max: this.filter.pricesRange[1],
                    interval: 1,
                    disabled: false,
                    show: true,
                    formatter: "{value} ₽",
                    tooltip: 'always',
                    piecewise: false,
                    // processDragable: true,
                    style: {
                        "marginTop": "20px",
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
                },

                // Предыдущая выбранная ценаю. Для того, чтобы не запускать процесс фильтрации при выборе той же цены.
                availableRange: [... this.filter.availableRange],
            }
        },

        methods: {
            onFilterChange() {
                this.availableRange    = [... this.filter.availableRange]
                this.priceFilter.value = [... this.filter.selectedRange]
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
                prices = [
                    Math.max(this.availableRange[0], prices[0]),
                    Math.min(this.availableRange[1], prices[1])
                ]

                if (prices[0] === this.filter.selectedRange[0] && prices[1] === this.filter.selectedRange[1]) {
                    this.priceFilter.value = prices
                    return
                }

                this.$store.dispatch('catalog/setFilterValue', ['prices', prices])
            },

            clear() {
                this.priceFilter.value = [... this.filter.pricesRange]
                this.availableRange    = [... this.filter.pricesRange]
            },

            getPercent(value) {
                return (value / this.diff * 100).toFixed(4)
            },
        },

        computed: {
            diff() {
                return this.filter.pricesRange[1] - this.filter.pricesRange[0]
            },

            emptyLeftStyle() {
                return {
                    left: '0',
                    width: this.getPercent(this.priceFilter.value[0] - this.filter.pricesRange[0]) + '%'
                }
            },

            emptyRightStyle() {
                return {
                    right: '0',
                    width: this.getPercent(this.filter.pricesRange[1] - this.priceFilter.value[1]) + '%'
                }
            },

            availableStyle() {
                let leftPercent = this.getPercent(this.availableRange[0] - this.filter.pricesRange[0])
                let rightPercent = this.getPercent(this.filter.pricesRange[1] - this.availableRange[1])

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
        <div :class="{'filter-name js-ht-filter': true, 'is-active': expanded}">
            <span class="filter-name__name">
                Цена
            </span>

            <svg class="filter-name__icon">
                <use xlink:href="/assets/images/icons.svg#symbol-keyboard-down"></use>
            </svg>
        </div>

        <div class="ht-container">
            <div class="ht-inner">
                <div class="filter-desc">
                    <div style="padding-top: 10px"></div>
                    <div class="prices-slider">
                        <vue-slider
                            v-bind="priceFilter"
                            v-model="priceFilter.value"
                            @drag-end="sliderValueChanged"
                            @click="sliderValueChanged" />

                        <div class="prices-slider__group">
                            <input
                                ref="minPrice" type="number"
                                :value="priceFilter.value[0]"
                                @change="inputChange"
                                class="prices-slider__input" >

                            <div class="prices-slider__separator">&#8212;</div>

                            <input
                                ref="maxPrice"
                                type="number"
                                :value="priceFilter.value[1]"
                                @change="inputChange"
                                class="prices-slider__input" >
                        </div>

                        <div class="prices-slider__tube">
                            <div :style="emptyLeftStyle" class="prices-slider__empty"></div>
                            <div :style="emptyRightStyle" class="prices-slider__empty"></div>
                            <div :style="availableStyle" class="prices-slider__available-process"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
