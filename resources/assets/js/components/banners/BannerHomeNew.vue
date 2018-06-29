<template>
    <banner
        :id="data.id"
        :title="data.title"
        :button-text="data['button-text']"
        :link="data.link"
        :image="data.image"
        :gradient-from="data['gradient-from']"
        :gradient-to="data['gradient-to']"
    ></banner>
</template>

<script>
    import bannersData from './banners.json'
    import Banner from './Banner'

    export default {
        name: "BannerHomeNew",

        components: {
            Banner
        },

        data() {
            return {
                data: bannersData.find(item => item.id === 3)
            }
        }
    }
</script>
