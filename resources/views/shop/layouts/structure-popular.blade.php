<div class="container">
    <div class="row">
        @foreach($items as $item)
            @isset($item['miniature'])
                <div class="col popular-structure-item">
                    <a
                        class="popular-structure-card block-ui block-ui--with-hover"
                        href="{{ $item['url'] }}"
                        style="background-image: url('{{ imagePath($item['miniature']) }}')"
                    >
                        <span class="popular-structure-card__name">
                            {{ $item['title'] }}
                        </span>
                    </a>
                </div>
            @endisset
        @endforeach
    </div>
</div>

