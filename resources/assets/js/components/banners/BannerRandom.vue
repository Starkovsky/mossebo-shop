<script>
    import bannersData from './banners.json'
    import Banner from './Banner'

    export default {
        name: "BannerRandom",

        props: {
            isLong: {
                type: Boolean,
                default: false,
            }
        },

        components: {
            Banner
        },

        data() {
            return {
                data: bannersData[_.random(0, bannersData.length - 1)]
            }
        },

        render: function (createElement) {
            let params = {
                props: this.data
            }

            if (this.isLong) {
                params.class = 'banner--long'
            }

            return createElement(
                'banner',
                params
            )
        }
    }
</script>
