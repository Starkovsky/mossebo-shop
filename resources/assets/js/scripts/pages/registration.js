import Core from '../core'
import FormSender from '../FormSender'

window.addEventListener('DOMContentLoaded', () => {
    let registrationFormEl = document.querySelector('.js-registration-form')

    if (registrationFormEl) {
        let formSender = new FormSender(registrationFormEl)

        formSender.on('done', data => {
            if (data && data.status === 'success') {
                Core.metrika.reachGoal('register')
                    .then(() => window.location.href = data._redirect)
            }
        })
    }
})
