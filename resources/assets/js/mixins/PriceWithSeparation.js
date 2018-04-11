
// Преобразует цену
// '1054321' в '10 543,21'

export default  {
    methods: {
        PriceWithSeparation: function (value) {
            value = value / 100;
            return value.toLocaleString();
        },
    },
}
