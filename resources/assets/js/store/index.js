import CartStore from './cart'
import CheckoutStore from './checkout'
import ShippingStore from './shipping'
import PaymentsStore from './payments'
import CatalogStore from './catalog'
import CabinetStore from './cabinet'
import ReviewsStore from './reviews'

export default {
    modules: {
        cart: CartStore,
        checkout: CheckoutStore,
        shipping: ShippingStore,
        payments: PaymentsStore,
        catalog: CatalogStore,
        cabinet: CabinetStore,
        reviews: ReviewsStore
    }
}
