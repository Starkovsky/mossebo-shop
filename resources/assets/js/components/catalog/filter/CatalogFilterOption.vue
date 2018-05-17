<script>
    export default {
        name: "CatalogFilterOption",

        props: {
            title: String,

            checked: {
                type: Boolean,
                default: false,
            },

            disabled: {
                type: Boolean,
                default: false,
            },
        },

        render: function (createElement) {
            return createElement(
                'label',
                {
                    class: {
                        'filter-label': true,
                        'disabled': this.disabled
                    },

                    on: {
                        click: (e) => {
                            e.preventDefault()
                            e.stopPropagation()

                            if (!this.disabled) {
                                this.$emit('click')
                            }
                        }
                    }
                },
                [
                    createElement(
                        'input',
                        {
                            attrs: {
                                type: 'checkbox',
                                checked: this.checked,
                                disabled: this.disabled
                            },
                        }
                    ),

                    createElement('span', {class: 'checkmark'}),

                    createElement(
                        'span',
                        {
                            class: 'value'
                        },
                        [this.title]
                    )
                ]
            )
        },
    }
</script>

<style lang="scss" scoped>
    @import "../../../../sass/variables/colors";

    .filter-label {
        display: block;
        position: relative;
        color: $color-text-primary;
        font-size: 13px;
        margin-bottom: 12px;
        padding-left: 35px;
        cursor: pointer;
        user-select: none;

        input {
            display: none;

            &:checked ~ .checkmark {
                background-color: $color-primary !important;
                border: 2px solid $color-primary !important;

                &:after {
                    display: block;
                }
            }
        }

        &:hover input ~ .checkmark {
            background-color: $color-border;
        }

        .checkmark:after {
            left: 5px;
            top: 2px;
            width: 6px;
            height: 10px;
            border: solid white;
            border-width: 0 3px 3px 0;
            transform: rotate(45deg);
        }

        &.disabled {
            cursor: not-allowed;

            & input ~ .checkmark {
                background-color: $color-border;
            }

            & .checkmark,
            & .value {
                opacity: .5;
            }
        }


    }

    .checkmark {
        position: absolute;
        top: 0;
        left: 0;
        height: 20px;
        width: 20px;
        background-color: $color-ui;
        border: 2px solid $color-border;
        border-radius: 2px;
        box-sizing: border-box;

        &:after {
            content: "";
            position: absolute;
            display: none;
        }
    }
</style>
