import CartStore from './cart'
import CheckoutStore from './checkout'
import ShippingStore from './shipping'
import PaymentsStore from './payments'

export default {
    modules: {
        cart: CartStore,
        checkout: CheckoutStore,
        shipping: ShippingStore,
        payments: PaymentsStore
    }
}
