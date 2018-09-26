@php
    function getPointClassModificators($point)
    {
        $modificators = [];

        $modificators[] =  $point->position_y > 50 ? 'top' : 'bottom';
        $modificators[] =  $point->position_x > 50 ? 'left' : 'right';

        if ($point->is_similar) {
            $modificators[] = 'similar';
        }

        $modificators = array_map(function($modif) {
            return 'interior-point--' . $modif;
        }, $modificators);

        return implode(' ', $modificators);
    }
@endphp
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
</head>
<body>
    <div class="js-interior">
        <div class="interior">
            <img class="interior__image" src="//admin.mossebo.market{{ $image }}" alt="{{ $title }}">

            @foreach ($points as $point)
                <div class="interior__point" style="top: {{ $point->position_y }}%; left: {{ $point->position_x }}%">
                    <div class="interior-point {{ getPointClassModificators($point) }}">
                        <div class="interior-point__center"></div>

                        @php ($pointImage = $point->product->getImage())

                        <div class="interior-point__legend">
                            <div class="product-preview">

                                <div class="product-preview__image-box">
                                    <img
                                        class="product-preview__image"
                                        src="//admin.mossebo.market{{ $pointImage['small']['src'] }}"
                                        srcset="//admin.mossebo.market{{ $pointImage['small']['srcset'] }} 2x"
                                    >
                                </div>

                                <div class="product-preview__name">
                                    {{ $point->product->title }}
                                </div>

                                <div class="product-preview__price">
                                    {{ $point->product->getPrice()->getFormatted() }}
                                </div>

                                <div class="product-preview__button">
                                    <a href="//mossebo.market/goods/{{ $point->product->id }}" class="button" target="_blank">
                                        Смотреть
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</body>
</html>



<style>
    *, *::before, *::after {
        box-sizing: border-box;
    }

    body {
        padding: 0;
        margin: 0;
        font-family: "Montserrat", Arial, sans-serif;
        overflow-x: hidden;
    }

    .interior {
        position: relative;
        display: inline-block;
        vertical-align: bottom;
    }

    .interior__image {
        max-width: 100%;
    }

    .interior__point {
        position: absolute;
        transform: translate3d(-18px,-18px,0);
        border-radius: 50%;
        z-index: 2;
        display: none;
    }

    .interior-point {
        position: relative;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        cursor: pointer;
        box-shadow: 0 0 20px rgba(0, 0, 0, .1);
    }

    .interior-point::before {
        width: 100%;
        height: 100%;
        margin-top: -14px;
        margin-left: -14px;
        z-index: 1;
        background-color: #fff;
        opacity: .5;
    }

    .interior-point::after {
        width: 16px;
        height: 16px;
        margin-top: -8px;
        margin-left: -8px;
        background-color: #fff;
        z-index: 2;
    }

    .interior-point__center {
        width: 10px;
        height: 10px;
        margin-left: -5px;
        margin-top: -5px;
        background-color: #323F4C;
        z-index: 3;
    }

    .interior-point__center::before {
        width: 4px;
        height: 4px;
        margin-top: -2px;
        margin-left: -2px;
        background-color: #FCC600;
        z-index: 3;
    }

    .interior-point::before,
    .interior-point::after,
    .interior-point__center,
    .interior-point__center::before {
        content: '';
        position: absolute;
        left: 50%;
        top: 50%;
        border-radius: 50%;
    }

    .interior-point:hover::before {
        animation-name: interior-point-animation;
        animation-duration: 1.4s;
        animation-delay: 1.2s;
        animation-iteration-count: infinite;
        animation-timing-function: linear;
        opacity: 0;
        transform: scale(2);
        transition: 1.2s;
    }

    .interior-point__legend {
        position: absolute;
        padding: 32px;
        visibility: hidden;
        opacity: 0;
    }

    .interior-point--left .interior-point__legend {
        right: 100%;
        margin-right: -32px;
    }

    .interior-point--right .interior-point__legend {
        left: 100%;
        margin-left: -32px;
    }

    .interior-point--top .interior-point__legend {
        bottom: 100%;
        margin-bottom: -32px;
    }

    .interior-point--bottom .interior-point__legend {
        top: 100%;
        margin-top: -32px;
    }

    .interior-point:hover .interior-point__legend {
        visibility: visible;
        opacity: 1;
    }

    @media only screen and (min-device-width: 768px) {
        .interior__point {
            display: block;
        }
    }


    .product-preview,
    .interior-point-loading {
        position: relative;
        min-height: 246px;
        width: 144px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 1px 2px rgba(0,0,0,.14);
        overflow: hidden;
        padding: 16px;
    }

    .interior-point-loading::before {
        content: '';
        position: absolute;
        left: 50%;
        top: 50%;
        margin-top: -25px;
        margin-left: -25px;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background-color: #FCC600;
        animation-name: interior-point-animation;
        animation-iteration-count: infinite;
        animation-duration: 1.4s;
        animation-timing-function: linear;
    }

    .product-preview {
        color: #323F4C;
    }

    .product-preview__image-box {
        width: 120px;
        height: 120px;
        display: flex;
        align-items: center;
    }

    .product-preview__image {
        max-width: 100%;
    }

    .product-preview__name {
        font-size: 12px;
        line-height: 16px;
        margin-top: 16px;
        max-height: 32px;
        overflow: hidden;
    }

    .product-preview__price {
        margin-top: 4px;
        font-size: 14px;
        line-height: 18px;
    }

    .product-preview__button {
        margin-top: 8px;
    }

    .product-preview .button {
        border-radius: 12px;
        border: 1px solid #323F4C;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 5px 8px;
        font-size: 10px;
        line-height: 14px;
        text-decoration: none;
        color: #323F4C;
    }

    .product-preview .button:hover {

    }
</style>

<script>
    window.addEventListener('DOMContentLoaded', () => {
        let el = document.querySelector('.js-interior')

        window.addEventListener('message', function(e) {
            if (typeof e.data === 'object' && 'iframe' in e.data) {
                e.source.postMessage({
                    iframe: e.data.iframe,
                    height: el.scrollHeight
                }, '*')
            }
        })
    })
</script>
