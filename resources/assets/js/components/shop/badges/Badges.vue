<template>
    <div class="badges">
        <div class="badges__container">
            <div v-for="badge in badges$" :key="badge.id" class="badges__item">
                <badge
                    :icon="badge.icon"
                    :color="badge.color"
                    :title="badge.title"
                    :text="badge.text"
                    :class-name-modificators="badge.modif"
                    :no-tooltip="noTooltips"
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
            badges: null,
            noTooltips: null,
            useTitleAsText: null
        },

        data() {
            return {
                badges$: []
            }
        },

        components: {
            Badge
        },

        watch: {
            badges: 'updateBadges'
        },

        created() {
            if (! (this.badges instanceof Array && this.badges.length)) return

            this.updateBadges()
        },

        methods: {
            updateBadges() {
                if (this.badges) {
                    DataHandler.get('badge-types')
                        .then(data => this.initBadges(data['badge-types']))
                }
                else {
                    this.badges$ = []
                }
            },

            initBadges(badgeTypes) {
                if (! badgeTypes) {
                    return
                }

                this.badges$ = this.badges.reduce((acc, badgeId) => {
                    let badge = badgeId instanceof Object ? badgeId : badgeTypes.find(badge => badge.id === badgeId)

                    if (badge) {
                        badge = {
                            ... badge
                        }

                        if (! badge.text && this.useTitleAsText) {
                            badge.text = badge.title
                        }

                        acc.push(badge)
                    }

                    return acc
                }, [])

                this.$nextTick(() => {
                    this.$root.initTooltips()
                })
            },
        }
    }
</script>
