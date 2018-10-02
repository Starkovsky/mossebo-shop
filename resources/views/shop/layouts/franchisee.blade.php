<div class="franchisee-screen js-franchisee-screen">
    <div class="franchisee-screen__content">
        <svg class="franchisee-screen__logo">
            <use xlink:href="/assets/images/icons.svg#symbol-logo-{{ App::getLocale() }}"></use>
        </svg>

        <div class="franchisee-screen__button">
            <button class="button button-shadow js-franchisee-button">
                Разблокировать
            </button>
        </div>
    </div>
</div>

<script>
    window.addEventListener('DOMContentLoaded', function() {
        let screenEl = document.querySelector('.js-franchisee-screen')
        let buttonEl = document.querySelector('.js-franchisee-button')
        let timeout

        if (! (screenEl && buttonEl)) return

        function hideScreen() {
            screenEl.classList.add('hidden')
            window.addEventListener('click', resetTimeout)
            window.addEventListener('scroll', resetTimeout)
            window.addEventListener('keydown', resetTimeout)
            window.addEventListener('touchstart', resetTimeout)
            resetTimeout()
        }

        function resetTimeout() {
            clearTimeout(timeout)

            timeout = setTimeout(function() {
                showScreen()
            }, 1000 * 5 * 60)
        }

        function showScreen() {
            window.removeEventListener('click', resetTimeout)
            window.removeEventListener('scroll', resetTimeout)
            window.removeEventListener('keydown', resetTimeout)
            window.removeEventListener('touchstart', resetTimeout)
            screenEl.classList.remove('hidden')
        }

        buttonEl.addEventListener('click', function() {
            hideScreen()
        })
    })
</script>
