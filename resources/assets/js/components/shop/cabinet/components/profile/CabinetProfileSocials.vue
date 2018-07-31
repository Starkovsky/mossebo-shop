<template>
    <div class="auth-socials auth-socials--profile">
        <div class="auth-socials__container">
            <template v-for="social in socials$">
                <div class="auth-socials__item">
                    <button
                        @click="click(social)"
                        :class="{['auth-social-btn auth-social-btn--circle auth-social-btn--small auth-social-btn--' + social.key]: true, unused: !social.active}"
                        data-toggle="tooltip"
                        data-placement="top"
                        :title="social.active ? 'Отвязать' : 'Привязать'"
                        :data-original-title="social.active ? 'Отвязать' : 'Привязать'"
                    >
                        <svg :class="`symbol-icon social-embed-${social.key}`">
                            <use :xlink:href="`/assets/images/icons.svg#social-embed-${social.key}`"></use>
                        </svg>
                    </button>
                </div>
            </template>
        </div>
    </div>
</template>

<script>
    import Request from '../../../../../scripts/Request'
    import Core from '../../../../../scripts/core/index'
    import RequestMixin from '../../../../../mixins/RequestMixin'

    export default {
        name: 'CabinetProfileSocials',

        mixins: [
            RequestMixin
        ],

        props: [
            'socials'
        ],

        watch: {
            'socials': 'updateSocialsActivityStatus'
        },

        data() {
            return {
                socials$: [
                    {
                        key: 'vk',
                        link: '/login/vkontakte',
                        provider: 'vkontakte',
                        active: false
                    },
                    {
                        key: 'ok',
                        link: '/login/odnoklassniki',
                        provider: 'odnoklassniki',
                        active: false
                    },
                    {
                        key: 'fb',
                        link: '/login/facebook',
                        provider: 'facebook',
                        active: false
                    },
                    {
                        key: 'google',
                        link: '/login/google',
                        provider: 'google',
                        active: false
                    },
                ]
            }
        },

        created() {
            this.updateSocialsActivityStatus()
        },

        mounted() {
            this.$root.initTooltips()
        },

        methods: {
            click(social) {
                if (social.active) {
                    this.detach(social)
                }
                else {
                    window.location.href = social.link
                }
            },

            detach(social) {
                this.sendRequest('delete', Core.siteUrl('/cabinet/socials'), {
                    provider: social.provider
                })
                    .success(response => {
                        this.setSocialsActivityStatus(response.data.socials)
                    })
            },

            check() {
                this.sendRequest('get', Core.siteUrl('/cabinet/socials'))
                    .success(response => {
                        this.setSocialsActivityStatus(response.data.socials)
                    })
            },

            updateSocialsActivityStatus() {
                this.setSocialsActivityStatus(this.socials)
            },

            setSocialsActivityStatus(activeSocials = []) {
                this.socials$ = this.socials$.map(social => {
                    return {
                        ... social,
                        active: activeSocials.indexOf(social.provider) !== -1
                    }
                })
            },
        }
    }
</script>
