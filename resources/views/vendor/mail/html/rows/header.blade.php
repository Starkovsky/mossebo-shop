<tr>
    <td>
        @component('mail::row', ['class' => 'header row-fw'])
            <a href="{{ url('/') }}" class="header__link">
                <img class="header__image" src="{{ asset('assets/images/emails/header/' . $locale . '/header.jpg') }}" alt="{{ $slot }}">
            </a>
        @endcomponent
    </td>
</tr>
