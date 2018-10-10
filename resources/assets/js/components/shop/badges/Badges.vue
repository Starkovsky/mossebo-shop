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
                if (this.badges instanceof Array && this.badges.length) {
                    if (this.badges[0] instanceof Object) {
                        this.badges$ = this.badges
                    }
                    else {
                        DataHandler.get('badge-types')
                            .then(data => this.initBadges(data['badge-types']))
                    }
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
                    let badge = badgeTypes.find(badge => badge.id === badgeId)

                    if (badge) {
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
