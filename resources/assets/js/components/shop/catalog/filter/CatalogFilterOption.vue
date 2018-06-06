<script>
    export default {
        name: "CatalogFilterOption",

        props: {
            id: null,

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
                        ['filter-label--' + this.id]: true,
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
