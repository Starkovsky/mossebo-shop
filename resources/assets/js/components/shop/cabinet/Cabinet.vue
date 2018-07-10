<template>
    <div class="cabinet block-ui">
        <div class="cabinet__tabs">
            <tabs
                :tabs="pages"
                :active="activePage"
            ></tabs>
        </div>
    </div>
</template>

<script>
    import { mapState } from 'vuex'
    import Tabs from '../../Tabs'

    export default {
        name: "Cabinet",

        components: {
            Tabs
        },

        computed: {
            ... mapState({
                pages: state => state.cabinet.pages,
                activePage: state => state.cabinet.pages
            }),
        }
    }
</script>
