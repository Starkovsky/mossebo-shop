<template>
    <div :class="{'reviews-pallete': true, 'no-reviews': reviewsNum === 0}">
        <div class="reviews-pallete__wrap js-reviews-wrap">
            <div>
                <div v-if="! (loading || error)" class="reviews-pallete__controls">
                    <div class="reviews-control-panel">
                        <div class="row row--no-padding">
                            <div class="col-md-6 reviews-control-panel__left">
                                <div v-if="! hideButton" class="reviews-control-panel__button">
                                    <div class="review-invocation">
                                        <div class="review-invocation__button">
                                            <template v-if="$root.isAuthorized()">
                                                <template v-if="unconfirmed">
                                                    <button-icon
                                                        class="button-primary"
                                                        icon="symbol-create"
                                                        @click="edit(unconfirmed)"
                                                        :disabled="panelDisabled"
                                                    >
                                                        Изменить отзыв
                                                    </button-icon>
                                                </template>

                                                <template v-else>
                                                    <button-icon
                                                        class="button-primary"
                                                        icon="symbol-create"
                                                        @click="toForm"
                                                        :disabled="panelDisabled"
                                                    >
                                                        Оставить отзыв
                                                    </button-icon>
                                                </template>
                                            </template>

                                            <template v-else>
                                                <button-icon
                                                    class="button-primary"
                                                    icon="symbol-auth"
                                                    @click="toLogin"
                                                    :disabled="panelDisabled"
                                                >
                                                    Войдите, чтобы оставить отзыв
                                                </button-icon>
                                            </template>
                                        </div>

                                        <div v-if="reviewsNum === 0 && activeStep !== 'form'" class="review-invocation__caption">
                                            <svg class="review-invocation__arrow">
                                                <use xlink:href="/assets/images/icons.svg#review-invocation-arrow"></use>
                                            </svg>

                                            <span class="review-invocation__label">
                                                Станьте первым кто напишет
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 reviews-control-panel__right">
                                <div class="reviews-control-panel__num">
                                    <template v-if="reviewsNum === 0">
                                        Пока нет отзывов
                                    </template>

                                    <template v-else>
                                        <span v-html="reviewsNumLabel"></span>
                                    </template>
                                </div>

                                <div class="reviews-control-panel__sort">
                                    <div class="reviews-sort">
                                        <div class="reviews-sort__sort">
                                            <multi-select
                                                :value="multiselectActiveSortType"
                                                :options="multiselectSortTypes"
                                                :max-height="300"
                                                :searchable="false"
                                                :hide-selected="false"
                                                :multiple="false"
                                                :allow-empty="false"
                                                @select="setSortType"
                                                :disabled="reviewsNum === 0 || panelDisabled"
                                            >
                                                <template slot="option" slot-scope="props">
                                                    {{ props.option.title }}
                                                </template>

                                                <template slot="singleLabel" slot-scope="props">
                                                    {{ props.option.title }}
                                                </template>
                                            </multi-select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="reviews-pallete__content">
                <!--<transition-->
                    <!--:name="animationName"-->
                    <!--@before-leave="beforeLeave"-->
                    <!--@enter="enter"-->
                    <!--@after-enter="afterEnter"-->
                <!--&gt;-->
                    <div
                        v-if="isActive('list')"
                        key="list"
                        class="reviews-pallete__item"
                    >
                        <loading :loading="loading" :no-overlay="true">
                            <template v-if="!loading">
                                <template v-if="error">
                                    <server-error
                                        :error="error"
                                        @retry="retry"
                                    ></server-error>
                                </template>

                                <template v-else>
                                    <reviews-list
                                        :url="url"
                                        :hide-button="hideButton"
                                        @edit="edit"
                                    ></reviews-list>
                                </template>
                            </template>
                        </loading>
                    </div>

                    <div
                        v-if="isActive('form')"
                        key="form"
                        class="reviews-pallete__item"
                    >
                        <review-form
                            class="block-ui"
                            :url="url"
                            :title="title"
                            @cancel="toList"
                        ></review-form>
                    </div>
                <!--</transition>-->
            </div>
        </div>
    </div>
</template>

<script>
    import { mapState } from 'vuex'

    import Loading from '../Loading'
    import ServerError from '../ServerError'
    import ReviewForm from './ReviewForm'
    import ReviewsList from './ReviewsList'
    import ButtonIcon from '../buttons/ButtonIcon'
    import MultiSelect from 'vue-multiselect'
    import SmoothScroll from '../../scripts/SmoothScroll'
    import Core from '../../scripts/core'

    export default {
        name: 'Reviews',

        components: {
            Loading,
            ServerError,
            ReviewForm,
            ReviewsList,
            ButtonIcon,
            MultiSelect
        },

        props: [
            'url',
            'title',
            'hideButton'
        ],

        created() {
            this.$store.dispatch('reviews/init')
        },

        beforeDestroy() {
            this.$store.dispatch('reviews/destroy')
        },

        methods: {
            isActive(step) {
                return this.activeStep === step
            },

            getWrapEl() {
                return this.$el.querySelector('.js-reviews-wrap')
            },

            beforeLeave(el) {
                let wrapEl = this.getWrapEl()
                wrapEl.classList.add('animation-in-process')

                this.$nextTick(() => {
                    wrapEl.style.height = el.clientHeight + 'px'
                })
            },

            enter(el) {
                let wrapEl = this.getWrapEl()

                this.$nextTick(() => {
                    wrapEl.style.height = el.clientHeight + 'px'
                })
            },

            afterEnter() {
                let wrapEl = this.getWrapEl()
                wrapEl.classList.remove('animation-in-process')

                this.$nextTick(() => {
                    wrapEl.style.height = 'auto'
                })
            },

            setSortType(type) {
                this.$store.dispatch('reviews/list/setSortType', type.key)
            },

            edit(review) {
                this.scroll(() => this.$store.dispatch('reviews/editReview', review))
            },

            toForm() {
                this.scroll(() => this.$store.dispatch('reviews/toForm'))
            },

            toList() {
                this.scroll(() => this.$store.dispatch('reviews/cancelForm'))
            },

            toLogin() {
                window.location.href = Core.siteUrl('login')
            },

            scroll(cb) {
                let wrapEL = this.getWrapEl()

                if (SmoothScroll.scrollIsNeed(wrapEL)) {
                    SmoothScroll.scroll(wrapEL, null, () => {
                        setTimeout(() => {
                            cb()
                        }, 200)
                    })
                }
                else {
                    cb()
                }
            }
        },

        computed: {
            ... mapState({
                loading: state => state.reviews.list.loading,
                error: state => state.reviews.list.error,
                steps: state => state.reviews.steps,
                animationName: state => 'slide-' + state.checkout.direction,
                activeStep: state => state.reviews.active,
                activeSortType: state => state.reviews.list.sort.active,

                unconfirmed: state => state.reviews.list.reviews.find(review => review.unconfirmed),

                multiselectSortTypes: state => {
                    let types = state.reviews.list.sort.types

                    return Object.keys(types).map(key => ({
                        key,
                        title: types[key]
                    }))
                },

                reviewsNum: state => state.reviews.list.reviews.length
            }),

            multiselectActiveSortType() {
                return this.multiselectSortTypes.filter(type => type.key === this.activeSortType)
            },

            panelDisabled() {
                return this.activeStep !== 'list'
            },

            reviewsNumLabel() {
                return this.reviewsNum + '&nbsp;' + declOfNum(this.reviewsNum, ['отзыв', 'отзыва', 'отзывов'])
            }
        }
    }
</script>
