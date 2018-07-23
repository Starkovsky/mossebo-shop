<template>
    <div class="reviews-list">
        <loading :loading="loading">
            <server-error
                :error="error && !loading"
                @retry="retry"
            ></server-error>

            <template v-if="!loading">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="reviews-list-panel">
                            <div class="reviews-list-panel__button">
                                <template v-if="$root.isAuthorized()">
                                    <template v-if="unconfirmed">
                                        <button class="button button-primary" @click="edit(unconfirmed)">
                                            Изменить отзыв
                                        </button>
                                    </template>

                                    <template v-else>
                                        <button class="button button-primary" @click="toForm">
                                            Оставить отзыв
                                        </button>
                                    </template>
                                </template>

                                <template v-else>
                                    {{ $root.translate('Please, sign in to post a review') }}
                                </template>
                            </div>

                            <div v-if="reviews.length > 1" class="reviews-list-panel__sort">
                                <div class="reviews-list-sort">
                                    <div class="reviews-list-sort__label">
                                        {{ $root.translate('Sort by')}}:
                                    </div>

                                    <div class="reviews-list-sort__sort">
                                        <multi-select
                                            :value="multiselectActiveSortType"
                                            :options="multiselectSortTypes"
                                            :max-height="300"
                                            :searchable="false"
                                            :hide-selected="false"
                                            :multiple="false"
                                            :allow-empty="false"
                                            @select="setSortType"
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

                        <template v-for="review in reviews$">
                            <review-item
                                :key="'review-' + review.id"
                                :review="review"
                                @edit="edit(review)"
                                @delete="remove(review)"
                            ></review-item>
                        </template>

                        <button
                            v-if="moreBtnIsVisible"
                            class="catalog-more-btn block-ui js-more-btn"
                            @click="showAll"
                        >
                            {{ $root.translate('Show all') }}
                        </button>
                    </div>

                    <div class="col-lg-4 d-none d-lg-block">
                        <div class="reviews-statistics block-ui">
                            <div class="reviews-statistics__item">
                                <span class="reviews-statistics__num">
                                    5
                                </span>

                                <div class="reviews-statistics__rating">
                                    <rating
                                        :rate="5"
                                        :num="statistics[5]"
                                        class-name-modificators="reviews-statistics"
                                    ></rating>
                                </div>
                            </div>
                            <div class="reviews-statistics__item">
                                <span class="reviews-statistics__num">
                                    4
                                </span>

                                <div class="reviews-statistics__rating">
                                    <rating
                                        :rate="4"
                                        :num="statistics[4]"
                                        class-name-modificators="reviews-statistics"
                                    ></rating>
                                </div>
                            </div>
                            <div class="reviews-statistics__item">
                                <span class="reviews-statistics__num">
                                    3
                                </span>

                                <div class="reviews-statistics__rating">
                                    <rating
                                        :rate="3"
                                        :num="statistics[3]"
                                        class-name-modificators="reviews-statistics"
                                    ></rating>
                                </div>
                            </div>
                            <div class="reviews-statistics__item">
                                <span class="reviews-statistics__num">
                                    2
                                </span>

                                <div class="reviews-statistics__rating">
                                    <rating
                                        :rate="2"
                                        :num="statistics[2]"
                                        class-name-modificators="reviews-statistics"
                                    ></rating>
                                </div>
                            </div>
                            <div class="reviews-statistics__item">
                                <span class="reviews-statistics__num">
                                    1
                                </span>

                                <div class="reviews-statistics__rating">
                                    <rating
                                        :rate="1"
                                        :num="statistics[1]"
                                        class-name-modificators="reviews-statistics"
                                    ></rating>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </loading>
    </div>
</template>

<script>
    import { mapState } from 'vuex'
    import Loading from '../Loading'
    import ServerError from '../ServerError'
    import ReviewItem from './ReviewItem'
    import Rating from '../Rating'
    import MultiSelect from 'vue-multiselect'
    import SmoothScroll from '../../scripts/SmoothScroll'

    export default {
        name: 'ReviewsList',

        props: [
            'url'
        ],

        components: {
            Loading,
            ServerError,
            ReviewItem,
            Rating,
            MultiSelect
        },

        methods: {
            retry() {
                this.$store.dispatch('reviews/list/reFetch')
            },

            setSortType(type) {
                this.$store.dispatch('reviews/list/setSortType', type.key)
            },

            showAll() {
                this.$store.dispatch('reviews/list/all')
            },

            edit(review) {
                this.$store.dispatch('reviews/editReview', review)
            },

            remove(review) {
                this.$store.dispatch('reviews/removeReview', review)
            },

            toForm() {
                SmoothScroll.scrollIfItNeeds(this.$el.closest('.js-product-tabs'), null, () => {
                    this.$store.dispatch('reviews/toForm')
                })
            }
        },

        computed: {
            ... mapState({
                loading: state => state.reviews.list.loading,
                error: state => state.reviews.list.error,
                reviews: state => state.reviews.list.reviews,
                all: state => state.reviews.list.all,
                multiselectSortTypes: state => {
                    let types = state.reviews.list.sort.types
                    return Object.keys(types).map(key => ({
                        key,
                        title: types[key]
                    }))
                },
                activeSortType: state => state.reviews.list.sort.active,

            }),

            unconfirmed() {
                return this.reviews.find(review => review.unconfirmed)
            },

            multiselectActiveSortType() {
                return this.multiselectSortTypes.filter(type => type.key === this.activeSortType)
            },

            reviews$() {
                if (this.all || this.reviews.length < 3) {
                    return this.reviews
                }
                else {
                    return this.reviews.slice(0, 2)
                }
            },

            moreBtnIsVisible() {
                return this.reviews$.length !== this.reviews.length
            },

            statistics() {
                return this.reviews.reduce((acc, review) => {
                    if (!review.unconfirmed) {
                        acc[review.rate]++
                    }

                    return acc
                }, {1: 0, 2:0, 3:0, 4:0, 5:0})
            }
        }
    }
</script>
