import Core from '../scripts/core'

export default {
    methods: {
        prepareImage(imageUrl) {
            return Core.adminUrl(imageUrl)
        }
    }
}
