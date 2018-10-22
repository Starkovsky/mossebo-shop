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
    import Core from '../scripts/core'
    import AnimatedSymbolChange from './AnimatedSymbolChange'
    import ClassNameWithModificators from '../mixins/ClassNameWithModificators'
    import RequestMixin from '../mixins/RequestMixin'

    export default {
        name: "Likes",

        mixins: [
            ClassNameWithModificators,
            RequestMixin
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
                this.abortRequest()

                this.sendRequest('post', Core.siteUrl(this.url), {
                    action: action,
                    value: this[action + '$']
                })
                    .success(response => {
                        for (let key in response.data.likes) {
                            let localKey = key + '$'

                            if (localKey in this) {
                                this[localKey] = response.data.likes[key]
                            }
                        }

                        this.sync()
                    })
                    .fail(response => {
                        let data = response.data

                        if ('message' in data && 'status' && data) {
                            Core.showMessage(data.message, {
                                type: data.status
                            })
                        }
                    })
                    .silent()
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
    }
</script>


