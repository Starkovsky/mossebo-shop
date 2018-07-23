<template>
    <div class="likes">
        <div :class="{'likes__item': true, 'likes__item--is-active': liked$}" @click="like">
            <svg class="likes__icon">
                <use xlink:href="/assets/images/icons.svg#symbol-thumb-up"></use>
            </svg>

            <div class="likes__number">
                <animated-symbol-change
                    :value="likes$"
                ></animated-symbol-change>
            </div>
        </div>

        <div :class="{'likes__item': true, 'likes__item--is-active': disliked$}" @click="dislike">
            <svg class="likes__icon">
                <use xlink:href="/assets/images/icons.svg#symbol-thumb-down"></use>
            </svg>

            <div class="likes__number">
                <animated-symbol-change
                    :value="dislikes$"
                ></animated-symbol-change>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'
    import Core from '../scripts/core'
    import AnimatedSymbolChange from './AnimatedSymbolChange'
    import ClassNameWithModificators from '../mixins/ClassNameWithModificators'

    export default {
        name: "Likes",

        mixins: [
            ClassNameWithModificators
        ],

        components: {
            AnimatedSymbolChange
        },

        props: [
            'url',
            'likes',
            'dislikes',
            'liked',
            'disliked',
            'canClick'
        ],

        data() {
            return {
                likes$:    this.likes,
                dislikes$: this.dislikes,
                liked$:    this.liked,
                disliked$: this.disliked
            }
        },

        methods: {
            like() {
                if (!this.canClick) return

                if (this.disliked$) {
                    this.dislikes$--
                    this.disliked$ = false
                }

                if (this.liked$) {
                    this.likes$--
                    this.liked$ = false
                }
                else {
                    this.likes$++
                    this.liked$ = true
                }

                this.send('liked')
            },

            dislike() {
                if (!this.canClick) return

                if (this.liked$) {
                    this.likes$--
                    this.liked$ = false
                }

                if (this.disliked$) {
                    this.dislikes$--
                    this.disliked$ = false
                }
                else {
                    this.dislikes$++
                    this.disliked$ = true
                }

                this.send('disliked')
            },

            send(action) {
                this.cancel()

                axios.post(Core.siteUrl(this.url), {
                    action: action,
                    value: this[action + '$']
                }, {
                    cancelToken: new axios.CancelToken(c => this.requestCancel = c)
                })
                    .then(response => {
                        for (let key in response.data.likes) {
                            let localKey = key + '$'

                            if (localKey in this) {
                                this[localKey] = response.data.likes[key]
                            }
                        }

                        this.sync()

                        this.requestCancel = false
                    })
                    .catch(thrown => {
                        if (axios.isCancel(thrown)) return

                        let data = thrown.response.data

                        if ('message' in data) {
                            Core.showMessage(data.message, {
                                type: data.status
                            })
                        }
                    })
            },

            cancel() {
                if (this.requestCancel) {
                    this.requestCancel()
                }
            },

            sync() {
                ['likes', 'dislikes', 'liked', 'disliked'].forEach(key => {
                    let localKey = key + '$'

                    if (this[key] !== this[localKey]) {
                        this.$emit(`update:${key}`, this[localKey])
                    }
                })
            }
        },

        beforeDestroy() {
            this.cancel()
        },
    }
</script>


