@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::rows.header', ['url' => config('app.url'), 'locale' => $locale])
            {{ config('app.name') }}
        @endcomponent
    @endslot

    # {!! $title !!}

    {{-- Content --}}
    @foreach ($content as $line)

        @if(is_array($line))
            @php($key = key($line))
            @component('mail::lines.' . $key, $line[$key])
            @endcomponent
        @else
            {!! $line !!}
        @endif
    @endforeach

    {{-- Image --}}
    @slot('actionImage')
        @isset($actionImage)
            @component('mail::rows.action-image', $actionImage)
            @endcomponent
        @endisset
    @endslot

    {{-- Button --}}
    @slot('actionButton')
        @isset($actionButton)
            @component('mail::rows.action-button', $actionButton)
            @endcomponent
        @endisset
    @endslot

    {{-- Socials --}}
    @slot('socials')
        @isset($socials)
            @component('mail::rows.socials', ['socials' => $socials])
            @endcomponent
        @endisset
    @endslot

    @slot('footer')
        @isset($footerText)
            @component('mail::rows.footer')
                {!! $footerText !!}
            @endcomponent
        @endisset
    @endslot
@endcomponent
