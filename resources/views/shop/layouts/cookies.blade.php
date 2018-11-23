@if(! Cookie::get('policy') && false)
    <div class="cookies-popup showed js-policy-popup">
        <div class="container">
            <div class="cookies-popup__popup">
                <div class="cookies-info block-ui">
                    <h3 class="cookies-info__title title-h3">
                        Cookie-файлы
                    </h3>

                    <div class="cookies-info__description">
                        На сайтах MOSSEBO используются cookie-файлы и другие аналогичные технологии. Если, прочитав это сообщение, вы остаетесь на нашем сайте, это означает, что вы не возражаете против использования этих технологий.
                    </div>

                    <div class="cookies-info__button">
                        <div class="button button-primary js-policy-button">
                            Да, согласен
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        window.addEventListener('DOMContentLoaded', function() {
            var popupEl = document.querySelector('.js-policy-popup');
            var buttonEl = document.querySelector('.js-policy-button');

            buttonEl.addEventListener('click', function() {
                popupEl.classList.remove('showed');
                MC.cookie.set('policy', 'confirmed')
            })
        })
    </script>
@endif
