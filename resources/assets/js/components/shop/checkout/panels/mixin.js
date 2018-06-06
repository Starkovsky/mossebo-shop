import { mapState } from 'vuex'

export default {
    computed: {
        ... mapState({
            steps: state => state.checkout.steps,
        }),
    }
}
