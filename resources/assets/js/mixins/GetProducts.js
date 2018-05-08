
import axios from 'axios'

export default  {
    methods: {
        GetProductsJSON($url) {
            var self = this;
            axios.get($url)
                .then(function (response) {
                    self.$data.Products = response.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
        }
    }
}
