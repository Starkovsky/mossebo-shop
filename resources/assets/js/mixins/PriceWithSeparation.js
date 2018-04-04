
export default  {
    methods: {
        PriceWithSeparation: function (value) {
            value = value / 100;
            return value.toLocaleString();
        },
    },
}
