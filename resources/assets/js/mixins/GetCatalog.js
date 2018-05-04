
import axios from 'axios'

export default  {
    methods: {
        GetCatalogJSON($url) {
            var self = this;
            axios.get($url)
                .then(function (response) {
                    self.$data.Catalog.Products = response.data.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
        }
    }
}
