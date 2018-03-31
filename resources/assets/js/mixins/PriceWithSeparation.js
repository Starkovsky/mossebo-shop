
export default  {
    methods: {
        PriceWithSeparation: function (value) {
            return value.replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 ');
        },
    },
}
