<template>
    <div class="cabinet-profile content-w-menu">
        <div class="row row--no-padding">
            <div class="d-none d-lg-block col-lg-4">
                <div class="content-w-menu__menu">
                    <ul class="side-menu">
                        <template v-for="item in sideMenu">
                            <li class="side-menu__item">
                                <a
                                    :class="{'side-menu__link': true, [item.class || '']: true }"
                                    @click="menuClick(item)"
                                >
                                    {{ item.title }}
                                </a>
                            </li>
                        </template>
                    </ul>
                </div>
            </div>

            <div class="col-lg-8">
                <loading :loading="loading" no-overlay style="height: 100%">
                    <div class="content-w-menu__content">
                        <div v-if="!loading" class="profile-forms">
                            <div class="content-w-menu__item">
                                <cabinet-profile-personal
                                    :url="formUrl('cabinet/profile')"
                                    :data="data"
                                ></cabinet-profile-personal>
                            </div>

                            <!--<div class="content-w-menu__item" id="profile-payment-item">-->
                            <!--<h3 class="profile-forms__title title-h3">-->
                            <!--Способ оплаты-->
                            <!--</h3>-->

                            <!--<payment-choose-->
                            <!--:payments="paymentTypes"-->
                            <!--:active="data.payment"-->
                            <!--:choos="setPaymentType"-->
                            <!--&gt;</payment-choose>-->
                            <!--</div>-->

                            <div class="content-w-menu__item" id="profile-password-item">
                                <cabinet-profile-password
                                    :url="formUrl('cabinet/profile/password')"
                                ></cabinet-profile-password>
                            </div>

                            <div class="content-w-menu__item" id="profile-socials-item">
                                <h3 class="profile-forms__title title-h3">
                                    Социальные сети
                                </h3>

                                <cabinet-profile-socials
                                    :socials="data.socials"
                                ></cabinet-profile-socials>
                            </div>

                            <div class="profile-forms__bottom-btn">
                                <a href="/logout" class="profile-forms__quit-link">
                                    Выход
                                </a>
                            </div>
                        </div>
                    </div>
                </loading>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapState } from 'vuex'
    import SmoothScroll from "../../../../scripts/SmoothScroll"
    import PaymentChoose from '../../payment/PaymentChoose'
    import CabinetProfileSocials from './profile/CabinetProfileSocials'
    import CabinetProfilePersonal from './profile/CabinetProfilePersonal'
    import CabinetProfilePassword from './profile/CabinetProfilePassword'
    import Loading from '../../../Loading'
    import Core from '../../../../scripts/core'
    import FormValidationMixin from '../../../../mixins/FormValidation'
    import RequestMixin from '../../../../mixins/RequestMixin'

    export default {
        name: "CabinetProfile",

        mixins: [
            RequestMixin,
            FormValidationMixin
        ],

        components: {
            PaymentChoose,
            CabinetProfileSocials,
            CabinetProfilePersonal,
            CabinetProfilePassword,
            Loading,
        },

        data() {
            return {
                data: {},

                password: {
                    password: '',
                    password_new: '',
                    password_new_confirmation: '',
                },

                sideMenu: [
                    {
                        block: '#profile-personal-item',
                        title: 'Персональная информация',
                    },
                    {
                        block: '#profile-address-item',
                        title: 'Адрес доставки',
                    },
                    // {
                    //     block: '#profile-payment-item',
                    //     title: 'Способ оплаты',
                    // },
                    {
                        block: '#profile-password-item',
                        title: 'Изменение пароля',
                    },
                    {
                        block: '#profile-socials-item',
                        title: 'Социальные сети',
                    },
                    // {
                    //     link: '#',
                    //     title: 'Уведомления',
                    // },
                    // {
                    //     link: '#',
                    //     title: 'Помощь',
                    // },
                    {
                        link: '/logout',
                        title: 'Выход',
                        class: 'danger'
                    },
                ],


            }
        },

        created() {
            this.fetchData()
        },

        beforeDestroy() {
            this.abortRequest()
        },

        methods: {
            fetchData() {
                this.sendRequest('get', Core.siteUrl('/cabinet/profile'))
                    .success(response => {
                        this.data = response.data.profile
                    })
            },

            menuClick(item) {
                if ('block' in item) {
                    new SmoothScroll(item.block)
                    return
                }

                if ('link' in item) {
                    window.location.href = item.link
                }
            },

            setPaymentType(type) {
                this.data.payment = type
            },

            formUrl(url) {
                return Core.siteUrl(url)
            }
        },

        computed: {
            ... mapState({
                paymentTypes: state => {
                    return Object.keys(state.payments.types).reduce((acc, key) => {
                        acc[key] = state.payments.types[key].title
                        return acc
                    }, {})
                },
            })
        }
    }
</script>
