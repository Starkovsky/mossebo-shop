<template>
    <div class="review-form">
        <h3 class="review-form__title title-h3">
            Оставить отзыв на товар
        </h3>

        <div class="row">
            <div class="col-lg-8">
                <form class="review-form__form" :action="actionUrl" @submit="submit">
                    <div class="form-group js-form-group">
                        <label class="form-label">
                            Оценка
                        </label>

                        <div class="form-group-plug">
                            <div class="rating-select">
                                <input
                                    class="rating-select__input"
                                    id="review-rating-5"
                                    type="radio"
                                    name="rate"
                                    value="5"
                                    required
                                    :checked="data.rate == 5"
                                    @input="input"
                                >
                                <label class="rating-select__star" for="review-rating-5"></label>

                                <input
                                    class="rating-select__input"
                                    id="review-rating-4"
                                    type="radio"
                                    name="rate"
                                    value="4"
                                    required
                                    :checked="data.rate == 4"
                                    @input="input"
                                >
                                <label class="rating-select__star" for="review-rating-4"></label>

                                <input
                                    class="rating-select__input"
                                    id="review-rating-3"
                                    type="radio"
                                    name="rate"
                                    value="3"
                                    required
                                    :checked="data.rate == 3"
                                    @input="input"
                                >
                                <label class="rating-select__star" for="review-rating-3"></label>

                                <input
                                    class="rating-select__input"
                                    id="review-rating-2"
                                    type="radio"
                                    name="rate"
                                    value="2"
                                    required
                                    :checked="data.rate == 2"
                                    @input="input"
                                >
                                <label class="rating-select__star" for="review-rating-2"></label>

                                <input
                                    class="rating-select__input"
                                    id="review-rating-1"
                                    type="radio"
                                    name="rate"
                                    value="1"
                                    required
                                    :checked="data.rate == 1"
                                    @input="input"
                                >
                                <label class="rating-select__star" for="review-rating-1"></label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group js-form-group mt-24">
                        <label for="review-form-advantages" class="form-label">
                            Достоинства
                        </label>

                        <input
                            id="review-form-advantages"
                            type="text"
                            class="form-input"
                            name="advantages"
                            placeholder="Что вам понравилось?"
                            maxlength="512"
                            :value="data.advantages"
                            @input="input"
                        >
                    </div>

                    <div class="form-group js-form-group mt-24">
                        <label for="review-form-disadvantages" class="form-label">
                            Недостатки
                        </label>

                        <input
                            id="review-form-disadvantages"
                            type="text"
                            class="form-input"
                            name="disadvantages"
                            placeholder="Что не так?"
                            maxlength="512"
                            :value="data.disadvantages"
                            @input="input"
                        >
                    </div>

                    <div class="form-group js-form-group mt-24">
                        <label for="review-form-comment" class="form-label">
                            Комментарий
                        </label>

                        <textarea
                            id="review-form-comment"
                            class="form-textarea"
                            name="comment"
                            placeholder="Опишите более подробно свой опыт"
                            maxlength="2048"
                            required
                            :value="data.comment"
                            @input="input"
                        ></textarea>
                    </div>

                    <div class="form-group js-form-group mt-24">
                        <label class="form-label">
                            Срок пользования
                        </label>

                        <div class="from-radio-group">
                            <input
                                class="from-radio-group__input"
                                id="usage-time-month"
                                type="radio"
                                name="usage_time"
                                value="month"
                                :checked="data.usage_time === 'month'"
                                @input="input"
                            >
                            <label class="from-radio-group__label" for="usage-time-month">
                                Месяц
                            </label>

                            <input
                                class="from-radio-group__input"
                                id="usage-time-half-year"
                                type="radio"
                                name="usage_time"
                                value="half-year"
                                :checked="data.usage_time === 'half-year'"
                                @input="input"
                            >
                            <label class="from-radio-group__label" for="usage-time-half-year">
                                Пол года
                            </label>

                            <input
                                class="from-radio-group__input"
                                id="usage-time-year"
                                type="radio"
                                name="usage_time"
                                value="year"
                                :checked="data.usage_time === 'year'"
                                @input="input"
                            >
                            <label class="from-radio-group__label" for="usage-time-year">
                                Год
                            </label>
                        </div>
                    </div>

                    <div class="form-control mt-48">
                        <div class="form-group">
                            <div class="row row--half">
                                <div class="col-auto">
                                    <div class="button button-light button--circle-to-normal" @click="toList">
                                        <svg class="button__icon">
                                            <use xlink:href="/assets/images/icons.svg#symbol-arrow-back"></use>
                                        </svg>

                                        <div class="button__content">
                                            Отмена
                                        </div>
                                    </div>
                                </div>

                                <div class="review-form__auto col-auto">
                                    <button-loading :loading="loading" tag="button" class="button button-primary">
                                        <template v-if="type === 'create'">
                                            Разместить отзыв
                                        </template>

                                        <template v-if="type === 'edit'">
                                            Изменить отзыв
                                        </template>
                                    </button-loading>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-lg-4 d-none d-lg-block">
                <div class="review-form__info-wrap">
                    <div class="review-form__info article">
                        <p>
                            Расскажите о своем опыте использования  этого товара.
                            Обратите внимание на качество, удобство модели и её соответствие заявленным характеристикам.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapState } from 'vuex'
    import Core from '../../scripts/core'
    import ButtonLoading from '../buttons/ButtonLoading'
    import SmoothScroll from '../../scripts/SmoothScroll'

    export default {
        name: 'ReviewForm',

        props: [
            'url'
        ],

        components: {
            ButtonLoading
        },

        methods: {
            input(e) {
                this.$store.dispatch('reviews/setFormValue', [e.target.name, e.target.value])
            },

            toList() {
                SmoothScroll.scrollIfItNeeds(this.$el.closest('.js-product-tabs'), null, () => {
                    this.$store.dispatch('reviews/cancelForm')
                })
            },

            submit(e) {
                e.preventDefault()

                this.$store.dispatch('reviews/sendForm')
            }
        },

        computed: {
            ... mapState({
                data: state => {
                    let formData = {}

                    state.reviews.form.eacher((key, value) => {
                        formData[key] = value
                    })

                    return formData
                },
                loading: state => state.reviews.form.loading,
                type: state => state.reviews.formReview ? 'edit' : 'create',
            }),

            actionUrl() {
                return Core.siteUrl(this.url)
            }
        }
    }
</script>
