<template>
    <div class="badges">
        <div class="badges__container">
            <div v-for="badge in badges$" :key="badge.id" class="badges__item">
                <badge
                    :icon="badge.icon"
                    :color="badge.color"
                    :title="badge.title"
                ></badge>
            </div>
        </div>
    </div>
</template>

<script>
    import Badge from './Badge'
    import DataHandler from '../../../scripts/DataHandler'

    export default {
        name: 'badges',

        props: {
            badges: {
                default() {
                    return []
                }
            }
        },

        data() {
            return {
                badges$: []
            }
        },

        components: {
            Badge
        },

        created() {
            DataHandler.get('badge-types')
                .then(data => this.initBadges(data['badge-types']))
        },

        methods: {
            initBadges(badgeTypes) {
                this.badges$ = this.badges.reduce((acc, badgeId) => {
                    let badge = badgeTypes.find(badge => badge.id === badgeId)

                    if (badge) {
                        acc.push(badge)
                    }

                    return acc
                }, [])

                this.$nextTick(() => {
                    this.$root.initTooltips()
                })
            }
        }
    }
</script>
