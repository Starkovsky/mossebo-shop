<template>
    <banner
        :id="data.id"
        :title="data.title"
        :link="data.link"
        :image="data.image"
    ></banner>
</template>

<script>
    import bannersData from './banners.json'
    import Banner from './Banner'

    export default {
        name: "BannerHomeStock",

        components: {
            Banner
        },

        data() {
            return {
                data: bannersData.find(item => item.id === 1)
            }
        }
    }
</script>



