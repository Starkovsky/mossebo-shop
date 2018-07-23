<script>
    export default {
        name: "CatalogFilterOption",

        props: {
            id: null,

            title: String,

            count: {
                type: Number,
                default: 0
            },

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
                        'form-checkbox': true,
                        'filter-option': true,
                        ['filter-option--' + this.id]: true,
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
                            class: 'form-checkbox__input',
                            attrs: {
                                type: 'checkbox',
                                checked: this.checked,
                                disabled: this.disabled
                            },
                        }
                    ),

                    createElement('span', {class: 'form-checkbox__checkmark'}),

                    createElement(
                        'span',
                        {
                            class: 'form-checkbox__label'
                        },
                        [
                            createElement(
                                'span',
                                {
                                    class: 'filter-option__count' + (this.count === 0 ? ' filter-option__count--hidden' : '')
                                },
                                [this.count]
                            ),
                            this.title,
                        ]
                    )
                ]
            )
        },
    }
</script>
