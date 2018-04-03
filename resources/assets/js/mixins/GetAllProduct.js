
import axios from 'axios'

export default  {
    methods: {
        GetAllProduct() {
            var self = this;
            axios.get('//admin.mossebo.market/api/products/all')
                .then(function (response) {
                    self.Products = response.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
        }
    }
}
