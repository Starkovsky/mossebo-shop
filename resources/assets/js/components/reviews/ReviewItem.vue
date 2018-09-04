<template>
    <div class="review-item block-ui">
        <div class="review-item__menu" v-if="canEdit">
            <div class="row align-content-center">
                <div class="row-auto">
                    <div class="review-item-menu">
                        <div class="review-item-menu__button js-ht">
                            <svg class="review-item-menu__icon">
                                <use xlink:href="/assets/images/icons.svg#symbol-kebab-horizontal"></use>
                            </svg>
                        </div>

                        <div class="ht-container ht-container--popup ht-container--review">
                            <div class="ht-inner">
                                <div class="review-item-menu__link" @click="edit">
                                    {{ $root.translate('Edit') }}
                                </div>

                                <div class="review-item-menu__link" @click="remove">
                                    {{ $root.translate('Delete') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 review-item__left">
                <div class="review-item__top">
                    <div>
                        <div class="review-item__rating">
                            <rating
                                :rate="review.rate"
                                :hideNum="true"
                                class-name-modificators="lg"
                            ></rating>
                        </div>
                    </div>

                    <div class="review-item__name">
                        {{ review.user_name }}
                    </div>

                    <div v-html="formattedDate" class="review-item__date"></div>
                </div>

                <div v-if="unconfirmed" class="review-item__unconfirmed">
                    <span class="on-moderation">
                        {{ $root.translate('On moderation') }}
                    </span>
                </div>
            </div>

            <div class="col-md-9 review-item__right">
                <div class="review-item__text">
                    <div class="review-content">
                        <template v-if="review.item">
                            <div class="review-content__title">
                                <span class="review-content__label">
                                    {{ $root.translate('Review about') }}
                                </span>

                                <a :href="getItemLink(review.item)" class="link" target="_blank">
                                    {{ review.item.title }}
                                </a>
                            </div>
                        </template>

                        <template v-if="review.advantages">
                            <div class="review-content__label">
                                {{ $root.translate('Advantages') }}
                            </div>

                            <div class="review-content__text">
                                {{ review.advantages }}
                            </div>
                        </template>

                        <template v-if="review.disadvantages">
                            <div class="review-content__label">
                                {{ $root.translate('Disadvantages') }}
                            </div>

                            <div class="review-content__text">
                                {{ review.disadvantages }}
                            </div>
                        </template>

                        <template v-if="review.comment">
                            <div class="review-content__label" v-if="review.advantages || review.disadvantages">
                                {{ $root.translate('Comment') }}
                            </div>

                            <div class="review-content__text">
                                {{ review.comment }}
                            </div>
                        </template>
                    </div>
                </div>

                <div v-if="review.id" class="review-item__likes">
                    <likes
                        :url="likesUrl"
                        :likes.sync="review.likes.likes"
                        :dislikes.sync="review.likes.dislikes"
                        :liked.sync="review.likes.liked"
                        :disliked.sync="review.likes.disliked"
                        :canClick="isAuthorized"
                    ></likes>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Core from '../../scripts/core'
    import Rating from '../Rating'
    import Likes from '../Likes'
    import Alerty from '../../scripts/Alerty'

    export default {
        name: 'ReviewItem',

        components: {
            Rating,
            Likes
        },

        props: [
            'review',
        ],

        mounted() {
            setTimeout(() => {
                let htEl = this.$el.querySelector('.js-ht')

                if (htEl) {
                    this.ht = heightToggle(htEl, {
                        bindCloseEvents: true
                    })
                }
            }, 1000)
        },

        beforeDestroy() {
            if (this.ht) {
                this.ht.destroy()
            }
        },

        methods: {
            edit() {
                this.$emit('edit')
            },

            remove() {
                // todo: перевести
                let message = new Alerty({
                    message: 'Вы уверены, что хотите удалить отзыв?',
                    buttons: [
                        {
                            text: 'Да',
                            onclick: () => {
                                this.$emit('delete')
                                message.close()
                            },
                            class: 'button button-light'
                        },

                        {
                            text: 'Нет',
                            onclick: () => message.close(),
                            class: 'button button-light'
                        }
                    ]
                })
            },

            getItemLink(item) {
                if (item.type === 'good') {
                    return Core.siteUrl('goods/' + item.id)
                }
            }
        },

        computed: {
            likesUrl() {
                return Core.siteUrl('like/review/' + this.review.id)
            },

            isAuthorized() {
                return this.$root.isAuthorized()
            },

            canEdit() {
                return this.review.uid === this.$root.userId()
            },

            formattedDate() {
                return formatDate(this.review.created)
            },

            unconfirmed() {
                return this.review.unconfirmed
            }
        }
    }
</script>
