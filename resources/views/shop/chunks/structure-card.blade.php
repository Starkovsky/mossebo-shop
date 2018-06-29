@if($item['products_count'])
    <a href="{{ $item['url'] }}" class="structure-card block-ui">
        <background-image-loader
            class="structure-card__image"
        {{ isset($item['image']) ? ':image="https://admin.mossebo.market' . $item['image']['oneHalf']['srcset'] . '"' : '' }}
            :screen="true"
        ></background-image-loader>

        <div class="structure-card__description">
            <div class="structure-card__name">
                {{ $item['title'] }}
            </div>

            <div class="structure-card__amount">
                {{ $item['more'] }}
            </div>
        </div>
    </a>
@else
    <div class="structure-card block-ui">
        <background-image-loader
            class="structure-card__image"
            {{ isset($item['image']) ? ':image="https://admin.mossebo.market' . $item['image']['oneHalf']['srcset'] . '"' : '' }}
            :screen="true"
        ></background-image-loader>

        <div class="structure-card__description">
            <div class="structure-card__name">
                {{ $item['title'] }}
            </div>

            <div class="structure-card__amount">
                {{ $item['more'] }}
            </div>
        </div>
    </div>
@endif